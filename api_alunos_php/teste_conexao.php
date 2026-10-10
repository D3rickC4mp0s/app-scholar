<?php
require_once __DIR__ . '/cors.php';
require_once __DIR__ . '/conexao.php';
echo json_encode(['sucesso' => true, 'mensagem' => 'Conexão com o banco bd_escola realizada com sucesso.'], JSON_UNESCAPED_UNICODE);
