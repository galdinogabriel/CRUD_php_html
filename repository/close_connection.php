<?php include('crud.php'); 

    $close = mysqli_close($db);

    if($close == true){
        header('location: loja.php');
    }else{
        $_SESSION['message'] = "Falha ao fechar conexao com banco de dados!";
    }
    
?>