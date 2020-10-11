<?php include('../models/sessao_login.php')?>

<?php include('../controllers/crud_produtos.php'); ?>

<?php
# recupera o registro para edição
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($db, "SELECT * FROM produtos WHERE id=$id");
    # testa o retorno do select e cria o vetor com os registros trazidos

    if ($record) {
        $n = mysqli_fetch_array($record);
        $nome = $n['nome'];
        $descricao = $n['descricao'];
        $qtdEstoque = $n['qtdEstoque'];
        $precoUnitario = $n['precoUnitario'];
        $ptoReposicao = $n['ptoReposicao'];
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link rel="stylesheet" type="text/css" href="../css/style_register.css">
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
    <?php $results = mysqli_query($db, "SELECT * FROM produtos"); ?>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Estoque</th>
                <th>Preço</th>
                <th>Reposiçao</th>
                <th colspan="4">Ação</th>
            </tr>
        </thead>
        <!-- cria o vetor com os registros trazidos do select -->
        <!-- Início while -->
        <?php while ($rs = mysqli_fetch_array($results)) { ?>
            <tr>
                <td><?php echo $rs['id']; ?></td>
                <td><?php echo $rs['nome']; ?></td>
                <td><?php echo $rs['descricao']; ?></td>
                <td><?php echo $rs['qtdEstoque']; ?></td>
                <td><?php echo $rs['precoUnitario']; ?></td>
                <td><?php echo $rs['ptoReposicao']; ?></td>
                <td>
                    <!--produtos.php?edit = <php echo 1; ?>"-->
                    <a href="produtos.php?edit=<?php echo $rs['id']; ?>" class="edit_btn">Alterar</a>
                </td>
                <td>
                    <a href="../controllers/crud_produtos.php?del=<?php echo $rs['id']; ?>" class="del_btn">Remover</a>
                </td>
            </tr>
        <?php } ?>
        <!-- Fim while -->
    </table>
    <!-- ------------------------------------------------------------ -->

    <form method="post" action="../controllers/crud_produto.php">
        <!-- campo oculto - contem o id do registro que vai ser atualizado -->
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div class="input-group">
            <label>Produto:</label>
            <!-- <input type="text" name="nome" value=""> -->
            <input type="text" name="nome" value="<?php echo $nome; ?>">
        </div>
        <div class="input-group">
            <label>Descrição:</label>
            <!-- <input type="text" name="descricao" value=""> -->
            <input type="text" name="descricao" value="<?php echo $descricao; ?>">
        </div>
        <div class="input-group">
            <label>Quantidade estoque:</label>
            <!-- <input type="text" name="descricao" value=""> -->
            <input type="text" name="qtdEstoque" value="<?php echo $qtdEstoque; ?>">
        </div>
        <div class="input-group">
            <label>Preço Unitário:</label>
            <!-- <input type="text" name="descricao" value=""> -->
            <input type="text" name="precoUnitario" value="<?php echo $precoUnitario; ?>">
        </div>
        <div class="input-group">
            <label>Ponto reposição:</label>
            <!-- <input type="text" name="descricao" value=""> -->
            <input type="text" name="ptoReposicao" value="<?php echo $ptoReposicao; ?>">
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