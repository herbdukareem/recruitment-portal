<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../helpers/auth_helper.php';
require_once __DIR__ . '/../../helpers/rate_limit.php';

header('Content-Type: application/json');

// Authenticate admin
authenticateAdmin();

try {
   
    // Date range filter
    if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $conditions[] = "u.created_at BETWEEN :start_date AND :end_date";
        $params[':start_date'] = $_GET['start_date'] . ' 00:00:00';
        $params[':end_date'] = $_GET['end_date'] . ' 23:59:59';
    }

    // Get status counts for filters
    $statusCounts = [
        'all' => 0,
        'pending' => 0,
        'shortlisted' => 0,
        'interviewed' => 0,
        'rejected' => 0
    ];

    $statusQuery = $pdo->query("
        SELECT 
            COUNT(*) as total,
            COALESCE(b.status, 'pending') as status
        FROM users u
        JOIN user_applications b ON u.id = b.user_id
        GROUP BY b.status
    ");

    while ($row = $statusQuery->fetch(PDO::FETCH_ASSOC)) {
        $status = $row['status'] ?: 'pending';
        $statusCounts[$status] = (int)$row['total'];
        $statusCounts['all'] += (int)$row['total'];
    }

    // Add rate limit headers
    $rateLimitHeaders = getRateLimitHeaders('admin_applicants', 60, 60);
    foreach ($rateLimitHeaders as $name => $value) {
        header("$name: $value");
    }

    // Return response
    echo json_encode([
        'success' => true,
        'filters' => [
            'status_counts' => $statusCounts
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