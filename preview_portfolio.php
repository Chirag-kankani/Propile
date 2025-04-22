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
    $stmt = $pdo->prepare("SELECT * FROM education WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $education = $stmt->fetch();
    
    // Get projects
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $projects = $stmt->fetchAll();
    
    // Get social links
    $stmt = $pdo->prepare("SELECT * FROM social_links WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $social_links = [];
    
    foreach ($stmt->fetchAll() as $link) {
        $social_links[$link['platform']] = $link['url'];
    }
    
    // Get portfolio template
    $stmt = $pdo->prepare("
        SELECT t.* FROM user_portfolios p
        JOIN portfolio_templates t ON p.template_id = t.id
        WHERE p.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $template = $stmt->fetch();
    
    if (!$template) {
        // Use first template as fallback
        $stmt = $pdo->prepare("SELECT * FROM portfolio_templates LIMIT 1");
        $stmt->execute();
        $template = $stmt->fetch();
    }
    
    // Determine template filename
    $template_file = 'templates/minimal.php';
    
    if ($template['name'] === 'Developer Portfolio') {
        $template_file = 'templates/developer.php';
    } elseif ($template['name'] === 'Creative Portfolio') {
        $template_file = 'templates/creative.php';
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
    <title>Portfolio Preview - ProPile</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <style>
        .preview-header {
            background-color: var(--dark-void);
            color: var(--snow);
            padding: var(--spacing-3);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .preview-actions {
            display: flex;
            gap: var(--spacing-2);
        }
        
        .preview-frame {
            width: 100%;
            height: calc(100vh - 80px);
            border: none;
        }
    </style>
</head>
<body>
    <div class="preview-header">
        <h2>Portfolio Preview</h2>
        <div class="preview-actions">
            <a href="dashboard.php" class="btn btn-secondary">Edit Portfolio</a>
            <a href="export_portfolio.php" class="btn btn-primary">Export Portfolio</a>
        </div>
    </div>
    
    <iframe class="preview-frame" src="render_portfolio.php" allowfullscreen></iframe>
    
    <script src="assets/js/script.js"></script>
</body>
</html>