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
    <title>School Library | Usuários</title>
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


<!-------------NavbBar Start------------------------->
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
                    <h4 class="page-title">Usuários</h4>
                    <ol class="breadcrumb">
                        <li class="sub-titulo"><a>School Library / Usuários</a></li>
                    </ol>
                </div>
            </div>
        </div>
<!-------------NavbBar END--------------------------->



<!-------------Tabela Principal-content-Start-------->
        <div class="main-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-wrapper">
                        <div class="table-title">
                            <div class="row">
                                <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                                    <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                                        <i class="material-icons">&#xE147;</i>
                                        <span>Adicionar</span>
                                    </a>
                                    <a href="../Reports/Usuarios.php" target="_blank" class="btn btn-primary" id="gerarRelatorio">
                                        <i class="material-icons">&#xe8ad;</i>
                                        <span>Imprimir</span>
                                    </a>
                                    <h2 class="ml-lg-2">Usuários</h2>
                                </div>
                                <div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
                                    <div class="container">
                                        <div class="box-search">
                                            <input type="search" class="form-control" placeholder="Informe nome Usuário" id="pesquisar">
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
                                        <th>Matrícula</th>
                                        <th>Nome</th>
                                        <th>Telefone</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Tipo Usuario</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    try {
                                        if (!isset($pdo)) {
                                            throw new Exception('A conexão com o banco de dados não foi estabelecida.');
                                        }

                                        $sql = "SELECT * FROM usuarios ORDER BY data_registro DESC";
                                        $result = $pdo->query($sql);
                                        
                                        if ($result->rowCount() > 0) {
                                            while ($user_data = $result->fetch(PDO::FETCH_ASSOC)) {
                                                $statusClass = $user_data['user_status'] === 'Ativo' ? 'btn-danger' : 'btn-success';

                                                echo "<tr 
                                                data-idUsuario='" . htmlspecialchars($user_data['idUsuario'], ENT_QUOTES, 'UTF-8') . "'
                                                data-matricula='" . htmlspecialchars($user_data['matricula'], ENT_QUOTES, 'UTF-8') . "'
                                                data-nome='" . htmlspecialchars($user_data['nome'], ENT_QUOTES, 'UTF-8') . "'
                                                data-telefone='" . htmlspecialchars($user_data['telefone'], ENT_QUOTES, 'UTF-8') . "'
                                                data-email='" . htmlspecialchars($user_data['email'], ENT_QUOTES, 'UTF-8') . "'
                                                data-user-status='" . htmlspecialchars($user_data['user_status'], ENT_QUOTES, 'UTF-8') . "'
                                                data-user-tipo='" . htmlspecialchars($user_data['user_tipo'], ENT_QUOTES, 'UTF-8') . "'>";

                                                echo "<td>" . htmlspecialchars($user_data['idUsuario'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                echo "<td>" . htmlspecialchars($user_data['matricula'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                echo "<td>" . htmlspecialchars($user_data['nome'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                echo "<td style='width: 150px;'>" . htmlspecialchars($user_data['telefone'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                echo "<td>" . htmlspecialchars($user_data['email'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                echo "<td>" . htmlspecialchars($user_data['user_status'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                echo "<td>" . htmlspecialchars($user_data['user_tipo'], ENT_QUOTES, 'UTF-8') . "</td>";
                                            

                                                echo "<td class='col-lg-3'>
                                                    <a href='#editEmployeeModal' class='edit editarUsuario btn btn-warning' data-toggle='modal'>Editar</a>
                                                    <input type='button' class='btn btn-status {$statusClass}' data-matricula='{$user_data['matricula']}' data-novo-status='" . ($user_data['user_status'] === 'Ativo' ? 'Inativo' : 'Ativo') . "' value='" . ($user_data['user_status'] === 'Ativo' ? 'Inativar' : 'Ativar') . "'>
                                                    </td>";
                                                echo "</tr>";
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
<!-------------Tabela Principal-content-END---------->



<!-------------Popup Adicionar Usuário-Start---------->
                <div class="modal fade" tabindex="-1" id="addEmployeeModal" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Adicionar Usuário</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="../Models/Insert_Usuario.php" id="cadastroForm">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Matrícula</label>
                                        <input type="text" name="matricula" maxlength="9" class="form-control" required>
                                        <label>Nome</label>
                                        <input type="text" name="nome" maxlength="60" class="form-control" required>
                                        <label>Telefone</label>
                                        <input type="tel" name="telefone" maxlength="14" class="form-control" required>
                                        <label>E-mail</label>
                                        <input type="email" name="email" maxlength="60" class="form-control" required>
                                        <label>Senha</label>
                                        <input type="password" name="senha" maxlength="100" class="form-control" required>
                                        <div id="password-strength"></div> <!-- Exibir msg da força da senha -->
                                        <label>Tipo usuário</label>
                                        <select name="user_tipo" maxlength="15" class="form-control" required>
                                            <option value="Administrador">Administrador</option>
                                            <option value="Diretora">Diretora</option>
                                            <option value="Professor">Professor</option>
                                        </select>
                                        <label>Status conta</label>
                                        <select name="user_status" class="form-control" required>
                                            <option value="Ativo">Ativo</option>
                                            <option value="Inativo">Inativo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <input type="submit" name="submit" id="submitAdicionar" class="btn btn-success" value="Adicionar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
<!-------------Popup Adicionar Usuário--END----------->




<!-------------Popup Editar Usuário-Start---------------->
                <div class="modal fade" tabindex="-1" id="editEmployeeModal" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar usuário</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="../Models/Update_Usuario.php" id="updateForm">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="hidden" name="idUsuario" id="idUsuario" class="form-control">
                                        <label>Matrícula</label>
                                        <input type="text" name="matricula" id="matricula" maxlength="9" class="form-control">
                                        <label>Nome</label>
                                        <input type="text" name="editarNome" id="editarNome" maxlength="60" class="form-control">
                                        <label>Telefone</label>
                                        <input type="tel" name="editarTelefone" id="editarTelefone" maxlength="14" class="form-control">
                                        <label>E-mail</label>
                                        <input type="email" name="editarEmail" id="editarEmail" maxlength="100" class="form-control">
                                        <label>Tipo Usuário</label>
                                        <select name="editarTipoUser" id="editarTipoUser" class="form-control">
                                            <option value="Administrador">Administrador</option>
                                            <option value="Diretora">Diretora</option>
                                            <option value="Professor">Professor</option>
                                            <option value="Bibliotecaria">Bibliotecaria</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" name="update" id="update" class="btn btn-success">Atualizar</button>
                                </div>
                            </form>
                        </div>
                    </div>
<!-------------Popup Editar usuário-END------------------>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="../public/js/EditCamposUsuarios.js"></script>
<script src="../public/js/MenuSidebar.js"></script>
<script src="../public/js/SweetAlert_Update_Usuario.js"></script>
<script src="../public/js/SweetAlert_Insert_Usuario.js"></script>
<script src="../public/js/Inativar_Usuario.js"></script>
<script src="../public/js/SenhaForte.js"></script>
<script src="../public/js/Pesquisar.js"></script>

</html>