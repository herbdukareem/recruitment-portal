<?php
// Error handler
function handleErrors($errno, $errstr, $errfile, $errline) {
    error_log("[Error $errno] $errstr in $errfile:$errline");
    
    if (!defined('DEBUG_MODE') || !DEBUG_MODE) {
        $errstr = "A server error occurred";
    }
    
    http_response_code(500);
    echo json_encode(['error' => $errstr]);
    exit;
}

// Exception handler
function handleExceptions($exception) {
    error_log("Exception: " . $exception->getMessage());
    
    $message = DEBUG_MODE ? $exception->getMessage() : "A server error occurred";
    http_response_code(500);
    echo json_encode(['error' => $message]);
    exit;
}

// Shutdown function
function handleShutdown() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR])) {
        handleErrors($error['type'], $error['message'], $error['file'], $error['line']);
    }
}

// Register handlers
set_error_handler('handleErrors');
set_exception_handler('handleExceptions');
register_shutdown_function('handleShutdown');