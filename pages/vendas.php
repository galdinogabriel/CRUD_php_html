<?php include('sessao_login.php')?>

<?php include('crud_vendas.php'); ?>

<?php
# recupera o registro para edição
if (isset($_GET['edit'])) {
    $codven = $_GET['edit'];
    $update = true;
    $record = mysqli_query($db, "SELECT * FROM vendas WHERE codven=$codven");
    # testa o retorno do select e cria o vetor com os registros trazidos

    if ($record) {
        $n = mysqli_fetch_array($record);
        $codven = $n['codven'];
        $idcli = $n['idcli'];
        $idprod = $n['idprod'];
        $qtdven = $n['qtdven'];
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Vendas</title>
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
    <?php $results = mysqli_query($db, "SELECT V.codven, C.idcli, C.nomecli,P.id,P.nome, V.qtdven, V.qtdven * P.precoUnitario as valortotal from vendas as V
inner join clientes as C
on (V.idcli = C.idcli)
inner join produtos as P
on (P.id = V.idprod)"); ?>
    <table>
        <thead>
            <tr>
                <th>Cod. Venda</th>
                <th>Id Cliente</th>
                <th>Nome Cliente</th>
                <th>produto id</th>
                <th>produto nome</th>
                <th>Qtd Vendida</th>
                <th>Valor Total</th>

                <th colspan="4">Ação</th>
            </tr>
        </thead>
        <!-- cria o vetor com os registros trazidos do select -->
        <!-- Início while -->

        <?php while ($rs = mysqli_fetch_array($results)) { ?>
            <tr>
                <td><?php echo $rs['codven']; ?></td>
                <td><?php echo $rs['idcli']; ?></td>
                <td><?php echo $rs['nomecli']; ?></td>
                <td><?php echo $rs['id']; ?></td>
                <td><?php echo $rs['nome']; ?></td>
                <td><?php echo $rs['qtdven']; ?></td>
                <td><?php echo $rs['valortotal']; ?></td>
                <td>
                    <!--produtos.php?edit = <php echo 1; ?>"-->
                    <a href="vendas.php?edit=<?php echo $rs['codven']; ?>" class="edit_btn">Alterar</a>
                </td>
                <td>
                    <a href="crud_vendas.php?del=<?php echo $rs['codven']; ?>" class="del_btn">Remover</a>
                </td>
            </tr>
        <?php } ?>
        <!-- Fim while -->
    </table>
    <!-- ------------------------------------------------------------ -->

    <form method="post" action="crud_vendas.php">
    
        <input type="hidden" name="codven" value="<?php echo $codven; ?>">        
        <div class="input-group">
            <label>ID cliente:</label>
            <!-- <input type="text" name="nome" value=""> -->
            <input type="text" name="idcli" value="<?php echo $idcli; ?>">
        </div>
        <div class="input-group">
            <label>ID produto:</label>
            <!-- <input type="text" name="descricao" value=""> -->
            <input type="text" name="idprod" value="<?php echo $idprod; ?>">
        </div>
        <div class="input-group">
            <label>Qtd de Vendas:</label>
            <!-- <input type="text" name="descricao" value=""> -->
            <input type="text" name="qtdven" value="<?php echo $qtdven; ?>">
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