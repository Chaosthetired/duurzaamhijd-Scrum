<?php
echo "<h1>NZDPU wis/search demo</h1>";

$token = "<YOUR_TOKEN>";
$endpoint = "https://nzdpu.com/wis/search";

/**
 * Small helper to POST JSON with Bearer auth
 */
function post_json($url, $token, $payload) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $token",
            "Content-Type: application/json",
            "Accept: application/json"
        ],
        CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_SLASHES)
    ]);
    $resp = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($resp === false) {
        die('cURL error: ' . curl_error($ch));
    }
    curl_close($ch);
    return [$http, $resp];
}

/**
 * 1) Minimal search by name (works on many search endpoints):
 *    Send just a query string and a limit.
 */
[$code1, $resp1] = post_json($endpoint, $token, [
    "SearchQuery" => "Koninklijke Philips N.V.",
    "limit" => 5
]);

/**
 * 2) (Optional) Restrict to companies only:
 *    Many search APIs let you scope which collections to search.
 *    On NZDPU the resources are grouped under “coverage/*” (see API docs),
 *    so try scoping to "coverage/companies". If the API replies 400 with a
 *    validation error, check the error message — some versions call this
 *    field "resources" or "indexes" instead of "collections".
 */
[$code2, $resp2] = post_json($endpoint, $token, [
    "q" => "Royal Philips",
    "limit" => 5,
    "collections" => ["coverage/companies"]   // try "resources" if needed
]);

/**
 * 3) Debug trick:
 *    Send an empty body {} to make the server tell you which fields it expects.
 *    The validation message often lists the exact schema/field names.
 */
[$code3, $resp3] = post_json($endpoint, $token, new stdClass());

/** Pretty-print results safely */
function dump_json($title, $code, $json) {
    $decoded = json_decode($json, true);
    echo "<h3>$title (HTTP $code)</h3>";
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "<pre>" . htmlspecialchars(json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) . "</pre>";
    } else {
        echo "<pre>" . htmlspecialchars($json) . "</pre>";
    }
}

dump_json("Minimal search", $code1, $resp1);
dump_json("Scoped to companies", $code2, $resp2);
dump_json("Schema hint (empty body)", $code3, $resp3);
