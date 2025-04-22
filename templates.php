<?php
session_start();
require_once 'config/database.php';

try {
    // Get all templates
    $stmt = $pdo->query("SELECT * FROM portfolio_templates");
    $templates = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Templates - ProPile</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <style>
        .templates-container {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--dark-void) 0%, var(--gluon-grey) 100%);
            color: var(--snow);
            padding: var(--spacing-6) 0;
        }

        .templates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: var(--spacing-4);
            margin-top: var(--spacing-5);
        }

        .template-card {
            background-color: rgba(251, 251, 251, 0.05);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            transition: var(--transition-medium);
        }

        .template-card:hover {
            transform: translateY(-5px);
            background-color: rgba(251, 251, 251, 0.1);
        }

        .template-preview {
            width: 100%;
            height: 200px;
            background-color: var(--slate-grey);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--snow);
            position: relative;
            overflow: hidden;
        }

        .template-preview::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent 0%, rgba(21, 20, 25, 0.8) 100%);
        }

        .template-content {
            padding: var(--spacing-3);
        }

        .template-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: var(--spacing-1);
        }

        .template-description {
            color: var(--dusty-grey);
            font-size: 0.9rem;
            margin-bottom: var(--spacing-3);
            line-height: 1.6;
        }

        .template-features {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: var(--spacing-3);
        }

        .template-feature {
            background-color: rgba(245, 142, 15, 0.1);
            color: var(--liquid-lava);
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 0.8rem;
        }

        .select-template {
            width: 100%;
            padding: 12px;
            background-color: var(--liquid-lava);
            color: var(--snow);
            border: none;
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition-fast);
        }

        .select-template:hover {
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
    <div class="templates-container">
        <div class="container">
            <a href="index.php" class="back-link">← Back to Home</a>
            <h1 class="main-heading">Portfolio Templates</h1>
            <p class="tagline">Choose a template that best represents you</p>

            <div class="templates-grid">
                <?php foreach ($templates as $template): ?>
                <div class="template-card">
                    <div class="template-preview">
                        <?= htmlspecialchars($template['name']) ?>
                    </div>
                    <div class="template-content">
                        <h2 class="template-title"><?= htmlspecialchars($template['name']) ?></h2>
                        <p class="template-description"><?= htmlspecialchars($template['description']) ?></p>
                        <div class="template-features">
                            <span class="template-feature">Responsive</span>
                            <span class="template-feature">Modern Design</span>
                            <span class="template-feature">Customizable</span>
                        </div>
                        <button class="select-template" onclick="selectTemplate('<?= htmlspecialchars($template['name']) ?>')">
                            Select Template
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
    <script>
        function selectTemplate(templateName) {
            // Store the selected template in localStorage
            localStorage.setItem('selectedTemplate', templateName);
            // Redirect to the form page
            window.location.href = 'form.php';
        }
    </script>
</body>
</html>