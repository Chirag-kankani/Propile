<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features - ProPile</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <style>
        .features-container {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--dark-void) 0%, var(--gluon-grey) 100%);
            color: var(--snow);
            padding: var(--spacing-6) 0;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--spacing-4);
            margin-top: var(--spacing-4);
        }

        .feature-card {
            background-color: rgba(251, 251, 251, 0.05);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-4);
            transition: var(--transition-medium);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            background-color: rgba(251, 251, 251, 0.1);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--liquid-lava);
            margin-bottom: var(--spacing-2);
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: var(--spacing-2);
        }

        .feature-description {
            color: var(--dusty-grey);
            line-height: 1.6;
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
    <div class="features-container">
        <div class="container">
            <a href="index.php" class="back-link">← Back to Home</a>
            <h1 class="main-heading">ProPile Features</h1>
            <p class="tagline">Everything you need to build your professional portfolio</p>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">💻</div>
                    <h2 class="feature-title">LeetCode Integration</h2>
                    <p class="feature-description">
                        Showcase your problem-solving skills by integrating your LeetCode profile. Display your ranking, solved problems, and contest participation.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🔗</div>
                    <h2 class="feature-title">LinkedIn Connection</h2>
                    <p class="feature-description">
                        Link your professional LinkedIn profile to showcase your work experience, certifications, and network.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📚</div>
                    <h2 class="feature-title">Multi-Stage Education</h2>
                    <p class="feature-description">
                        Add your complete educational journey from school through university. Highlight your academic achievements at each stage.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🚀</div>
                    <h2 class="feature-title">GitHub Projects</h2>
                    <p class="feature-description">
                        Showcase your coding projects directly from GitHub. Display repositories, contributions, and code samples.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🎨</div>
                    <h2 class="feature-title">Custom Templates</h2>
                    <p class="feature-description">
                        Choose from multiple professional portfolio templates. Each template is fully responsive and customizable.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h2 class="feature-title">Responsive Design</h2>
                    <p class="feature-description">
                        Your portfolio will look great on all devices - from mobile phones to large desktop screens.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>