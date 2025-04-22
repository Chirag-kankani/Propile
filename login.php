<?php
session_start();
require_once 'config/database.php';

// Check if user is already logged in - redirect to dashboard if they are
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
$success = '';
$form_type_submitted = ''; // To track which form was last submitted for display purposes

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Check which form was submitted
    if (isset($_POST['form_type']) && $_POST['form_type'] === 'login') {
        // --- LOGIN LOGIC ---
        $form_type_submitted = 'login';
        $username = trim($_POST['username']); // Use the name from the new HTML input
        $password = $_POST['password']; // Use the name from the new HTML input
        
        // Basic validation
        if (empty($username) || empty($password)) {
            $error = "Please fill in all fields";
        } else {
            try {
                // Check if user exists (allow login with username or email)
                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
                $stmt->execute([$username, $username]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($password, $user['password'])) {
                    // Login successful
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error = "Invalid username/email or password";
                }
            } catch (PDOException $e) {
                error_log("Login DB Error: " . $e->getMessage()); // Log detailed error
                $error = "An error occurred. Please try again later."; // User-friendly error
            }
        }
        // --- END LOGIN LOGIC ---

    } elseif (isset($_POST['form_type']) && $_POST['form_type'] === 'register') {
        // --- SIGNUP LOGIC ---
        $form_type_submitted = 'register';
        $username = trim($_POST['register_username']); // Use the distinct name for register username
        $email = trim($_POST['register_email']);       // Use the distinct name for register email
        $password = $_POST['register_password'];       // Use the distinct name for register password
        // Note: The new HTML doesn't have a confirm password, but your PHP expects it. 
        // We should add it to the HTML for proper validation. For now, let's skip the check,
        // OR assume it was validated client-side (less secure). 
        // It's BEST to add the confirm password field back to the HTML.
        // $confirm_password = $_POST['confirm_password']; // Uncomment if you add the field

        // Basic validation (Add confirm password check back if you add the field)
        // if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        if (empty($username) || empty($email) || empty($password)) {
            $error = "Please fill in all registration fields";
        // } elseif ($password !== $confirm_password) { // Add back if field exists
        //     $error = "Passwords do not match";
        } elseif (strlen($password) < 6) {
            $error = "Password must be at least 6 characters long";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Please enter a valid email address";
        } else {
            try {
                // Check if username already exists
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
                $stmt->execute([$username]);
                if ($stmt->fetchColumn() > 0) {
                    $error = "Username already exists";
                } else {
                    // Check if email already exists
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
                    $stmt->execute([$email]);
                    if ($stmt->fetchColumn() > 0) {
                        $error = "Email already exists";
                    } else {
                        // Create new user
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        
                        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                        $stmt->execute([$username, $email, $hashed_password]);
                        
                        $user_id = $pdo->lastInsertId();
                        
                        // Create empty profile for the user
                        $stmt = $pdo->prepare("INSERT INTO profiles (user_id) VALUES (?)");
                        $stmt->execute([$user_id]);
                        
                        // Set success message - clear error
                        $success = "Account created successfully! You can now login.";
                        $error = ''; // Clear any previous error
                    }
                }
            } catch (PDOException $e) {
                error_log("Signup DB Error: " . $e->getMessage()); // Log detailed error
                $error = "An error occurred during registration. Please try again later."; // User-friendly error
            }
        }
        // --- END SIGNUP LOGIC ---
    } else {
         // Optional: Handle cases where form_type isn't set (shouldn't happen with correct HTML)
         $error = "Invalid form submission.";
    }
}

// Determine if the container should start in the 'active' (register) state
$container_active_class = '';
if ($form_type_submitted === 'register' && ($error || $success)) {
    // If registration was submitted and resulted in an error or success, show register panel
    $container_active_class = 'active';
} elseif ($success) {
    // If there's a success message (must be from registration), show login panel but with the message
    $container_active_class = ''; // Default to login after successful registration
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Update title dynamically maybe, or keep generic -->
    <title>Login / Signup - ProPile</title> 
    <!-- Add your favicon links if needed -->
    <link rel="icon" type="image/png" sizes="32x32" href="path/to/your/white_logo.png"> 
    <link rel="icon" type="image/png" sizes="64x64" href="path/to/your/white_logo.png">
    <!-- Link the NEW CSS file -->
    <link rel="stylesheet" href="assets/css/login_page.css"> 
    <!-- Link Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
      <!-- Add the 'active' class dynamically based on PHP logic -->
      <div class="container <?php echo $container_active_class; ?>"> 
          
          <!-- LOGIN FORM BOX -->
          <div class="form-box login">
              <!-- IMPORTANT: action="login.php" and method="POST" -->
              <form action="login.php" method="POST"> 
                  <!-- IMPORTANT: Hidden input to identify the form -->
                  <input type="hidden" name="form_type" value="login"> 
                  
                  <h1 style="color: #f56e0f; font-size: 45px;">Login</h1>

                   <!-- Display Login Errors Here -->
                   <?php if ($error && $form_type_submitted === 'login'): ?>
                       <p style="color: red; margin-bottom: 15px;"><?php echo htmlspecialchars($error); ?></p>
                   <?php endif; ?>
                    <!-- Display Success Message Here (after registration) -->
                   <?php if ($success): ?>
                       <p style="color: green; margin-bottom: 15px;"><?php echo htmlspecialchars($success); ?></p>
                   <?php endif; ?>


                  <div class="input-box">
                      <!-- IMPORTANT: name="username" -->
                      <input type="text" name="username" placeholder="Username or Email" required 
                             value="<?php echo ($form_type_submitted === 'login' && isset($_POST['username'])) ? htmlspecialchars($_POST['username']) : ''; ?>">
                      <i class='bx bxs-user'></i>
                  </div>
                  <div class="input-box">
                      <!-- IMPORTANT: name="password" -->
                      <input type="password" name="password" placeholder="Password" required>
                      <i class='bx bxs-lock-alt' ></i>
                  </div>
                  <div class="forgot-link">
                      <a href="#">Forgot Password?</a> <!-- Functionality for this needs to be added separately -->
                  </div>
                  <button type="submit" class="btn">Login</button>
                  <p>or login with social platforms</p>
                  <div class="social-icons">
                      <a href="#"><i class='bx bxl-google' ></i></a> <!-- Functionality needs to be added -->
                      <a href="#"><i class='bx bxl-facebook' ></i></a> <!-- Functionality needs to be added -->
                      <a href="#"><i class='bx bxl-github' ></i></a> <!-- Functionality needs to be added -->
                      <a href="#"><i class='bx bxl-linkedin' ></i></a> <!-- Functionality needs to be added -->
                  </div>
              </form>
          </div>

          <!-- REGISTRATION FORM BOX -->
          <div class="form-box register">
              <!-- IMPORTANT: action="login.php" and method="POST" -->
              <form action="login.php" method="POST">
                  <!-- IMPORTANT: Hidden input to identify the form -->
                  <input type="hidden" name="form_type" value="register"> 

                  <h1 style="color: #f56e0f;">Registration</h1>

                  <!-- Display Registration Errors Here -->
                  <?php if ($error && $form_type_submitted === 'register'): ?>
                       <p style="color: red; margin-bottom: 15px;"><?php echo htmlspecialchars($error); ?></p>
                  <?php endif; ?>

                  <div class="input-box">
                      <!-- IMPORTANT: Use distinct name, e.g., name="register_username" -->
                      <input type="text" name="register_username" placeholder="Username" required
                             value="<?php echo ($form_type_submitted === 'register' && isset($_POST['register_username'])) ? htmlspecialchars($_POST['register_username']) : ''; ?>">
                      <i class='bx bxs-user'></i>
                  </div>
                  <div class="input-box">
                       <!-- IMPORTANT: Use distinct name, e.g., name="register_email" -->
                      <input type="email" name="register_email" placeholder="Email" required
                             value="<?php echo ($form_type_submitted === 'register' && isset($_POST['register_email'])) ? htmlspecialchars($_POST['register_email']) : ''; ?>">
                      <i class='bx bxs-envelope' ></i>
                  </div>
                  <div class="input-box">
                       <!-- IMPORTANT: Use distinct name, e.g., name="register_password" -->
                      <input type="password" name="register_password" placeholder="Password" required>
                      <i class='bx bxs-lock-alt' ></i>
                  </div>
                   <!-- RECOMMENDED: Add Confirm Password Field -->
                   <!-- <div class="input-box">
                       <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                       <i class='bx bxs-lock-alt' ></i>
                   </div> -->
                  <button type="submit" class="btn">Register</button>
                  <p>or register with social platforms</p>
                  <div class="social-icons">
                     <a href="#"><i class='bx bxl-google' ></i></a> <!-- Functionality needs to be added -->
                      <a href="#"><i class='bx bxl-facebook' ></i></a> <!-- Functionality needs to be added -->
                      <a href="#"><i class='bx bxl-github' ></i></a> <!-- Functionality needs to be added -->
                      <a href="#"><i class='bx bxl-linkedin' ></i></a> <!-- Functionality needs to be added -->
                  </div>
              </form>
          </div>

          <!-- TOGGLE BOX (No changes needed here) -->
          <div class="toggle-box">
              <div class="toggle-panel toggle-left">
                  <h1>Hello, Welcome!</h1>
                  <p>Don't have an account?</p>
                  <button class="btn register-btn">Register</button>
              </div>

              <div class="toggle-panel toggle-right">
                  <h1>Welcome Back!</h1>
                  <p>Already have an account?</p>
                  <button class="btn login-btn">Login</button>
              </div>
          </div>
      </div>

      <!-- Link the NEW JS file -->
      <script src="assets/js/login_page.js"></script> 
</body>
</html>