<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../helpers/rate_limit.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

try {
    // Apply rate limiting (60 requests per minute)
    limitRequests('public_statuses', 60, 60);

    // Cache control (1 day client-side, 1 week server-side)
    header('Cache-Control: public, max-age=86400, s-maxage=604800');

    // Standard statuses with descriptions
    $statuses = [
        [
            'value' => 'pending',
            'label' => 'Pending Review',
            'description' => 'Application submitted but not yet reviewed'
        ],
        [
            'value' => 'shortlisted',
            'label' => 'Shortlisted',
            'description' => 'Application meets initial requirements'
        ],
        [
            'value' => 'interviewed',
            'label' => 'Interviewed',
            'description' => 'Candidate has been interviewed'
        ],
        [
            'value' => 'rejected',
            'label' => 'Rejected',
            'description' => 'Application did not meet requirements'
        ],
        [
            'value' => 'hired',
            'label' => 'Hired',
            'description' => 'Candidate was selected for position'
        ]
    ];

    // Add dynamic counts from database if requested
    if (isset($_GET['with_counts']) && $_GET['with_counts'] === 'true') {
        $stmt = $pdo->query("
            SELECT 
                COALESCE(status, 'pending') as status,
                COUNT(*) as count
            FROM user_applications
            GROUP BY status
        ");
        $counts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        foreach ($statuses as &$status) {
            $status['count'] = $counts[$status['value']] ?? 0;
        }
    }

    // Add rate limit headers
    foreach (getRateLimitHeaders('public_statuses', 60, 60) as $name => $value) {
        header("$name: $value");
    }

    echo json_encode([
        'success' => true,
        'data' => $statuses,
        'meta' => [
            'last_updated' => time(),
            'counts_available' => isset($_GET['with_counts'])
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