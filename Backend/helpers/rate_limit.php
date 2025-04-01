<?php
/**
 * Rate limiting helper functions
 */

// Directory to store rate limit files
define('RATE_LIMIT_DIR', __DIR__ . '/../../storage/rate_limits/');

// Create directory if it doesn't exist
if (!file_exists(RATE_LIMIT_DIR)) {
    mkdir(RATE_LIMIT_DIR, 0755, true);
}

/**
 * Enforce rate limiting
 * @param string $identifier Unique identifier for what's being limited (e.g., 'login', 'api')
 * @param int $maxRequests Maximum number of requests allowed
 * @param int $timePeriod Time period in seconds
 * @throws Exception When rate limit is exceeded
 */
function limitRequests(string $identifier, int $maxRequests = 5, int $timePeriod = 60) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $key = md5("rate_limit_{$identifier}_{$ip}");
    $file = RATE_LIMIT_DIR . $key;
    
    // Get current data
    $data = [
        'count' => 0,
        'first_request' => time()
    ];
    
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $data = json_decode($content, true) ?: $data;
    }
    
    // Reset if time period has passed
    if (time() - $data['first_request'] > $timePeriod) {
        $data = [
            'count' => 0,
            'first_request' => time()
        ];
    }
    
    // Increment count
    $data['count']++;
    
    // Check if limit exceeded
    if ($data['count'] > $maxRequests) {
        $retryAfter = $timePeriod - (time() - $data['first_request']);
        header('Retry-After: ' . $retryAfter);
        http_response_code(429);
        echo json_encode([
            'error' => 'Too many requests',
            'retry_after' => $retryAfter
        ]);
        exit;
    }
    
    // Save updated data
    file_put_contents($file, json_encode($data));
}

/**
 * Clean up old rate limit files
 */
function cleanupRateLimits() {
    $files = glob(RATE_LIMIT_DIR . 'rate_limit_*');
    $now = time();
    $maxAge = 86400; // 24 hours
    
    foreach ($files as $file) {
        if ($now - filemtime($file) > $maxAge) {
            unlink($file);
        }
    }
}

// Clean up old files on 1% of requests (randomly)
if (rand(1, 100) === 1) {
    cleanupRateLimits();
}

/**
 * Get rate limit headers for API responses
 */
function getRateLimitHeaders(string $identifier, int $maxRequests = 5, int $timePeriod = 60): array {
    $ip = $_SERVER['REMOTE_ADDR'];
    $key = md5("rate_limit_{$identifier}_{$ip}");
    $file = RATE_LIMIT_DIR . $key;
    
    $remaining = $maxRequests;
    $reset = time() + $timePeriod;
    
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $data = json_decode($content, true);
        
        if ($data) {
            $elapsed = time() - $data['first_request'];
            $remaining = max(0, $maxRequests - $data['count']);
            $reset = $data['first_request'] + $timePeriod;
        }
    }
    
    return [
        'X-RateLimit-Limit' => $maxRequests,
        'X-RateLimit-Remaining' => $remaining,
        'X-RateLimit-Reset' => $reset
    ];
}