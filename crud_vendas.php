<?php
session_start();

# conecta com o BD
include('conexao.php');

# inicializa variáveis
$idcli = "";
$codven = 0;
$idprod = "";
$idcli = "";
$qtdven = "";
$update = false;

//testes
$hasStock = false;
$existCli = "";
$existProd = "";
# adiciona produto
if (isset($_POST['adiciona'])) {
    $idcli = filter_input(INPUT_POST, 'idcli', FILTER_VALIDATE_INT);
    $idprod = filter_input(INPUT_POST, 'idprod', FILTER_VALIDATE_INT);
    $qtdven = filter_input(INPUT_POST, 'qtdven', FILTER_VALIDATE_INT);

    if ($idprod && $idcli && $qtdven) {

        
    
        #verifica se cliente id existe
        $verificaCliente = mysqli_query($db, "SELECT idcli FROM clientes WHERE idcli = $idcli");
        $vCli = mysqli_fetch_array($verificaCliente);
        $vCli['idcli'] == $idcli ? $existCli = true : $existCli = false;

        #verifica se existe produto id
        $verificaProduto = mysqli_query($db, "SELECT id FROM produtos WHERE id=$idprod");
        $vPro = mysqli_fetch_array($verificaProduto);
        $vPro['id'] == $idprod ? $existProd = true : $existProd = false;

        #verifica se tem stock     
        $verificaQtd  = mysqli_query($db, "SELECT p.qtdEstoque FROM produtos p WHERE (p.id = $idprod)");
        while($vQtd = mysqli_fetch_array($verificaQtd)){
            if ($vQtd['qtdEstoque']<$qtdven) {
                $hasStock = false;
            } else {
                $hasStock = true;
            }
        }

        // exbibe erros se houverem ou adiciona no banco caso contrario
        if ($existCli == false) {
            $_SESSION['message'] = "ID do cliente não foi encontrado no banco de dados!";
            header('location: vendas.php');
        } else if ($existProd == false) {
            $_SESSION['message'] = "ID do Produto não foi encontrado no banco de dados!";
            header('location: vendas.php');
        } else if ($hasStock == false) {
            $_SESSION['message'] = "Quantidade de vendas maior do que o estoque!";
            header('location: vendas.php');
        } else {
            $mysql_result = mysqli_query($db, "INSERT INTO vendas (idcli,idprod,qtdven) VALUES ('$idcli', '$idprod','$qtdven')");
            # grava mensagem na sessão
            $_SESSION['message'] = "Venda cadastrada com sucesso!";
            header('location: vendas.php');
        }
    } else {
        $_SESSION['message'] = "Preencha os campos corretamente!";
        header('location: vendas.php');
    }
}
# altera produto
if (isset($_POST['altera'])) {
    $codven = $_POST['codven'];
    $idcli = filter_input(INPUT_POST, 'idcli', FILTER_VALIDATE_INT);
    $idprod = filter_input(INPUT_POST, 'idprod', FILTER_VALIDATE_INT);
    $qtdven = filter_input(INPUT_POST, 'qtdven', FILTER_VALIDATE_INT);
    if ($idcli && $idprod && $qtdven) {

         #verifica se tem stock     
         $verificaQtd  = mysqli_query($db, "SELECT p.qtdEstoque FROM produtos p, vendas v WHERE (v.codven = $codven) AND(p.id = $idprod)");
         $vQtd = mysqli_fetch_array($verificaQtd);
         if ($vQtd['qtdEstoque']< $qtdven) {
             $hasStock = false;
         } else {
             $hasStock = true;
         }
 
         #verifica se cliente id existe
         $verificaCliente = mysqli_query($db, "SELECT idcli FROM clientes WHERE idcli = $idcli");
         $vCli = mysqli_fetch_array($verificaCliente);
         $vCli['idcli'] == $idcli ? $existCli = true : $existCli = false;
 
         #verifica se existe produto id
         $verificaProduto = mysqli_query($db, "SELECT id FROM produtos WHERE id=$idprod");
         $vPro = mysqli_fetch_array($verificaProduto);
         $vPro['id'] == $idprod ? $existProd = true : $existProd = false;
 
 
         // exbibe erros se houverem ou adiciona no banco caso contrario
         if ($existCli == false) {
             $_SESSION['message'] = "ID do cliente não foi encontrado no banco de dados!";
             header('location: vendas.php');
         } else if ($existProd == false) {
             $_SESSION['message'] = "ID do Produto não foi encontrado no banco de dados!";
             header('location: vendas.php');
         } else if ($hasStock == false) {
             $_SESSION['message'] = "Quantidade de vendas maior do que o estoque!";
             header('location: vendas.php');
         } else {
            $sql = "UPDATE vendas SET idcli='$idcli',idprod='$idprod',qtdven='$qtdven' WHERE codven=$codven";
            mysqli_query($db, $sql);
            # grava mensagem na sessão
            $_SESSION['message'] = "Venda alterada com sucesso!";
            header('location: vendas.php');
         }
       
    } else {
        $_SESSION['message'] = "Preencha os campos corretamente!";


        header('location: vendas.php');
    }
}

# remove produto
if (isset($_GET['del'])) {
    $codven = $_GET['del'];
    mysqli_query($db, "DELETE FROM vendas WHERE codven=$codven");

    # grava mensagem na sessão
    $_SESSION['message'] = "Venda removida!";
    header('location: vendas.php');
}
