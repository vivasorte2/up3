<?php
// api.php
header('Content-Type: application/json');

if (empty($_GET['transaction_id'])) {
    http_response_code(400);
    exit(json_encode(['error' => 'transaction_id ausente']));
}

$tx = preg_replace('/[^a-zA-Z0-9_\-]/', '', $_GET['transaction_id']);
$file = __DIR__ . "/leads/{$tx}.json";

if (!file_exists($file)) {
    http_response_code(404);
    exit(json_encode(['error' => 'Lead não encontrado']));
}

echo file_get_contents($file);
