<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Initialize variables to avoid errors if fetching fails or data is missing
$user = ['username' => 'User']; // Default username
$profile = ['bio' => '']; // Default empty profile data
$education = null; // Default education data
$projects = []; // Default empty projects array
$social_links = []; // Default empty social links array
$selected_template_name = 'minimal'; // Default template

try {
    // Get user information
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    // Get user profile (or create if needed - important!)
    $stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $profile = $stmt->fetch();

    // If profile doesn't exist, create a basic one
    if (!$profile) {
        $stmt_insert = $pdo->prepare("INSERT INTO profiles (user_id) VALUES (?)");
        $stmt_insert->execute([$user_id]);
        // Re-fetch the newly created profile
        $stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $profile = $stmt->fetch();
    }

    // Get education information (now expects only one row per user)
    $stmt = $pdo->prepare("SELECT * FROM education WHERE user_id = ? LIMIT 1");
    $stmt->execute([$user_id]);
    $education = $stmt->fetch(); // Fetch single row or false if none

    // Get projects
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $projects = $stmt->fetchAll();

    // Get social links
    $stmt = $pdo->prepare("SELECT * FROM social_links WHERE user_id = ?");
    $stmt->execute([$user_id]);
    foreach ($stmt->fetchAll() as $link) {
        $social_links[$link['platform']] = $link['url'];
    }

    // Get selected portfolio template name
    $stmt = $pdo->prepare("
        SELECT t.name FROM user_portfolios up
        JOIN portfolio_templates t ON up.template_id = t.id
        WHERE up.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $template_db_name = $stmt->fetchColumn(); // e.g., 'Modern Minimal', 'Developer Portfolio'

    if ($template_db_name) {
         // Map DB name back to the simple name used in form values/data attributes
         switch ($template_db_name) {
            case 'Developer Portfolio':
                $selected_template_name = 'developer';
                break;
            case 'Creative Portfolio':
                $selected_template_name = 'creative';
                break;
            case 'Modern Minimal':
            default:
                $selected_template_name = 'minimal';
                break;
        }
    }


} catch (PDOException $e) {
    // In a real app, log this error instead of dying
    error_log("Database error in dashboard.php: " . $e->getMessage());
    // Set default values or show a user-friendly error
    // For simplicity here, we continue with defaults set above
}

// Helper function to safely output data into HTML value attributes
function html_value($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

// Helper function to format date for 'month' input (YYYY-MM)
function format_for_month_input($date_str) {
    if (!empty($date_str)) {
        // Assuming date is stored as YYYY-MM-DD
        return substr($date_str, 0, 7); // Extract YYYY-MM
    }
    return '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ProPile</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <!-- Add specific dashboard styles if needed -->
    <style>
        /* Add styles from original dashboard.php if they are not in style.css */
        .dashboard { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background-color: var(--dark-void); color: var(--snow); padding: var(--spacing-3); display: flex; flex-direction: column; }
        .sidebar-logo .logo-text { font-size: 1.5rem; font-weight: 700; }
        .sidebar-links { margin-top: var(--spacing-4); flex-grow: 1; }
        .sidebar-link { display: block; padding: 10px 15px; color: var(--dusty-grey); text-decoration: none; border-radius: var(--border-radius-sm); margin-bottom: 5px; transition: var(--transition-fast); }
        .sidebar-link:hover, .sidebar-link.active { background-color: rgba(251, 251, 251, 0.1); color: var(--snow); }
        .sidebar-footer { margin-top: auto; }
        .main-content { flex-grow: 1; padding: var(--spacing-4); background-color: var(--gluon-grey); color: var(--snow); }
        .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-4); }
        .dashboard-header h1 { color: var(--snow); }
        .dashboard-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--spacing-3); margin-bottom: var(--spacing-5); }
        .dashboard-card { background-color: rgba(251, 251, 251, 0.05); padding: var(--spacing-3); border-radius: var(--border-radius-md); text-align: center; cursor: pointer; transition: var(--transition-medium); }
        .dashboard-card:hover { background-color: rgba(251, 251, 251, 0.1); transform: translateY(-3px); }
        .card-icon { font-size: 2rem; margin-bottom: var(--spacing-1); }
        .card-title { font-weight: 600; margin-bottom: 5px; }
        .card-desc { font-size: 0.9rem; color: var(--dusty-grey); }
        .profile-form { background-color: rgba(251, 251, 251, 0.05); border-radius: var(--border-radius-lg); padding: var(--spacing-4); }
        .form-header h2 { margin-bottom: var(--spacing-4); text-align: center; color: var(--liquid-lava); }
        .form-section { margin-bottom: var(--spacing-4); padding-bottom: var(--spacing-3); border-bottom: 1px solid rgba(251, 251, 251, 0.1); }
        .form-section:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .form-section-title { font-size: 1.25rem; font-weight: 600; margin-bottom: var(--spacing-3); color: var(--liquid-lava); }
        .form-field { margin-bottom: var(--spacing-3); }
        .form-label { display: block; margin-bottom: 8px; color: var(--dusty-grey); font-size: 0.9rem; }
        .form-input, .form-textarea { width: 100%; padding: 12px; background-color: rgba(251, 251, 251, 0.05); border: 1px solid rgba(251, 251, 251, 0.1); border-radius: var(--border-radius-sm); color: var(--snow); transition: var(--transition-fast); }
        .form-input:focus, .form-textarea:focus { outline: none; border-color: var(--liquid-lava); background-color: rgba(251, 251, 251, 0.1); }
        .form-textarea { resize: vertical; min-height: 80px; }
        .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--spacing-3); }
        .add-more-btn { background: none; border: 1px dashed var(--liquid-lava); color: var(--liquid-lava); padding: 8px 15px; border-radius: var(--border-radius-sm); cursor: pointer; transition: var(--transition-fast); }
        .add-more-btn:hover { background-color: rgba(245, 142, 15, 0.1); }
        .project-item { border: 1px solid rgba(251, 251, 251, 0.1); padding: var(--spacing-3); border-radius: var(--border-radius-md); margin-bottom: var(--spacing-3); position: relative; }
        .remove-project-btn { position: absolute; top: 10px; right: 10px; background: #ff4d4d; color: white; border: none; border-radius: 50%; width: 25px; height: 25px; cursor: pointer; font-weight: bold; line-height: 25px; text-align: center;}
        .template-selection { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--spacing-3); }
        .template-card { background-color: rgba(251, 251, 251, 0.08); border-radius: var(--border-radius-md); overflow: hidden; cursor: pointer; border: 2px solid transparent; transition: var(--transition-medium); }
        .template-card.selected { border-color: var(--liquid-lava); background-color: rgba(245, 142, 15, 0.1); }
        .template-img { height: 150px; background-color: var(--slate-grey); display: flex; align-items: center; justify-content: center; color: var(--snow); font-weight: 500; }
        .template-info { padding: var(--spacing-2); }
        .template-title { font-weight: 600; margin-bottom: 5px; }
        .template-desc { font-size: 0.85rem; color: var(--dusty-grey); line-height: 1.4; }
        .form-submit { width: 100%; padding: 15px; background-color: var(--liquid-lava); color: var(--snow); border: none; border-radius: var(--border-radius-sm); font-weight: 600; font-size: 1rem; cursor: pointer; transition: var(--transition-fast); margin-top: var(--spacing-4); }
        .form-submit:hover { background-color: #e07c00; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="sidebar-logo">
                <div class="logo">
                    <!-- Your Logo Here if you have one -->
                    <span class="logo-text">ProPile</span>
                </div>
            </div>

            <nav class="sidebar-links">
                <a href="dashboard.php" class="sidebar-link active">
                    <span>Home</span>
                </a>
                <a href="features.php" class="sidebar-link">
                    <span>Features</span>
                </a>
                 <a href="preview_portfolio.php" class="sidebar-link">
                    <span>Preview</span>
                </a>
                <!-- <a href="templates.php" class="sidebar-link">
                    <span>Templates</span>
                </a> -->
                <a href="about.php" class="sidebar-link">
                    <span>About Us</span>
                </a>
                <a href="contact.php" class="sidebar-link">
                    <span>Contact</span>
                </a>
                <!-- Optional: Direct link to form section -->
                <!-- <a href="#profile-form" class="sidebar-link get-started-btn">
                    <span>Edit Profile</span>
                </a> -->
            </nav>

            <div class="sidebar-footer">
                <a href="logout.php" class="sidebar-link">
                    <span>Logout</span>
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="dashboard-header">
                <h1>Welcome, <?php echo htmlspecialchars($user['username'] ?? 'User'); ?>!</h1>
                <!-- Optional "Get Started" button to scroll to form -->
                <a href="#profile-form" class="btn btn-primary">Edit Your Profile</a>
            </div>

            <!-- Overview Cards (Optional - can be removed if not needed) -->
            <div class="dashboard-cards">
                <div class="dashboard-card" onclick="document.getElementById('form-section-education').scrollIntoView({ behavior: 'smooth' });">
                    <div class="card-icon">📚</div>
                    <h3 class="card-title">Education</h3>
                    <p class="card-desc">Add your educational background.</p>
                </div>
                <div class="dashboard-card" onclick="document.getElementById('form-section-portfolio').scrollIntoView({ behavior: 'smooth' });">
                    <div class="card-icon">👤</div>
                    <h3 class="card-title">Bio & Links</h3>
                    <p class="card-desc">Add your bio and social links.</p>
                </div>
                <div class="dashboard-card" onclick="document.getElementById('form-section-projects').scrollIntoView({ behavior: 'smooth' });">
                    <div class="card-icon">🚀</div>
                    <h3 class="card-title">Projects</h3>
                    <p class="card-desc">Showcase your projects.</p>
                </div>
                 <div class="dashboard-card" onclick="document.getElementById('form-section-template').scrollIntoView({ behavior: 'smooth' });">
                    <div class="card-icon">🎨</div>
                    <h3 class="card-title">Template</h3>
                    <p class="card-desc">Choose your portfolio style.</p>
                </div>
            </div>

            <!-- Main Profile Form -->
            <div class="profile-form" id="profile-form">
                <div class="form-header">
                    <h2>Build Your Professional Profile</h2>
                </div>

                <form action="process_profile.php" method="POST">

                    <!-- ======================== -->
                    <!-- Education Section        -->
                    <!-- ======================== -->
                    <div class="form-section" id="form-section-education">
                        <h3 class="form-section-title">Education</h3>

                        <div class="form-field">
                            <label class="form-label" for="school">School/University</label>
                            <input type="text" class="form-input" id="school" name="school" placeholder="e.g., Harvard University" value="<?php echo html_value($education['institution'] ?? ''); ?>">
                        </div>

                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label" for="degree">Degree</label>
                                <input type="text" class="form-input" id="degree" name="degree" placeholder="e.g., Bachelor of Science" value="<?php echo html_value($education['degree'] ?? ''); ?>">
                            </div>

                            <div class="form-field">
                                <label class="form-label" for="field">Field of Study</label>
                                <input type="text" class="form-input" id="field" name="field" placeholder="e.g., Computer Science" value="<?php echo html_value($education['field'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label" for="start-date">Start Date</label>
                                <input type="month" class="form-input" id="start-date" name="start_date" value="<?php echo format_for_month_input($education['start_date'] ?? ''); ?>">
                            </div>

                            <div class="form-field">
                                <label class="form-label" for="end-date">End Date</label>
                                <input type="month" class="form-input" id="end-date" name="end_date" value="<?php echo format_for_month_input($education['end_date'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                    <!-- ======================== -->
                    <!-- End Education Section    -->
                    <!-- ======================== -->


                    <!-- ======================== -->
                    <!-- Portfolio/Bio Section    -->
                    <!-- ======================== -->
                    <div class="form-section" id="form-section-portfolio">
                        <h3 class="form-section-title">Portfolio Info & Links</h3>

                        <div class="form-field">
                            <label class="form-label" for="bio">Bio/About Me</label>
                            <textarea class="form-input form-textarea" id="bio" name="bio" rows="4" placeholder="Tell us about yourself, your skills, and your career goals"><?php echo html_value($profile['bio'] ?? ''); ?></textarea>
                        </div>

                        <div class="form-field">
                            <label class="form-label" for="portfolio-link">Portfolio Link (Optional external link)</label>
                            <input type="url" class="form-input" id="portfolio-link" name="portfolio_link" placeholder="https://your-other-portfolio.com" value="<?php echo html_value($social_links['portfolio'] ?? ''); ?>">
                        </div>

                         <div class="form-field">
                            <label class="form-label" for="leetcode-link">LeetCode Profile Link</label>
                            <input type="url" class="form-input" id="leetcode-link" name="leetcode_link" placeholder="https://leetcode.com/yourusername" value="<?php echo html_value($social_links['leetcode'] ?? ''); ?>">
                        </div>

                         <div class="form-field">
                            <label class="form-label" for="linkedin-link">LinkedIn Profile Link</label>
                            <!-- Make sure name matches what process_profile expects, e.g., social[linkedin] or just linkedin -->
                            <input type="url" class="form-input" id="linkedin-link" name="social[linkedin]" placeholder="https://linkedin.com/in/yourusername" value="<?php echo html_value($social_links['linkedin'] ?? ''); ?>">
                        </div>
                    </div>
                    <!-- ======================== -->
                    <!-- End Portfolio/Bio Section-->
                    <!-- ======================== -->


                    <!-- ======================== -->
                    <!-- Projects Section         -->
                    <!-- ======================== -->
                    <div class="form-section" id="form-section-projects">
                        <h3 class="form-section-title">Projects</h3>

                        <div id="projects-container">
                            <?php if (empty($projects)): ?>
                                <!-- Display one empty block if no projects exist -->
                                <div class="project-item">
                                     <button type="button" class="remove-project-btn" onclick="removeProject(this)" style="display: none;">×</button> <!-- Hide remove button for the first item initially -->
                                    <div class="form-row">
                                        <div class="form-field">
                                            <label class="form-label" for="project-name-1">Project Name</label>
                                            <input type="text" class="form-input project-name-input" id="project-name-1" name="project_name[]" placeholder="My Awesome Project">
                                        </div>
                                        <div class="form-field">
                                            <label class="form-label" for="project-link-1">GitHub Link</label>
                                            <input type="url" class="form-input" id="project-link-1" name="project_link[]" placeholder="https://github.com/yourusername/project">
                                        </div>
                                    </div>
                                    <div class="form-field">
                                        <label class="form-label" for="project-desc-1">Description</label>
                                        <textarea class="form-input form-textarea" id="project-desc-1" name="project_desc[]" rows="3" placeholder="Brief description of your project"></textarea>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php foreach ($projects as $index => $project): $item_id = $index + 1; ?>
                                    <div class="project-item">
                                         <button type="button" class="remove-project-btn" onclick="removeProject(this)" <?php echo ($index === 0 && count($projects) === 1) ? 'style="display: none;"' : ''; ?>>×</button>
                                        <div class="form-row">
                                            <div class="form-field">
                                                <label class="form-label" for="project-name-<?php echo $item_id; ?>">Project Name</label>
                                                <input type="text" class="form-input project-name-input" id="project-name-<?php echo $item_id; ?>" name="project_name[]" value="<?php echo html_value($project['title']); ?>">
                                            </div>
                                            <div class="form-field">
                                                <label class="form-label" for="project-link-<?php echo $item_id; ?>">GitHub Link</label>
                                                <input type="url" class="form-input" id="project-link-<?php echo $item_id; ?>" name="project_link[]" value="<?php echo html_value($project['github_link']); ?>">
                                            </div>
                                        </div>
                                        <div class="form-field">
                                            <label class="form-label" for="project-desc-<?php echo $item_id; ?>">Description</label>
                                            <textarea class="form-input form-textarea" id="project-desc-<?php echo $item_id; ?>" name="project_desc[]" rows="3"><?php echo html_value($project['description']); ?></textarea>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <button type="button" class="add-more-btn" id="add-project-btn">+ Add Another Project</button>
                    </div>
                    <!-- ======================== -->
                    <!-- End Projects Section     -->
                    <!-- ======================== -->


                     <!-- ======================== -->
                    <!-- Template Section        -->
                    <!-- ======================== -->
                    <div class="form-section" id="form-section-template">
                        <h3 class="form-section-title">Select a Template</h3>

                        <div class="template-selection">
                             <!-- Use data-template value that matches 'minimal', 'developer', 'creative' -->
                            <div class="template-card <?php echo ($selected_template_name === 'minimal') ? 'selected' : ''; ?>" data-template="minimal">
                                <div class="template-img">Minimal Template Preview</div>
                                <div class="template-info">
                                    <h4 class="template-title">Modern Minimal</h4>
                                    <p class="template-desc">Clean, minimalist design with focus on content</p>
                                </div>
                            </div>

                            <div class="template-card <?php echo ($selected_template_name === 'developer') ? 'selected' : ''; ?>" data-template="developer">
                                <div class="template-img">Developer Template Preview</div>
                                <div class="template-info">
                                    <h4 class="template-title">Developer Portfolio</h4>
                                    <p class="template-desc">Perfect for showcasing coding projects and skills</p>
                                </div>
                            </div>

                            <div class="template-card <?php echo ($selected_template_name === 'creative') ? 'selected' : ''; ?>" data-template="creative">
                                <div class="template-img">Creative Template Preview</div>
                                <div class="template-info">
                                    <h4 class="template-title">Creative Portfolio</h4>
                                    <p class="template-desc">Colorful and dynamic design for creative professionals</p>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden input to store the selected template's simple name -->
                        <input type="hidden" id="selected-template" name="selected_template" value="<?php echo html_value($selected_template_name); ?>">
                    </div>
                     <!-- ======================== -->
                    <!-- End Template Section     -->
                    <!-- ======================== -->


                    <!-- Submit Button -->
                    <div style="margin-top: 32px;">
                        <button type="submit" class="form-submit">Save and Update Portfolio</button>
                    </div>

                </form>
            </div><!-- End .profile-form -->
        </div><!-- End .main-content -->
    </div><!-- End .dashboard -->

    <!-- Include your main script file -->
    <script src="assets/js/script.js"></script>
    <!-- Add specific dashboard JS -->
    <script>
        // --- Project Add/Remove Logic ---
        const projectsContainer = document.getElementById('projects-container');
        const addProjectBtn = document.getElementById('add-project-btn');
        let projectCounter = projectsContainer.children.length; // Start counter based on existing items

        function updateRemoveButtons() {
            const items = projectsContainer.querySelectorAll('.project-item');
            items.forEach((item, index) => {
                const removeBtn = item.querySelector('.remove-project-btn');
                 if (removeBtn) {
                    // Show remove button only if it's not the last remaining item
                    removeBtn.style.display = items.length > 1 ? 'block' : 'none';
                }
                // Update IDs and labels to be unique if needed (optional but good practice)
                item.querySelectorAll('input, textarea').forEach(input => {
                    const baseId = input.id.replace(/-\d+$/, ''); // Get base ID like 'project-name'
                    const newId = `${baseId}-${index + 1}`;
                    input.id = newId;
                    const label = item.querySelector(`label[for^="${baseId}"]`);
                    if (label) {
                        label.setAttribute('for', newId);
                    }
                });
            });
             projectCounter = items.length; // Recalculate counter
        }


        function removeProject(button) {
            const projectItem = button.closest('.project-item');
             if (projectItem && projectsContainer.children.length > 1) { // Prevent removing the last one
                projectItem.remove();
                updateRemoveButtons(); // Update button visibility after removal
            }
        }

        addProjectBtn.addEventListener('click', () => {
            projectCounter++;
            const newItem = document.createElement('div');
            newItem.classList.add('project-item');
            newItem.innerHTML = `
                <button type="button" class="remove-project-btn" onclick="removeProject(this)">×</button>
                <div class="form-row">
                    <div class="form-field">
                        <label class="form-label" for="project-name-${projectCounter}">Project Name</label>
                        <input type="text" class="form-input project-name-input" id="project-name-${projectCounter}" name="project_name[]" placeholder="Another Awesome Project">
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="project-link-${projectCounter}">GitHub Link</label>
                        <input type="url" class="form-input" id="project-link-${projectCounter}" name="project_link[]" placeholder="https://github.com/yourusername/project">
                    </div>
                </div>
                <div class="form-field">
                    <label class="form-label" for="project-desc-${projectCounter}">Description</label>
                    <textarea class="form-input form-textarea" id="project-desc-${projectCounter}" name="project_desc[]" rows="3" placeholder="Brief description"></textarea>
                </div>
            `;
            projectsContainer.appendChild(newItem);
            updateRemoveButtons(); // Ensure remove buttons are correctly shown/hidden
        });

         // Initialize remove button visibility on page load
         updateRemoveButtons();

        // --- Template Selection Logic ---
        const templateCards = document.querySelectorAll('.template-card');
        const selectedTemplateInput = document.getElementById('selected-template');

        templateCards.forEach(card => {
            card.addEventListener('click', () => {
                // Remove 'selected' class from all cards
                templateCards.forEach(c => c.classList.remove('selected'));
                // Add 'selected' class to the clicked card
                card.classList.add('selected');
                // Update the hidden input value
                selectedTemplateInput.value = card.getAttribute('data-template');
            });
        });

        // --- Form Section Navigation (Optional - requires dashboard cards to have onclick) ---
        // Example: Clicking a card scrolls to the corresponding form section
        // const overviewCards = document.querySelectorAll('.dashboard-card');
        // overviewCards.forEach(card => {
        //     card.addEventListener('click', () => {
        //         const type = card.getAttribute('data-type');
        //         const section = document.querySelector(`.form-section[data-type="${type}"]`);
        //         if (section) {
        //             section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        //         }
        //     });
        // });

    </script>
</body>
</html>