<?php
require_once __DIR__ . '/config/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/helpers/middleware.php';
require_once __DIR__ . '/helpers/auth_helper.php';

// Set JSON header for all responses
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: " . "ALLOWED_ORIGIN");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-CSRF-Token");
header("Access-Control-Allow-Credentials: true");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Get request method and URI
$method = $_SERVER['REQUEST_METHOD'];
// $request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = str_replace('/test/backend', '', $_SERVER['REQUEST_URI']);
$request = strtok($request, '?');

// Remove trailing slash and normalize
$request = '/' . trim($request, '/');

try {
    // Route the request
    switch ($request) {
        // Authentication routes
        case '/auth/admin/login':
            require __DIR__ . '/api/auth/admin/login.php';
            break;
            
        case '/auth/admin/logout':
            require __DIR__ . '/api/auth/admin/logout.php';
            break;
            
        case '/auth/admin/register':
            require __DIR__ . '/api/auth/admin/register.php';
            break;
            
        // Admin routes
        case '/admin/data':
            require __DIR__ . '/api/admin/data.php';
            break;
            
        case '/admin/applicants':
            require __DIR__ . '/api/admin/applicants.php';
            break;

        case '/admin/stats':
            require __DIR__ . '/api/admin/stats.php';
            break;

        case '/admin/session':
            require __DIR__ . '/api/admin/session.php';
            break;

        case '/admin/session':
            require __DIR__ . '/api/admin/editsession.php';
            break;

        // User Authetication Routes
        case '/auth/user/session':
            require __DIR__ . '/api/auth/user/userSession.php';
            break;

        case '/auth/user/login':
            require __DIR__ . '/api/auth/user/login.php';
            break;
            
        case '/auth/user/logout':
            require __DIR__ . '/api/auth/user/logout.php';
            break;
            
        case '/auth/user/signup':
            require __DIR__ . '/api/auth/user/signup.php';
            break;
            
        // Applicant data routes
        case '/user/data':
            require __DIR__ . '/api/user/data.php';
            break;
            
        case '/user/bio':
            require __DIR__ . '/api/user/bio.php';
            break;
            
        case '/user/education':
            require __DIR__ . '/api/user/education.php';
            break;
            
        case '/user/work':
            require __DIR__ . '/api/user/work.php';
            break;
            
        case '/user/pmc':
            require __DIR__ . '/api/user/pmc.php';
            break;
            
        case '/user/summary':
            require __DIR__ . '/api/user/summary.php';
            break;

        case '/user/status':
            require __DIR__ . '/api/user/status.php';
            break;
            
        // Form submission routes
        case '/submit/bio':
            require __DIR__ . '/api/submit/bio.php';
            break;
            
        case '/submit/education':
            require __DIR__ . '/api/submit/education.php';
            break;
            
        case '/submit/work':
            require __DIR__ . '/api/submit/work.php';
            break;
            
        case '/submit/pmc':
            require __DIR__ . '/api/submit/pmc.php';
            break;
            
        case '/submit/quiz':
            require __DIR__ . '/api/submit/quiz.php';
            break;
            
        case '/submit/files':
            require __DIR__ . '/api/submit/files.php';
            break;
            
        // Public routes
        case '/positions':
            require __DIR__ . '/api/public/positions.php';
            break;
            
        case '/statuses':
            require __DIR__ . '/api/public/statuses.php';
            break;
            
        // Health check endpoint
        case '/health':
            echo json_encode(['status' => 'healthy', 'timestamp' => time()]);
            break;
            
        // Default route
        case '/':
            echo json_encode([
                'app' => 'Job Application System',
                'version' => '1.0',
                'endpoints' => [
                    '/login' => 'POST - User login',
                    '/register' => 'POST - User registration',
                    '/user/data' => 'GET - Basic user info',
                    '/user/full' => 'GET - Complete user profile',
                    // ... list other endpoints
                ]
            ]);
            break;
            
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint not found']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Server error',
        'message' => $e->getMessage(),
        'trace' => DEBUG_MODE ? $e->getTrace() : null
    ]);
}