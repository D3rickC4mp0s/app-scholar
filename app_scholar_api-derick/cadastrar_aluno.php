<?php

require_once "conexao.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Método não permitido"
    ]);
    exit();
}

$dados = json_decode(file_get_contents("php://input"), true);

if (!$dados) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Nenhum dado foi recebido"
    ]);
    exit();
}

$nome = $dados["nome"] ?? "";
$data_nascimento = $dados["data_nascimento"] ?? "";
$cpf = $dados["cpf"] ?? "";
$telefone = $dados["telefone"] ?? "";
$email = $dados["email"] ?? "";

$endereco = $dados["endereco"] ?? "";
$curso = $dados["curso"] ?? "";
$responsavel = $dados["responsavel"] ?? "";

if (
    empty($nome) ||
    empty($data_nascimento) ||
    empty($cpf) ||
    empty($telefone) ||
    empty($email) ||
    empty($endereco) ||
    empty($curso)
) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Preencha todos os campos obrigatórios."
    ]);
    exit();
}

try {


    $pdo->beginTransaction();

    $sql = "SELECT id_rua
            FROM ruas
            WHERE nome = :endereco
            LIMIT 1";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":endereco" => $endereco
    ]);

    $rua = $stmt->fetch(PDO::FETCH_ASSOC);


    if (!$rua) {

        throw new Exception(
            "Endereço não encontrado: " . $endereco
        );
    }


    $id_rua = $rua["id_rua"];

    $sql = "SELECT id_curso
            FROM cursos
            WHERE nome = :curso
            LIMIT 1";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":curso" => $curso
    ]);

    $cursoEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);


    if (!$cursoEncontrado) {

        throw new Exception(
            "Curso não encontrado: " . $curso
        );
    }


    $id_curso = $cursoEncontrado["id_curso"];


    $sql = "SELECT id_turma
            FROM turmas
            WHERE id_curso = :id_curso
            LIMIT 1";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":id_curso" => $id_curso
    ]);

    $turma = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$turma) {

        throw new Exception(
            "Não existe uma turma cadastrada para o curso: " . $curso
        );
    }

    $id_turma = $turma["id_turma"];


    $sql = "INSERT INTO alunos
            (
                nome,
                data_nascimento,
                CPF,
                telefone,
                email,
                id_rua
            )
            VALUES
            (
                :nome,
                :data_nascimento,
                :cpf,
                :telefone,
                :email,
                :id_rua
            )";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":nome" => $nome,
        ":data_nascimento" => $data_nascimento,
        ":cpf" => $cpf,
        ":telefone" => $telefone,
        ":email" => $email,
        ":id_rua" => $id_rua
    ]);


    $id_aluno = $pdo->lastInsertId();


    $sql = "INSERT INTO matriculas
            (
                id_aluno,
                data_matricula,
                situacao_matricula
            )
            VALUES
            (
                :id_aluno,
                CURDATE(),
                'Ativo'
            )";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":id_aluno" => $id_aluno
    ]);

    $id_matricula = $pdo->lastInsertId();


    $sql = "INSERT INTO ma_tur
            (
                id_matricula,
                id_turma
            )
            VALUES
            (
                :id_matricula,
                :id_turma
            )";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":id_matricula" => $id_matricula,
        ":id_turma" => $id_turma
    ]);

    $pdo->commit();


    echo json_encode([
        "sucesso" => true,
        "mensagem" => "Aluno cadastrado com sucesso!",
        "id_aluno" => $id_aluno,
        "id_matricula" => $id_matricula,
        "id_curso" => $id_curso,
        "id_turma" => $id_turma,
        "id_rua" => $id_rua
    ]);

} catch (Throwable $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao cadastrar aluno",
        "erro" => $e->getMessage()
    ]);
}

?>