<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$ip = $_SERVER['REMOTE_ADDR'];
$info = @json_decode(file_get_contents("http://ip-api.com/json/$ip"));

if ($info && $info->status === "success") {
    $cep = preg_replace("/[^0-9]/", "", $info->zip);
    $bairro = null;

    // Tenta buscar bairro via ViaCEP se CEP for válido
    if ($cep && strlen($cep) === 8) {
        $viaCep = @json_decode(file_get_contents("https://viacep.com.br/ws/{$cep}/json/"));
        $bairro = $viaCep->bairro ?? null;
    }

    echo json_encode([
        "bairro" => $bairro,
        "cidade" => $info->city ?? "—",
        "estado" => $info->region ?? "—"
    ]);
} else {
    echo json_encode([
        "bairro" => null,
        "cidade" => "—",
        "estado" => "—"
    ]);
}
