<?php
// Inicia sessões
session_start();

// Verifica se existe os dados da sessão de login
if(!isset($_SESSION["loginOK"]))
{
// Usuário não logado! Redireciona para a página de login
header("Location: ../index.php");
exit;
}
?>

<?php include('../controllers/crud_clientes.php'); ?>

<?php
# recupera o registro para edição
if (isset($_GET['edit'])) {
    $idcli = $_GET['edit'];
    $update = true;
    $record = mysqli_query($db, "SELECT * FROM clientes WHERE idcli=$idcli");
    # testa o retorno do select e cria o vetor com os registros trazidos

    if ($record) {
        $n = mysqli_fetch_array($record);
        $nomecli = $n['nomecli'];
        $endercli = $n['endercli'];
        $fonecli = $n['fonecli'];
        $emailcli = $n['emailcli'];
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
    <link rel="stylesheet" type="text/css" href="css/style_register.css">
</head>

<body>

    <!-- teste se a sessão existe e exibe sua mensagem -->
    <?php if (isset($_SESSION['message'])) : ?>
        <div class="msg">
            <?php
            # exibe mensagem da sessão
            echo $_SESSION['message'];
            # apaga a sessão
            unset($_SESSION['message']);
            ?>
        </div>
    <?php endif ?>
    <!-- ------------------------------------------------- -->

    <!-- recupera os registros do banco de dados e exibe na página -->
    <?php $results = mysqli_query($db, "SELECT * FROM clientes"); ?>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Fone</th>
                <th>Email</th>
                <th colspan="4">Ação</th>
            </tr>
        </thead>
        <!-- cria o vetor com os registros trazidos do select -->
        <!-- Início while -->
        <?php while ($rs = mysqli_fetch_array($results)) { ?>
            <tr>
                <td><?php echo $rs['idcli']; ?></td>
                <td><?php echo $rs['nomecli']; ?></td>
                <td><?php echo $rs['fonecli']; ?></td>
                <td><?php echo $rs['emailcli']; ?></td>
                <td>
                    <!--produtos.php?edit = <php echo 1; ?>"-->
                    <a href="clientes.php?edit=<?php echo $rs['idcli']; ?>" class="edit_btn">Alterar</a>
                </td>
                <td>
                    <a href="crud_clientes.php?del=<?php echo $rs['idcli']; ?>" class="del_btn">Remover</a>
                </td>
            </tr>
        <?php } ?>
        <!-- Fim while -->
    </table>
    <!-- ------------------------------------------------------------ -->

    <form method="post" action="crud_clientes.php">
        <!-- campo oculto - contem o id do registro que vai ser atualizado -->
        <input type="hidden" name="idcli" value="<?php echo $idcli; ?>">

        <div class="input-group">
            <label>Nome:</label>
            <!-- <input type="text" name="nome" value=""> -->
            <input type="text" name="nomecli" value="<?php echo $nomecli; ?>">
        </div>
        <div class="input-group">
            <label>Endereço:</label>
            <!-- <input type="text" name="descricao" value=""> -->
            <input type="text" name="endercli" value="<?php echo $endercli; ?>">
        </div>
        <div class="input-group">
            <label>Fone:</label>
            <!-- <input type="text" name="descricao" value=""> -->
            <input type="text" name="fonecli" value="<?php echo $fonecli; ?>">
        </div>
        <div class="input-group">
            <label>Email:</label>
            <!-- <input type="text" name="descricao" value=""> -->
            <input type="text" name="emailcli" value="<?php echo $emailcli; ?>">
        </div>
        <div class="input-group">
            <!-- <button class="btn" type="submit" name="adiciona">Adicionar</button> -->
            <?php if ($update == true) : ?>
                <button class="btn" type="submit" name="altera" style="background: #556B2F;">Alterar</button>
            <?php else : ?>
                <button class="btn" type="submit" name="adiciona">Adicionar</button>
                <a href="close_connection.php" class="back_btn">Página Inicial</a>

            <?php endif ?>

        </div>
    </form>
</body>

</html>