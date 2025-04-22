<?php
session_start();
require_once 'config/database.php';

// Check login... (keep existing code)
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Begin Transaction (Optional but good practice)
        // $pdo->beginTransaction();

        // --- ADJUSTED Education Section ---
        // Use 'school' as the primary identifier from the form, matching the input name
        $institution = isset($_POST['school']) ? trim($_POST['school']) : null;
        $degree = isset($_POST['degree']) ? trim($_POST['degree']) : null;
        $field = isset($_POST['field']) ? trim($_POST['field']) : null;

        // Get dates and format them for SQL DATE type (YYYY-MM-DD)
        $start_date_input = isset($_POST['start_date']) ? $_POST['start_date'] : null;
        $end_date_input = isset($_POST['end_date']) ? $_POST['end_date'] : null;

        // Append '-01' if the date is in 'YYYY-MM' format and not empty
        $start_date_sql = (!empty($start_date_input) && strlen($start_date_input) === 7) ? $start_date_input . '-01' : null;
        $end_date_sql = (!empty($end_date_input) && strlen($end_date_input) === 7) ? $end_date_input . '-01' : null;

        // Only process if at least the institution name is provided
        if (!empty($institution)) {
            // Check if education entry already exists for the user
            // Since we now only store ONE entry per user (simplified approach)
            $stmt = $pdo->prepare("SELECT id FROM education WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $existing_edu_id = $stmt->fetchColumn(); // Get the ID if it exists

            if ($existing_edu_id) {
                // Update existing education entry
                $stmt = $pdo->prepare("
                    UPDATE education
                    SET institution = ?, degree = ?, field = ?, start_date = ?, end_date = ?
                    WHERE id = ?
                ");
                // Use the formatted dates for SQL
                $stmt->execute([$institution, $degree, $field, $start_date_sql, $end_date_sql, $existing_edu_id]);
            } else {
                // Create new education entry
                $stmt = $pdo->prepare("
                    INSERT INTO education (user_id, institution, degree, field, start_date, end_date)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                 // Use the formatted dates for SQL
                $stmt->execute([$user_id, $institution, $degree, $field, $start_date_sql, $end_date_sql]);
            }
        } else {
            // Optional: If institution is empty, maybe delete the existing record?
            // $stmt = $pdo->prepare("DELETE FROM education WHERE user_id = ?");
            // $stmt->execute([$user_id]);
        }
        // --- END ADJUSTED Education Section ---


        // --- Profile Bio Section --- (Keep existing code)
        $bio = isset($_POST['bio']) ? trim($_POST['bio']) : null;
        if ($bio !== null) {
            // (Your existing code to check and update/insert profile bio)
             $stmtCheckProfile = $pdo->prepare("SELECT COUNT(*) FROM profiles WHERE user_id = ?");
             $stmtCheckProfile->execute([$user_id]);
             if ($stmtCheckProfile->fetchColumn() > 0) {
                $stmt = $pdo->prepare("UPDATE profiles SET bio = ? WHERE user_id = ?");
                $stmt->execute([$bio, $user_id]);
             } else {
                 $stmt = $pdo->prepare("INSERT INTO profiles (user_id, bio) VALUES (?, ?)");
                 $stmt->execute([$user_id, $bio]);
             }
        }
        // --- End Profile Bio Section ---


        // --- Social Links Section --- (Keep existing code, ensure names match form)
         $social_links_to_process = [
            'portfolio' => isset($_POST['portfolio_link']) ? trim($_POST['portfolio_link']) : null,
            'leetcode' => isset($_POST['leetcode_link']) ? trim($_POST['leetcode_link']) : null,
            // Make sure your form actually has an input named 'social[linkedin]' if you uncomment this
            // 'linkedin' => isset($_POST['social']['linkedin']) ? trim($_POST['social']['linkedin']) : null,
        ];
         foreach ($social_links_to_process as $platform => $url) {
             // (Your existing code to check and update/insert social links)
             // ... (make sure it handles empty URLs correctly, maybe deletes?)
             if (!empty($url)) {
                $stmt = $pdo->prepare("SELECT id FROM social_links WHERE user_id = ? AND platform = ?");
                $stmt->execute([$user_id, $platform]);
                $existing_id = $stmt->fetchColumn();
                if ($existing_id) {
                    $stmt = $pdo->prepare("UPDATE social_links SET url = ? WHERE id = ?");
                    $stmt->execute([$url, $existing_id]);
                } else {
                    $stmt = $pdo->prepare("INSERT INTO social_links (user_id, platform, url) VALUES (?, ?, ?)");
                    $stmt->execute([$user_id, $platform, $url]);
                }
            } else {
                 $stmt = $pdo->prepare("DELETE FROM social_links WHERE user_id = ? AND platform = ?");
                 $stmt->execute([$user_id, $platform]);
             }
         }
        // --- End Social Links Section ---


        // --- Projects Section --- (Keep existing code)
        if (isset($_POST['project_name']) && is_array($_POST['project_name'])) {
            // (Your existing code to delete and insert projects)
             $stmt = $pdo->prepare("DELETE FROM projects WHERE user_id = ?");
            $stmt->execute([$user_id]);
            // ... loop and insert ...
             $project_names = $_POST['project_name'];
             $project_links = $_POST['project_link'] ?? [];
             $project_descs = $_POST['project_desc'] ?? [];
             for ($i = 0; $i < count($project_names); $i++) {
                if (!empty($project_names[$i])) {
                    $stmt = $pdo->prepare("INSERT INTO projects (user_id, title, github_link, description) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$user_id, trim($project_names[$i]), !empty($project_links[$i]) ? trim($project_links[$i]) : null, !empty($project_descs[$i]) ? trim($project_descs[$i]) : null]);
                }
             }
        }
        // --- End Projects Section ---


        // --- Template Selection Section --- (Keep existing code)
         $selected_template_name = isset($_POST['selected_template']) ? trim($_POST['selected_template']) : 'minimal';
         // (Your existing code to find template_id and update/insert user_portfolios)
         $db_template_name = ''; // ... switch statement ...
            switch ($selected_template_name) {
                case 'developer': $db_template_name = 'Developer Portfolio'; break;
                case 'creative': $db_template_name = 'Creative Portfolio'; break;
                default: $db_template_name = 'Modern Minimal'; break;
            }
         $stmt = $pdo->prepare("SELECT id FROM portfolio_templates WHERE name = ?");
         $stmt->execute([$db_template_name]);
         $template_id = $stmt->fetchColumn();
         // ... fallback logic ...
          if (!$template_id) {
            $stmt = $pdo->prepare("SELECT id FROM portfolio_templates ORDER BY id LIMIT 1");
            $stmt->execute();
            $template_id = $stmt->fetchColumn();
          }
         // ... check user_portfolios and update/insert ...
         $stmt = $pdo->prepare("SELECT id FROM user_portfolios WHERE user_id = ?");
         $stmt->execute([$user_id]);
         $user_portfolio_id = $stmt->fetchColumn();
         if ($user_portfolio_id) {
            $stmt = $pdo->prepare("UPDATE user_portfolios SET template_id = ? WHERE id = ?");
            $stmt->execute([$template_id, $user_portfolio_id]);
         } else {
            $stmt = $pdo->prepare("INSERT INTO user_portfolios (user_id, template_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $template_id]);
         }
        // --- End Template Selection Section ---

        // Commit transaction (If you used beginTransaction)
        // $pdo->commit();

        // Redirect to portfolio preview
        header("Location: preview_portfolio.php");
        exit();

    } catch (PDOException $e) {
        // Roll back changes on error (If you used beginTransaction)
        // $pdo->rollBack();
        die("Database error: " . $e->getMessage()); // Show error
    }
} else {
    // Redirect if not POST
    header("Location: dashboard.php");
    exit();
}
?>