<?php
require_once __DIR__ . '/../Config/web-extends.php';
//Token randômico
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Library | Acervos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../views/css/layout-main.css">
    <link rel="shortcut icon" href="../public/img/favicon-colegio.ico" type="image/x-icon"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;1,100;1,300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
</head>

<body>

    <?php
    // Include Menu Sidebar
    require_once __DIR__ . '/../Includes/Menu_Sidebar.php';  
    ?>


<!----NavbBar Start------------------------------------>
    <div id="content">
        <div class="top-navbar">
            <div class="xd-topbar">
                <div class="row">
                    <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
                        <div class="xp-menubar">
                            <span class="material-icons text-white">signal_cellular_alt</span>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-3 order-3 order-md-2">
                    </div>
                    <div class="col-10 col-md-6 col-lg-8 order-1 order-md-3">
                        <div class="xp-profilebar text-right">
                            <nav class="navbar p-0">
                                <ul class="nav navbar-nav flex-row ml-auto">
                                    <li class="dropdown nav-item">
                                        <a class="nav-link" href="#" data-toggle="dropdown">
                                            <img src="../public/img/perfil.png" alt="Imagem do usuário" style="width: 40px; border-radius:50%;" />
                                            <span class="xp-user-live"></span>
                                        </a>
                                        <ul class="dropdown-menu small-menu">
                                            <li><a href="#"><span class="material-icons">person_outline</span><?php echo 'Olá, ' . $userName; ?></li>
                                            <li><a href="../Controllers/LogoutController.php"><span class="material-icons">logout</span>Sair</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="xp-breadcrumbbar text-center">
                    <h4 class="page-title">Acervos</h4>
                    <ol class="breadcrumb">
                        <li class="sub-titulo"><a>School Library / Acervos</a></li>
                    </ol>
                </div>
            </div>
        </div>
<!----Menu Sidebar END--------------------------------->



<!---------Tabela Principal-content-Start-------------->
        <div class="main-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-wrapper">
                        <div class="table-title">
                            <div class="row">
                                <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                                    <h2 class="ml-lg-2">Acervos</h2>
                                </div>
                                <div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
                                    <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                                        <i class="material-icons">&#xE147;</i>
                                        <span>Adicionar</span>
                                    </a>
                                    <div class="container">
                                        <div class="box-search">
                                            <input type="search" class="form-control" placeholder="Informe o Endereço" id="pesquisar">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Endereço</th>
                                        <th>Status</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    try {
                                        if (!isset($pdo)) {
                                            throw new Exception('A conexão com o banco de dados não foi estabelecida.');
                                        }

                                        $sql = "SELECT * FROM acervo WHERE StatusAcervo = 'Ativo' ORDER BY data_registro DESC";
                                        $result = $pdo->query($sql);

                                        if ($result->rowCount() > 0) {
                                            while ($acervo_data = $result->fetch(PDO::FETCH_ASSOC)) {

                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($acervo_data['codAcervo']) . "</td>";
                                                echo "<td>" . htmlspecialchars($acervo_data['Acervo']) . "</td>";
                                                echo "<td>" . htmlspecialchars($acervo_data['StatusAcervo']) . "</td>";

                                                echo "<td class='col-lg-3'>
                                                    <a href='#editEmployeeModal' class='edit editarAcervo btn btn-warning' data-toggle='modal'>Editar</a>
                                                    </td>";
                                                echo "<tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='12'>Nenhum resultado encontrado.</td></tr>";
                                        }
                                    } catch (PDOException $e) {
                                        echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
<!---------Tabela Principal-content-END---------------->



<!-------------Popup Adicionar Acervo-Start------------->
                <div class="modal fade" tabindex="-1" id="addEmployeeModal" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Adicionar acervo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="../Models/Insert_Acervo.php" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Acervo</label>
                                        <input type="text" name="AddAcervo" maxlength="20" x class="form-control" required>
                                        <label>Status</label>
                                        <select name="AddStatus" class="form-control" required>
                                            <option value="Ativo">Ativo</option>
                                            <option value="Inativo">Inativo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <input type="submit" name="submit" id="submit" class="btn btn-success" value="Adicionar">
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
<!-------------Popup Adicionar Acervo--END-------------->



<!-------------Popup Editar Acervo-Start---------------->
                <div class="modal fade" tabindex="-1" id="editEmployeeModal" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar acervo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="../Models/Update_Acervo.php" id="cadastroFormu">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="hidden" name="codAcervo" id="codAcervo" class="form-control">
                                        <label>Acervo</label>
                                        <input type="text" name="editaAcervo" id="editaAcervo" class="form-control">
                                        <label>Status</label>
                                        <select name="editaStatus" id="editaStatus" class="form-control">
                                            <option value="Ativo">Ativo</option>
                                            <option value="Inativo">Inativo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <input type="submit" name="update" id="update" class="btn btn-success" value="Atualizar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
<!-------------Popup Editar Acervo-END------------------>
            </div>
        </div>
    </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="../public/js/SweetAlert_Insert_Acervo.js"></script>
<script src="../public/js/SweetAlert_Update_Acervo.js"></script>
<script src="../public/js/EditCamposAcervo.js"></script>
<script src="../public/js/PesquisarAutor.js"></script>
<script src="../public/js/MenuSidebar.js"></script>

</html>