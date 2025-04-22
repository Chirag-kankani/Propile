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
    
    // Determine which template to use
    $template_name = $template['name'];
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Include the appropriate template based on the selected template
if ($template_name === 'Developer Portfolio') {
    include 'templates/developer.php';
} elseif ($template_name === 'Creative Portfolio') {
    include 'templates/creative.php';
} else {
    // Default to minimal template
    include 'templates/minimal.php';
}
?>