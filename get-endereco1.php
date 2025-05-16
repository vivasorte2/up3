<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$ip = $_SERVER['REMOTE_ADDR'];
$info = @json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));

if ($info && $info->status === "success") {
    echo json_encode([
        "cidade" => $info->city ?? "—",
        "estado" => $info->region ?? "—"
    ]);
} else {
    echo json_encode([
        "cidade" => "—",
        "estado" => "—"
    ]);
}
?>
