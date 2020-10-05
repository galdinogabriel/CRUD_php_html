<?php include('crud.php'); 

    $close = mysqli_close($db);

    if($close == true){
        header('location: index.html');
    }else{
        $_SESSION['message'] = "Falha ao fechar conexao com banco de dados!";
    }
    
?>