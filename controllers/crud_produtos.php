<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<?php
# conecta com o BD
include('../repository/conexao.php');

# inicializa variáveis
$nome = "";
$descricao = "";
$qtdEstoque = "";
$ptoReposicao = "";
$precoUnitario = "";
$id = 0;
$update = false;

# adiciona produto
if (isset($_POST['adiciona'])) {
    $nome = filter_input(INPUT_POST, 'nome');
    $descricao = filter_input(INPUT_POST, 'descricao');
    $qtdEstoque = filter_input(INPUT_POST, 'qtdEstoque', FILTER_VALIDATE_INT);
    $precoUnitario = filter_input(INPUT_POST, 'precoUnitario', FILTER_VALIDATE_FLOAT, FILTER_VALIDATE_INT);
    $ptoReposicao = filter_input(INPUT_POST, 'ptoReposicao', FILTER_VALIDATE_INT);


    if ($nome && $descricao && $qtdEstoque && $precoUnitario && $ptoReposicao) {
        mysqli_query($db, "INSERT INTO produtos (nome, descricao,qtdEstoque,precoUnitario, ptoReposicao) VALUES ('$nome', '$descricao','$qtdEstoque','$precoUnitario','$ptoReposicao')");

        # grava mensagem na sessão
        $_SESSION['message'] = "Produto adicionado com sucesso!";

        header('location: produtos.php');
    } else {
        $_SESSION['message'] = "Preencha os campos corretamente!";


        header('location: ../pages/produtos.php');
    }
}

# altera produto
if (isset($_POST['altera'])) {
    $id = $_POST['id'];
    $nome = filter_input(INPUT_POST, 'nome');
    $descricao = filter_input(INPUT_POST, 'descricao');
    $qtdEstoque = filter_input(INPUT_POST, 'qtdEstoque', FILTER_VALIDATE_INT);
    $precoUnitario = filter_input(INPUT_POST, 'precoUnitario', FILTER_VALIDATE_FLOAT, FILTER_VALIDATE_INT);
    $ptoReposicao = filter_input(INPUT_POST, 'ptoReposicao', FILTER_VALIDATE_INT);

    if ($nome && $descricao && $qtdEstoque && $precoUnitario && $ptoReposicao) {

        $sql = "UPDATE produtos SET nome='$nome',descricao='$descricao',qtdEstoque='$qtdEstoque',precoUnitario='$precoUnitario',ptoReposicao='$ptoReposicao' WHERE id = $id";
        mysqli_query($db, $sql);
        # grava mensagem na sessão
        $_SESSION['message'] = "Produto alterado com sucesso!";

        header('location: ../pages/produtos.php');
    } else {
        $_SESSION['message'] = "Preencha os campos corretamente!";


        header('location: ../pages/produtos.php');
    }
}

# remove produto
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($db, "DELETE FROM produtos WHERE id=$id");

    # grava mensagem na sessão
    $_SESSION['message'] = "Produto removido!";
    header('location: ../pages/produtos.php');
}
