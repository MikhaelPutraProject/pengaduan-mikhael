<?php
// api.php - Router FINAL (filter BERFUNGSI)

header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];
$table  = $_GET['table'] ?? null;
$id     = $_GET['id'] ?? null;

if (!$table) {
    http_response_code(400);
    echo json_encode(['message' => 'Parameter table wajib diisi']);
    exit;
}

// Bangun path internal
$path = '/records/' . $table;

if ($id && in_array($method, ['GET','PUT','DELETE'])) {
    $path .= '/' . intval($id);
}

// 🔥 BANGUN QUERY STRING BARU (KECUALI table & id)
$query = $_GET;
unset($query['table'], $query['id']);

$_SERVER['REQUEST_URI']  = $path;
$_SERVER['QUERY_STRING'] = http_build_query($query);

// Tangkap output
ob_start();
require __DIR__ . '/apicrud.php';
$output = ob_get_clean();

// Hilangkan wrapper "records"
$data = json_decode($output, true);

if (isset($data['records'])) {
    echo json_encode($data['records']);
} else {
    echo json_encode($data);
}
