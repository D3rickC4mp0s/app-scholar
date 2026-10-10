<?php
require_once __DIR__ . '/cors.php';
require_once __DIR__ . '/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Use o método GET para consultar ruas.'], JSON_UNESCAPED_UNICODE);
    exit;
}
try {
    $stmt = $pdo->query('SELECT idRuas, Nome_rua, CEP FROM ruas ORDER BY Nome_rua ASC');
    echo json_encode($stmt->fetchAll(), JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao consultar ruas.'], JSON_UNESCAPED_UNICODE);
}
