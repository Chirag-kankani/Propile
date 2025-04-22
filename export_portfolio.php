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
    
    // Determine template file to load
    $template_file = '';
    if ($template['name'] === 'Developer Portfolio') {
        $template_file = 'templates/developer.php';
    } elseif ($template['name'] === 'Creative Portfolio') {
        $template_file = 'templates/creative.php';
    } else {
        $template_file = 'templates/minimal.php';
    }
    
    // Read template file
    $template_content = file_get_contents($template_file);
    
    // Replace PHP variables with the actual data
    // This is a very simplified version, in a real-world scenario you'd need a more robust solution
    $portfolio_html = $template_content;
    
    // Create a temporary folder to store the exported files
    $export_dir = 'exports/' . $user_id . '_' . time();
    if (!is_dir('exports')) {
        mkdir('exports');
    }
    mkdir($export_dir);
    
    // Save the HTML file
    file_put_contents($export_dir . '/index.html', $portfolio_html);
    
    // Also create CSS and JS files based on the template
    if ($template['name'] === 'Developer Portfolio') {
        file_put_contents($export_dir . '/style.css', file_get_contents('assets/css/templates/developer.css'));
        file_put_contents($export_dir . '/script.js', file_get_contents('assets/js/templates/developer.js'));
    } elseif ($template['name'] === 'Creative Portfolio') {
        file_put_contents($export_dir . '/style.css', file_get_contents('assets/css/templates/creative.css'));
        file_put_contents($export_dir . '/script.js', file_get_contents('assets/js/templates/creative.js'));
    } else {
        file_put_contents($export_dir . '/style.css', file_get_contents('assets/css/templates/minimal.css'));
        file_put_contents($export_dir . '/script.js', file_get_contents('assets/js/templates/minimal.js'));
    }
    
    // Create a zip file
    $zip_file = 'exports/portfolio_' . $user_id . '_' . time() . '.zip';
    $zip = new ZipArchive();
    if ($zip->open($zip_file, ZipArchive::CREATE) === TRUE) {
        // Add files to the zip
        $files = scandir($export_dir);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $zip->addFile($export_dir . '/' . $file, $file);
            }
        }
        $zip->close();
        
        // Offer the zip file for download
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="portfolio.zip"');
        header('Content-Length: ' . filesize($zip_file));
        readfile($zip_file);
        
        // Clean up
        unlink($zip_file);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                unlink($export_dir . '/' . $file);
            }
        }
        rmdir($export_dir);
        exit;
    } else {
        echo "Failed to create zip file.";
    }
} catch (Exception $e) {
    die("Error exporting portfolio: " . $e->getMessage());
}
?>