<?php
$servidor = "localhost";
$banco = "escola";
$usuario = "root";
$senha = "";

try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode(["erro" => "Erro na conexão: " . $e->getMessage()]);
    exit();
}
?>
