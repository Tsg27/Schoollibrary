<?php
require_once __DIR__ . '/../Config/bootstrap.php';

if (!isset($_POST['id_aluno'])) {
    echo json_encode([]);
    exit;
}

$idAluno = $_POST['id_aluno'];

try {
    // Busca a matrícula do aluno
    $stmtAluno = $pdo->prepare("SELECT matricula FROM alunos WHERE id_Aluno = :idAluno");
    $stmtAluno->bindParam(':idAluno', $idAluno, PDO::PARAM_INT);
    $stmtAluno->execute();
    $aluno = $stmtAluno->fetch(PDO::FETCH_ASSOC);

    if (!$aluno) {
        echo json_encode([]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT TituloLivro, DataEmprestimo, DataDevolucao 
    FROM emprestimo 
    WHERE MatriculaAluno = :matricula 
    AND StatusEmprestimo = 'Emprestado'");
    $stmt->bindParam(':matricula', $aluno['matricula'], PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (PDOException $e) {
    echo json_encode([]);
}
?>
