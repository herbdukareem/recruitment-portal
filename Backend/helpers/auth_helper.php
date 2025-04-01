<?php
/**
 * Authentication helper functions
 */

function authenticateUser() {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }
}

function validateUserAccess($pdo, $user_id) {
    authenticateUser();
    
    // Admins can access any user data
    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
        return true;
    }
    
    // Regular users can only access their own data
    if ($_SESSION['user_id'] != $user_id) {
        http_response_code(403);
        echo json_encode(['error' => 'Forbidden']);
        exit;
    }
    
    return true;
}

// function authenticateAdmin() {
//     if (session_status() === PHP_SESSION_NONE) {
//         session_start();
//     }

//     if (empty($_SESSION['admin']) || empty($_SESSION['admin']['logged_in'])) {
//         http_response_code(401);
//         echo json_encode(['error' => 'Unauthorized']);
//         exit;
//     }
// }

function isAdminLoggedIn() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return !empty($_SESSION['admin']['logged_in']);
}

function getCurrentAdmin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return $_SESSION['admin'] ?? null;
}

function validateCsrfToken($token) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(403);
        echo json_encode(['error' => 'Invalid CSRF token']);
        exit;
    }
}

function authenticateAdmin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Check if admin is logged in
    if (empty($_SESSION['admin_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }
    
    // Verify admin still exists in database
    global $pdo;
    $stmt = $pdo->prepare("SELECT admin_id FROM admins WHERE admin_id = ?");
    $stmt->execute([$_SESSION['admin_id']]);
    
    if (!$stmt->fetch()) {
        session_destroy();
        http_response_code(403);
        echo json_encode(['error' => 'Admin account no longer exists']);
        exit;
    }
}

function checkSessionTimeout() {
    $timeout = 3600; // 1 hour
    if (!isset($_SESSION['LAST_ACTIVITY'])) {
        $_SESSION['LAST_ACTIVITY'] = time();
    } elseif (time() - $_SESSION['LAST_ACTIVITY'] > $timeout) {
        session_destroy();
        throw new Exception('Session expired', 401);
    }
    $_SESSION['LAST_ACTIVITY'] = time();
}