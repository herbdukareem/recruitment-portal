<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../helpers/rate_limit.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

try {
    // Apply rate limiting (60 requests per minute)
    limitRequests('public_positions', 60, 60);

    // Cache control (1 hour client-side, 6 hours server-side)
    header('Cache-Control: public, max-age=3600, s-maxage=21600');

    // Query distinct positions from database
    $stmt = $pdo->query("
        SELECT DISTINCT position, positionType 
        FROM user_applications 
        WHERE position IS NOT NULL
        ORDER BY positionType, position
    ");
    $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Group by position type
    $groupedPositions = [];
    foreach ($positions as $position) {
        $type = $position['positionType'] ?? 'Other';
        if (!isset($groupedPositions[$type])) {
            $groupedPositions[$type] = [];
        }
        $groupedPositions[$type][] = $position['position'];
    }

    // Add rate limit headers
    foreach (getRateLimitHeaders('public_positions', 60, 60) as $name => $value) {
        header("$name: $value");
    }

    echo json_encode([
        'success' => true,
        'data' => $groupedPositions,
        'meta' => [
            'last_updated' => time(),
            'source' => 'HR Department'
        ]
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error',
        'message' => DEBUG_MODE ? $e->getMessage() : null
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}