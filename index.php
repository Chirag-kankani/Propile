<?php
session_start();
// Redirect to dashboard if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProPile - Your Professional Portfolio Builder</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-content">
            <div class="logo-container">
                <div class="logo">
                    <span class="logo-text">ProPile</span>
                </div>
            </div>
            <h1 class="main-heading">ProPile</h1>
            <p class="tagline">Build your professional portfolio in minutes, not hours</p>
            
            <div class="welcome-buttons">
                <a href="login.php" class="btn btn-primary">Login</a>
                <a href="signup.php" class="btn btn-secondary">Sign Up</a>
            </div>
            
            <div class="welcome-features">
                <div class="feature">
                    <div class="feature-icon">📚</div>
                    <h3>Showcase Education</h3>
                    <p>Display your academic achievements and credentials</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">💼</div>
                    <h3>Build Portfolio</h3>
                    <p>Create an impressive portfolio to highlight your skills</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">🚀</div>
                    <h3>Feature Projects</h3>
                    <p>Show off your best work and GitHub repositories</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">💻</div>
                    <h3>LeetCode Profile</h3>
                    <p>Integrate your coding achievements and challenges</p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="assets/js/script.js"></script>
</body>
</html>