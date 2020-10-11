<?php
session_start();
if (!empty($_POST['login'] && $_POST['senha'])) {
    $dsn = 'mysql:host=localhost;dbname=loja';
    $usuario = 'root';
    $senhaBD = '';

    $email = $_POST['login'];
    $senha = $_POST['senha'];

    try {
        $conexao = new PDO($dsn, $usuario, $senhaBD);

        # montando o select
        $query = "SELECT * FROM usuarios where";
        $query .= " login = ? ";
        $query .= " AND senha = ? ";

        $stmt = $conexao->prepare($query);

        $stmt->bindValue(1, $_POST['login']);
        $stmt->bindValue(2, $_POST['senha']);

        # executando o select
        $stmt->execute();

        # ordenar a execução da query
        if ($stmt->rowCount()>0) {
            $_SESSION['loginOK'] = "Logado";
            header("Location: ../pages/loja.php");
        } else {
            $_SESSION['loginErro'] = "Usuário ou senha Inválido";
            header("Location: ../index.php");
        };
    } catch (PDOException $e) {
        echo 'Cod. Erro: ' . $e->getCode() . 'Messagem: ' . $e->getMessage();
    }
}
