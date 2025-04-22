<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Get user information
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    
    // Get user profile
    $stmt = $pdo->prepare("SELECT * FROM profiles WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $profile = $stmt->fetch();
    
    // Get education information
    $stmt = $pdo->prepare("SELECT * FROM education WHERE user_id = ? ORDER BY level");
    $stmt->execute([$user_id]);
    $education = $stmt->fetchAll();
    
    // Get social links
    $stmt = $pdo->prepare("SELECT * FROM social_links WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $social_links = [];
    foreach ($stmt->fetchAll() as $link) {
        $social_links[$link['platform']] = $link['url'];
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Build Your Portfolio - ProPile</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <style>
        .form-container {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--dark-void) 0%, var(--gluon-grey) 100%);
            color: var(--snow);
            padding: var(--spacing-6) 0;
        }

        .form-card {
            background-color: rgba(251, 251, 251, 0.05);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-4);
            margin-top: var(--spacing-4);
        }

        .form-section {
            margin-bottom: var(--spacing-4);
            padding-bottom: var(--spacing-4);
            border-bottom: 1px solid rgba(251, 251, 251, 0.1);
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: var(--spacing-3);
            color: var(--liquid-lava);
        }

        .education-level {
            background-color: rgba(251, 251, 251, 0.05);
            border-radius: var(--border-radius-md);
            padding: var(--spacing-3);
            margin-bottom: var(--spacing-3);
        }

        .education-level:last-child {
            margin-bottom: 0;
        }

        .level-title {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: var(--spacing-2);
            color: var(--snow);
        }

        .form-group {
            margin-bottom: var(--spacing-3);
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: var(--dusty-grey);
        }

        .form-input {
            width: 100%;
            padding: 12px;
            background-color: rgba(251, 251, 251, 0.05);
            border: 1px solid rgba(251, 251, 251, 0.1);
            border-radius: var(--border-radius-sm);
            color: var(--snow);
            transition: var(--transition-fast);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--liquid-lava);
            background-color: rgba(251, 251, 251, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--spacing-3);
        }

        .submit-btn {
            background-color: var(--liquid-lava);
            color: var(--snow);
            border: none;
            padding: 12px 24px;
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition-fast);
        }

        .submit-btn:hover {
            background-color: #e07c00;
            transform: translateY(-2px);
        }

        .back-link {
            display: inline-block;
            color: var(--liquid-lava);
            text-decoration: none;
            margin-bottom: var(--spacing-4);
            font-weight: 500;
            transition: var(--transition-fast);
        }

        .back-link:hover {
            color: #e07c00;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="container">
            <a href="index.php" class="back-link">← Back to Home</a>
            <h1 class="main-heading">Build Your Portfolio</h1>
            <p class="tagline">Fill in your details to create your professional portfolio</p>

            <form action="process_profile.php" method="POST" class="form-card">
                <!-- Education Section -->
                <div class="form-section">
                    <h2 class="section-title">Education</h2>
                    
                    <!-- School -->
                    <div class="education-level">
                        <h3 class="level-title">School Education</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="school-name">School Name</label>
                                <input type="text" id="school-name" name="education[school][name]" class="form-input">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="school-year">Year of Completion</label>
                                <input type="number" id="school-year" name="education[school][year]" class="form-input">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="school-percentage">Percentage/Grade</label>
                            <input type="text" id="school-percentage" name="education[school][percentage]" class="form-input">
                        </div>
                    </div>

                    <!-- College -->
                    <div class="education-level">
                        <h3 class="level-title">College Education</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="college-name">College Name</label>
                                <input type="text" id="college-name" name="education[college][name]" class="form-input">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="college-year">Year of Completion</label>
                                <input type="number" id="college-year" name="education[college][year]" class="form-input">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="college-percentage">Percentage/Grade</label>
                            <input type="text" id="college-percentage" name="education[college][percentage]" class="form-input">
                        </div>
                    </div>

                    <!-- University -->
                    <div class="education-level">
                        <h3 class="level-title">University Education</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="university-name">University Name</label>
                                <input type="text" id="university-name" name="education[university][name]" class="form-input">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="university-year">Year of Completion</label>
                                <input type="number" id="university-year" name="education[university][year]" class="form-input">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="university-degree">Degree</label>
                                <input type="text" id="university-degree" name="education[university][degree]" class="form-input">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="university-percentage">CGPA/Percentage</label>
                                <input type="text" id="university-percentage" name="education[university][percentage]" class="form-input">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Profiles -->
                <div class="form-section">
                    <h2 class="section-title">Social Profiles</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="linkedin">LinkedIn Profile</label>
                            <input type="url" id="linkedin" name="social[linkedin]" class="form-input" placeholder="https://linkedin.com/in/username">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="leetcode">LeetCode Profile</label>
                            <input type="url" id="leetcode" name="social[leetcode]" class="form-input" placeholder="https://leetcode.com/username">
                        </div>
                    </div>
                </div>

                <!-- Projects -->
                <div class="form-section">
                    <h2 class="section-title">Projects</h2>
                    <div id="projects-container">
                        <div class="project-item">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="project-name-1">Project Name</label>
                                    <input type="text" id="project-name-1" name="project_name[]" class="form-input">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="project-link-1">GitHub Link</label>
                                    <input type="url" id="project-link-1" name="project_link[]" class="form-input">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="project-desc-1">Description</label>
                                <textarea id="project-desc-1" name="project_desc[]" class="form-input" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="add-more-btn" id="add-project">+ Add Another Project</button>
                </div>

                <button type="submit" class="submit-btn">Generate Portfolio</button>
            </form>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        // Add project functionality
        document.getElementById('add-project').addEventListener('click', function() {
            const container = document.getElementById('projects-container');
            const projectCount = container.children.length + 1;
            
            const projectHtml = `
                <div class="project-item">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="project-name-${projectCount}">Project Name</label>
                            <input type="text" id="project-name-${projectCount}" name="project_name[]" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="project-link-${projectCount}">GitHub Link</label>
                            <input type="url" id="project-link-${projectCount}" name="project_link[]" class="form-input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="project-desc-${projectCount}">Description</label>
                        <textarea id="project-desc-${projectCount}" name="project_desc[]" class="form-input" rows="3"></textarea>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', projectHtml);
        });
    </script>
</body>
</html>