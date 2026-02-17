<?php
/**
 * Redirect Handler
 * Checks si_redirects table and performs redirects
 * Include this at the top of index.php
 */

function handleRedirects() {
    require_once __DIR__ . '/Database.php';
    $db = Database::getConnection();
    
    if (!$db instanceof mysqli) {
        return;
    }
    
    // Get current URL path (without query string)
    $current_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    
    // Check for redirect
    $stmt = $db->prepare("SELECT new_url, redirect_type FROM si_redirects WHERE old_url=? AND status='active' LIMIT 1");
    $stmt->bind_param("s", $current_path);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($redirect = $result->fetch_assoc()) {
        // Update hit count
        $update_stmt = $db->prepare("UPDATE si_redirects SET hit_count = hit_count + 1 WHERE old_url=?");
        $update_stmt->bind_param("s", $current_path);
        $update_stmt->execute();
        $update_stmt->close();
        
        // Perform redirect
        $redirect_code = ($redirect['redirect_type'] === '301') ? 301 : 302;
        $new_url = '/' . ltrim($redirect['new_url'], '/');
        
        header("Location: $new_url", true, $redirect_code);
        exit;
    }
    
    $stmt->close();
}

// Execute redirect check
handleRedirects();
