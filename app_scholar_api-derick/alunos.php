<?php
require_once "conexao.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

try {
    
    $sql = "SELECT id_aluno AS id, nome, email, CPF FROM alunos";
    $stmt = $pdo->query($sql);
    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($alunos, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    echo json_encode(["erro" => "Erro ao consultar alunos: " . $e->getMessage()]);
}
?>
