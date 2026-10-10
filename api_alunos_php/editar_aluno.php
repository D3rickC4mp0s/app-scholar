<?php
require_once __DIR__ . '/cors.php';
require_once __DIR__ . '/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Use o método PUT para editar aluno.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$dados = json_decode(file_get_contents('php://input'), true);
if (!is_array($dados)) {
    http_response_code(400);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Envie os dados do aluno em formato JSON.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$idAluno = filter_var($dados['idAlunos'] ?? $dados['id'] ?? $_GET['id'] ?? null, FILTER_VALIDATE_INT);
$nome = trim((string)($dados['nome'] ?? $dados['Nome'] ?? $dados['Nome_aluno'] ?? ''));
$dataNascimento = trim((string)($dados['dataNascimento'] ?? $dados['data_de_nascimento'] ?? $dados['Data_de_Nascimento'] ?? ''));
$idRuas = filter_var($dados['idRuas'] ?? $dados['id_ruas'] ?? null, FILTER_VALIDATE_INT);
$cpf = preg_replace('/\D+/', '', (string)($dados['cpf'] ?? $dados['CPF'] ?? ''));
$email = trim((string)($dados['email'] ?? $dados['Email'] ?? ''));
$telefone = preg_replace('/\D+/', '', (string)($dados['telefone'] ?? $dados['Telefone'] ?? ''));

if (!$idAluno || $nome === '' || $dataNascimento === '' || !$idRuas || $cpf === '' || $email === '' || $telefone === '') {
    http_response_code(400);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Informe idAlunos, nome, data de nascimento, idRuas, CPF, e-mail e telefone.'], JSON_UNESCAPED_UNICODE);
    exit;
}
if (mb_strlen($nome) > 50 || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dataNascimento) || !checkdate((int)substr($dataNascimento, 5, 2), (int)substr($dataNascimento, 8, 2), (int)substr($dataNascimento, 0, 4)) || strlen($cpf) !== 11 || strlen($telefone) > 13 || strlen($telefone) < 8 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Confira nome, data AAAA-MM-DD, CPF (11 dígitos), telefone (8 a 13 dígitos) e e-mail.'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare('SELECT idInfoPessoal FROM alunos WHERE idAlunos = :id FOR UPDATE');
    $stmt->execute([':id' => $idAluno]);
    $aluno = $stmt->fetch();
    if (!$aluno) {
        $pdo->rollBack();
        http_response_code(404);
        echo json_encode(['sucesso' => false, 'mensagem' => 'Aluno não encontrado.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $stmt = $pdo->prepare('SELECT idRuas FROM ruas WHERE idRuas = :id LIMIT 1');
    $stmt->execute([':id' => $idRuas]);
    if (!$stmt->fetch()) {
        $pdo->rollBack();
        http_response_code(400);
        echo json_encode(['sucesso' => false, 'mensagem' => 'O idRuas informado não existe na tabela ruas.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $stmt = $pdo->prepare('UPDATE info_pessoal SET CPF = :cpf, Email = :email, Telefone = :telefone WHERE idInfoPessoal = :info');
    $stmt->execute([':cpf' => $cpf, ':email' => $email, ':telefone' => $telefone, ':info' => $aluno['idInfoPessoal']]);
    $stmt = $pdo->prepare('UPDATE alunos SET Nome_aluno = :nome, Data_de_Nascimento = :data, idRuas = :rua WHERE idAlunos = :id');
    $stmt->execute([':nome' => $nome, ':data' => $dataNascimento, ':rua' => $idRuas, ':id' => $idAluno]);
    $pdo->commit();

    echo json_encode(['sucesso' => true, 'mensagem' => 'Aluno atualizado com sucesso.', 'idAlunos' => $idAluno], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao editar aluno. Verifique os dados e a estrutura do banco.'], JSON_UNESCAPED_UNICODE);
}
