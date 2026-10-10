<?php
require_once __DIR__ . '/cors.php';
require_once __DIR__ . '/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Use o método POST para cadastrar aluno.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$dados = json_decode(file_get_contents('php://input'), true);
if (!is_array($dados)) {
    http_response_code(400);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Envie os dados do aluno em formato JSON.'], JSON_UNESCAPED_UNICODE);
    exit;
}

// Aceita tanto os nomes usados pelo App.js quanto os nomes das colunas SQL.
$nome = trim((string)($dados['nome'] ?? $dados['Nome'] ?? $dados['Nome_aluno'] ?? ''));
$dataNascimento = trim((string)($dados['dataNascimento'] ?? $dados['data_de_nascimento'] ?? $dados['Data_de_Nascimento'] ?? ''));
$idRuas = filter_var($dados['idRuas'] ?? $dados['id_ruas'] ?? null, FILTER_VALIDATE_INT);
$cpf = preg_replace('/\D+/', '', (string)($dados['cpf'] ?? $dados['CPF'] ?? ''));
$email = trim((string)($dados['email'] ?? $dados['Email'] ?? ''));
$telefone = preg_replace('/\D+/', '', (string)($dados['telefone'] ?? $dados['Telefone'] ?? ''));

if ($nome === '' || $dataNascimento === '' || !$idRuas || $cpf === '' || $email === '' || $telefone === '') {
    http_response_code(400);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Informe nome, data de nascimento, idRuas, CPF, e-mail e telefone.'], JSON_UNESCAPED_UNICODE);
    exit;
}
if (mb_strlen($nome) > 50 || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dataNascimento) || !checkdate((int)substr($dataNascimento, 5, 2), (int)substr($dataNascimento, 8, 2), (int)substr($dataNascimento, 0, 4))) {
    http_response_code(400);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Confira o nome (máximo 50 caracteres) e a data no formato AAAA-MM-DD.'], JSON_UNESCAPED_UNICODE);
    exit;
}
if (strlen($cpf) !== 11 || strlen($telefone) > 13 || strlen($telefone) < 8 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['sucesso' => false, 'mensagem' => 'CPF deve conter 11 dígitos, telefone deve ter de 8 a 13 dígitos e o e-mail deve ser válido.'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $checkRua = $pdo->prepare('SELECT idRuas FROM ruas WHERE idRuas = :id LIMIT 1');
    $checkRua->execute([':id' => $idRuas]);
    if (!$checkRua->fetch()) {
        http_response_code(400);
        echo json_encode(['sucesso' => false, 'mensagem' => 'O idRuas informado não existe na tabela ruas. Consulte GET /ruas.php para ver os endereços disponíveis.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $pdo->beginTransaction();
    $stmt = $pdo->prepare('INSERT INTO info_pessoal (CPF, Email, Telefone) VALUES (:cpf, :email, :telefone)');
    $stmt->execute([':cpf' => $cpf, ':email' => $email, ':telefone' => $telefone]);
    $idInfoPessoal = (int)$pdo->lastInsertId();

    $stmt = $pdo->prepare("INSERT INTO alunos (Nome_aluno, Data_de_Nascimento, idRuas, idInfoPessoal, Status) VALUES (:nome, :data, :rua, :info, 'A')");
    $stmt->execute([':nome' => $nome, ':data' => $dataNascimento, ':rua' => $idRuas, ':info' => $idInfoPessoal]);
    $idAluno = (int)$pdo->lastInsertId();
    $pdo->commit();

    http_response_code(201);
    echo json_encode(['sucesso' => true, 'mensagem' => 'Aluno cadastrado com sucesso.', 'idAlunos' => $idAluno], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao cadastrar aluno. Verifique os dados e a estrutura do banco.'], JSON_UNESCAPED_UNICODE);
}
