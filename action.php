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


// Add a transaction on BDD and on index
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




// DELETE transaction
if (isset($_GET['delete'])) {
    $id_transaction = $_GET['delete'];
    $query = $dbCo->prepare("DELETE FROM transaction WHERE id_transaction = :id_transaction");
    $isOk = $query->execute([
        ':id_transaction' => intval(strip_tags($id_transaction))
    ]);

    header('Location: index.php?msg=' . ($isOk ? 'La tâche a été supprimée' : 'La tâche n\'a pas pu être supprimée'));
    exit;
}


//Edit transaction
if (isset($_POST['edit'])) {
    $name = $_POST['name'];
    $dateCreate = $_POST['date']; 
    $amount = $_POST['amount'];
    $idCategory = $_POST['category'];
    var_dump($name);
    $query = $dbCo->prepare("UPDATE transaction SET (name, amount, date_transaction, id_category) VALUES (:name, :amount, :date_transaction, :id_category)");
    $isOk = $query->execute([
        ':name' => strip_tags($name),
        ':amount' => intval($amount),
        ':date_transaction' => $dateCreate,
        ':id_category' => intval(strip_tags($idCategory)) 
        
    ]);
    
    header('Location: http://localhost/account/?msg=' . ($isOk ? 'La transaction a été ajoutée' : 'Un problème a été rencontré lors de l\'ajout de la transaction'));
    exit;
}