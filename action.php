<?php
require 'include/_database.php';



session_start();
if (!(array_key_exists('HTTP_REFERER', $_SERVER)) && str_contains($_SERVER['HTTP_REFERER'], $_ENV["URL"])) {
    header('Location: index.php?msg=error_referer');
    exit;
} else if (!array_key_exists('token', $_SESSION) || !array_key_exists('token', $_REQUEST) || $_SESSION['token'] !== $_REQUEST["token"]) {
    //...
    header('Location: index.php?msg=error_csrf');
    exit;
}



if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $dateCreate = $_POST['date']; 
    $amount = $_POST['amount'];
    $idCategory = $_POST['category'];
    var_dump($name);
    $query = $dbCo->prepare("INSERT INTO transaction (name, amount, date_transaction, id_category) VALUES (:name, :amount, :date_transaction, :id_category)");
    $isOk = $query->execute([
        ':name' => strip_tags($name),
        ':amount' => intval($amount),
        ':date_transaction' => $dateCreate,
        ':id_category' => intval(strip_tags($idCategory)) 
        
    ]);
    
    header('Location: http://localhost/account/?msg=' . ($isOk ? 'La transaction a été ajoutée' : 'Un problème a été rencontré lors de l\'ajout de la transaction'));
    exit;
}