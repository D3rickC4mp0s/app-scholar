<?php
// Conexão com o banco criado a partir de bd_escola.sql.
$servidor = 'localhost';
$banco = 'bd_escola';
$usuario = 'root';
$senha = ''; // padrão do XAMPP; altere se você configurou uma senha no MySQL.

try {
    $pdo = new PDO(
        "mysql:host={$servidor};dbname={$banco};charset=utf8mb4",
        $usuario,
        $senha,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Não foi possível conectar ao banco bd_escola. Confira conexao.php e se o MySQL está ligado no XAMPP.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
