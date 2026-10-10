<?php
require_once __DIR__ . '/cors.php';
require_once __DIR__ . '/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Use o método GET para consultar alunos.'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $baseSql = "SELECT a.idAlunos AS idAlunos,
                       a.Nome_aluno AS Nome_aluno,
                       DATE_FORMAT(a.Data_de_Nascimento, '%Y-%m-%d') AS Data_de_Nascimento,
                       a.idRuas AS idRuas,
                       r.Nome_rua AS Nome_rua,
                       ip.CPF AS CPF,
                       ip.Email AS Email,
                       ip.Telefone AS Telefone,
                       a.Status AS Status
                FROM alunos a
                INNER JOIN info_pessoal ip ON ip.idInfoPessoal = a.idInfoPessoal
                INNER JOIN ruas r ON r.idRuas = a.idRuas";

    if (isset($_GET['id']) && $id === false) {
        http_response_code(400);
        echo json_encode(['sucesso' => false, 'mensagem' => 'O parâmetro id deve ser um número inteiro.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($id !== false && $id !== null) {
        $stmt = $pdo->prepare($baseSql . ' WHERE a.idAlunos = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $aluno = $stmt->fetch();
        if (!$aluno) {
            http_response_code(404);
            echo json_encode(['sucesso' => false, 'mensagem' => 'Aluno não encontrado.'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        echo json_encode($aluno, JSON_UNESCAPED_UNICODE);
        exit;
    }

    $stmt = $pdo->query($baseSql . ' ORDER BY a.Nome_aluno ASC');
    echo json_encode($stmt->fetchAll(), JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao consultar alunos.'], JSON_UNESCAPED_UNICODE);
}
