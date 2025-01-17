<?php
session_start();
require_once __DIR__ . '/../Config/web_extends.php';
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
        // Filtra os dados do formulário usando htmlspecialchars() e filter_input()
        $codObra = htmlspecialchars(filter_input(INPUT_POST, 'codObra', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
        $isbn = htmlspecialchars(filter_input(INPUT_POST, 'editaIsbn', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
        $titulo = htmlspecialchars(filter_input(INPUT_POST, 'editaTitulo', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
        $subtitulo = htmlspecialchars(filter_input(INPUT_POST, 'editaSubtitulo', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
        $autor = htmlspecialchars(filter_input(INPUT_POST, 'editaAutor', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
        $edicao = htmlspecialchars(filter_input(INPUT_POST, 'editaEdicao', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
        $ano = htmlspecialchars(filter_input(INPUT_POST, 'editaAno', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
        $copia = htmlspecialchars(filter_input(INPUT_POST, 'editaCopia', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
        $acervo = htmlspecialchars(filter_input(INPUT_POST, 'editaAcervo', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
        $genero = htmlspecialchars(filter_input(INPUT_POST, 'editaGenero', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
        $editora = htmlspecialchars(filter_input(INPUT_POST, 'editaEditora', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');
        $situacao = htmlspecialchars(filter_input(INPUT_POST, 'editaSituacao', FILTER_DEFAULT), ENT_QUOTES, 'UTF-8');

       
        // Cria a query de atualização usando Prepared Statements
        $sqlUpdateObra = "UPDATE obra SET Isbn = :isbn, Titulo = :titulo, SubTitulo = :subtitulo, Autor = :autor, Edicao = :edicao, Ano = :ano, Copia = :copia, Acervo = :acervo, Genero = :genero, Editora = :editora, Situacao = :situacao WHERE CodObra = :codObra";
        $stmtUpdateObra = $pdo->prepare($sqlUpdateObra);

        if (!$stmtUpdateObra) {
            throw new Exception("Erro na preparação da declaração: " . $pdo->errorInfo()[2]);
        }

        // Vincula os parâmetros com os valores
        $stmtUpdateObra->bindValue(':codObra', $codObra);
        $stmtUpdateObra->bindValue(':isbn', $isbn);
        $stmtUpdateObra->bindValue(':titulo', $titulo);
        $stmtUpdateObra->bindValue(':subtitulo', $subtitulo);
        $stmtUpdateObra->bindValue(':autor', $autor);
        $stmtUpdateObra->bindValue(':edicao', $edicao);
        $stmtUpdateObra->bindValue(':ano', $ano);
        $stmtUpdateObra->bindValue(':copia', $copia);
        $stmtUpdateObra->bindValue(':acervo', $acervo);
        $stmtUpdateObra->bindValue(':genero', $genero);
        $stmtUpdateObra->bindValue(':editora', $editora);
        $stmtUpdateObra->bindValue(':situacao', $situacao);

        // Executa a query de atualização na tabela obra
        if ($stmtUpdateObra->execute()) {
            // Redireciona o usuário para a página de origem
            header("Location: http://localhost/schoollibrary/views/Obra.php");
            exit();
        } else {
            throw new Exception("Erro na atualização da tabela obra");
        }
    } catch (PDOException $e) {
        // Tratar exceções de conexão PDO
        echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
        exit();
    } catch (Exception $e) {
        // Tratar outras exceções
        echo "Ocorreu um erro: " . $e->getMessage();
        exit();
    } finally {
        // Fecha as declarações e a conexão com o banco de dados
        $stmtUpdateObra = null;
        $pdo = null;
    }
}
?>
