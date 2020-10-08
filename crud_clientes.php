<?php
session_start();

# conecta com o BD
include('conexao.php');

# inicializa variáveis
$nomecli = "";
$endercli = "";
$fonecli = "";
$emailcli = "";
$idcli = 0;
$update = false;

# adiciona produto
if (isset($_POST['adiciona'])) {
    $nomecli = filter_input(INPUT_POST, 'nomecli');
    $endercli = filter_input(INPUT_POST, 'endercli');
    $fonecli = filter_input(INPUT_POST, 'fonecli');
    $emailcli = filter_input(INPUT_POST, 'emailcli',FILTER_VALIDATE_EMAIL);


    if ($nomecli && $endercli && $fonecli && $emailcli) {
        mysqli_query($db, "INSERT INTO clientes (nomecli, endercli,fonecli,emailcli) VALUES ('$nomecli', '$endercli','$fonecli','$emailcli')");

        # grava mensagem na sessão
        $_SESSION['message'] = "Cliente adicionado com sucesso!";

        header('location: clientes.php');
    } else {
        $_SESSION['message'] = "Preencha os campos corretamente! $nomecli,$endercli,$fonecli,$emailcli";


        header('location: clientes.php');
    }
}

# altera produto
if (isset($_POST['altera'])) {
    $idcli = $_POST['idcli'];
    $nomecli = filter_input(INPUT_POST, 'nomecli');
    $endercli = filter_input(INPUT_POST, 'endercli');
    $fonecli = filter_input(INPUT_POST, 'fonecli');
    $emailcli = filter_input(INPUT_POST, 'emailcli',FILTER_VALIDATE_EMAIL);

    if ($nomecli && $endercli && $fonecli && $emailcli) {

        $sql = "UPDATE clientes SET nomecli='$nomecli',endercli='$endercli',fonecli='$fonecli',emailcli='$emailcli' WHERE idcli = $idcli";
        mysqli_query($db, $sql);
        # grava mensagem na sessão
        $_SESSION['message'] = "Cliente alterado com sucesso!";

        header('location: clientes.php');
    } else {
        $_SESSION['message'] = "Preencha os campos corretamente!";


        header('location: clientes.php');
    }
}

# remove produto
if (isset($_GET['del'])) {
    $idcli = $_GET['del'];
    mysqli_query($db, "DELETE FROM clientes WHERE idcli=$idcli");

    # grava mensagem na sessão
    $_SESSION['message'] = "Cliente removido!";
    header('location: clientes.php');
}
