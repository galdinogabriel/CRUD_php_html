<?php

// destroi todas as sessoes
session_start();

session_destroy(); 

header("Location: ../index.php"); 
exit; 

?>
