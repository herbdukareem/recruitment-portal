// helpers/cache_helper.php
<?php
function getFromCache($key) {
    if (!file_exists(__DIR__ . '/../../cache')) {
        mkdir(__DIR__ . '/../../cache', 0755, true);
    }
    
    $cacheFile = __DIR__ . "/../../cache/{$key}.json";
    
    if (file_exists($cacheFile) && 
        (time() - filemtime($cacheFile) < 3600)) { // 1 hour cache
        return json_decode(file_get_contents($cacheFile), true);
    }
    
    return false;
}

function saveToCache($key, $data, $ttl = 3600) {
    $cacheFile = __DIR__ . "/../../cache/{$key}.json";
    file_put_contents($cacheFile, json_encode($data));
}

// Then modify your fetch functions to use cache:
function fetchUserDataWithCache($pdo, $user_id) {
    $cacheKey = "user_{$user_id}_data";
    if ($cachedData = getFromCache($cacheKey)) {
        return $cachedData;
    }
    
    $data = fetchUserData($pdo, $user_id);
    saveToCache($cacheKey, $data);
    return $data;
}