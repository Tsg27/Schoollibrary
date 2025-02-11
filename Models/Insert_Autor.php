<?php
session_start();
require_once __DIR__ . '/../Config/bootstrap.php';
require_once __DIR__ . '/../Config/verify_csrf.php';



// Gera o token CSRF se ainda não existir
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Verifica o token CSRF
        if (!verify_csrf_token($_POST['csrf_token'])) {
            throw new Exception('Token CSRF inválido');
        }
        
        // Filtrando os dados do formulário usando htmlspecialchars()
        $Autor = htmlspecialchars(filter_input(INPUT_POST, 'addAutor', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
        $Status = htmlspecialchars(filter_input(INPUT_POST, 'addStatus', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');

        // Verificando se os campos obrigatórios estão preenchidos
        if (empty($Autor) || empty($Status)) {
            exit();
        }

        // Cria a query de inserção usando Prepared Statements
        $sql = "INSERT INTO Autor (NomeAutor, StatusAutor, data_registro) VALUES (?, ?, NOW())";
        $stmt = $pdo->prepare($sql);

        if (!$stmt) {
            echo "Erro na preparação da declaração: " . $pdo->errorInfo()[2];
            exit;
        }

        // Vincula os parâmetros com os valores
        $stmt->bindParam(1, $Autor);
        $stmt->bindParam(2, $Status);

        if ($stmt->execute()) {
            // Redireciona o usuário para a página de origem.
            header("Location: http://localhost/schoollibrary/views/Autor.php");
            exit(); 
        } else {
            // Se ocorreu algum erro na inserção, exibe uma mensagem de erro
            echo "Ocorreu um erro durante o cadastro. Tente novamente mais tarde.";
        }
    } catch (Exception $e) {
        echo "Ocorreu um erro: " . $e->getMessage();
        exit();
    }

    // Fecha a declaração e a conexão com o banco de dados
    $stmt = null;
    $pdo = null;
}
?>
