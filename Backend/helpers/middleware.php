<?php

function handleErrors($errno, $errstr, $errfile, $errline) {
    // Log the complete error
    error_log("[PHP Error $errno] $errstr in $errfile:$errline");
    
    // Only show detailed errors in development
    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode([
            'error' => 'Server Error',
            'message' => $errstr,
            'type' => $errno,
            'file' => $errfile,
            'line' => $errline,
            'trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'A server error occurred']);
    }
    exit;
}

function handleExceptions($exception) {
    $errorId = uniqid('ERR-');
    
    error_log(sprintf(
        "[%s] %s in %s:%d\n%s",
        $errorId,
        $exception->getMessage(),
        $exception->getFile(),
        $exception->getLine(),
        $exception->getTraceAsString()
    ));
    
    http_response_code(500);
    
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'error' => 'Internal Server Error',
        'error_id' => $errorId,
        'message' => DEBUG_MODE ? $exception->getMessage() : 'Please contact support',
        'details' => DEBUG_MODE ? [
            'type' => get_class($exception),
            'file' => $exception->getFile(),
            'line' => $exception->getLine()
        ] : null
    ]);
    exit;
}


// Shutdown function
function handleShutdown() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        handleErrors($error['type'], $error['message'], $error['file'], $error['line']);
    }
}

// CSRF protection
function verifyCsrfToken() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_SERVER['HTTP_X_CSRF_TOKEN']) || 
            $_SERVER['HTTP_X_CSRF_TOKEN'] !== $_SESSION['csrf_token']) {
            http_response_code(403);
            echo json_encode(['error' => 'Invalid CSRF token']);
            exit;
        }
    }
}

// Register handlers
set_error_handler('handleErrors');
set_exception_handler('handleExceptions');
register_shutdown_function('handleShutdown');

// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}