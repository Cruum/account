
<?php

require 'include/_database.php';
// require 'includes/_functions.php';
session_start();
$_SESSION['token'] = md5(uniqid(mt_rand(), true));
// exit
?>
<?php
require 'include/header.php'

?>

    <div class="container">
        <section class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h2 class="my-0 fw-normal fs-4">Solde aujourd'hui</h2>
            </div>
            <div class="card-body">
            <?php
            $query = $dbCo->prepare("SELECT id_transaction, amount FROM transaction ");
                    $query->execute();
                    $results = $query->fetchAll();
                    
                    $somme = 0;
                    foreach ($results as $number) {
                        $somme += $number['amount'];
                    }
                
            ?>
                <p class="card-title pricing-card-title text-center fs-1">  <?= $somme ?>€</p>
            </div>
        </section>

        <section class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h1 class="my-0 fw-normal fs-4">Opérations de Juillet 2023</h1>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col" colspan="2">Opération</th>
                            <th scope="col" class="text-end">Montant</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
$query = $dbCo->prepare("SELECT transaction.id_transaction, transaction.name, transaction.amount, transaction.date_transaction, category.category_name, category.icon_class, category.id_category FROM transaction LEFT JOIN category ON transaction.id_category = category.id_category WHERE DATE_FORMAT(transaction.date_transaction, '%Y-%m') = '2023-07' ORDER BY transaction.date_transaction DESC");  
                      $query->execute();
                    $result = $query->fetchAll();
                        // var_dump($result);
                        
                        ?>
                    <?php


foreach($result as $sold){
    echo '<tr class = "reference"data-id="'.$sold['id_transaction'].'">
        <td width="50" class="ps-3">
            <i data-id-name='.$sold['category_name'].' class="bi bi-'.$sold['icon_class'].' fs-3"></i>
        </td>
        
        <td>
            <time datetime="" class="d-block fst-italic fw-light" data-text-id="'.$sold['id_transaction'].'">'. $sold['date_transaction'] .'</time>
            '.$sold['name'].'
        </td>
        <td class="text-end">
           
                '?> <?php
                if(floatval($sold['amount'] > 0)){
                   echo '<span class="bg-success-subtle">+' . $sold['amount'] . '</span>';
                } 
                else echo '<span class="bg-warning-subtle">+' . $sold['amount'] . '</span>' ?>
              <?php echo '
         
        </td>
        <td class="text-end text-nowrap">
        <a  href="edit.php?id_transaction='.$sold['id_transaction'].'&token=' . $_SESSION['token'] . ' &name='.$sold['name'].' &date='. $sold['date_transaction'] .'categorie='.$sold['category_name'].'&amount='.$sold['amount'].' " class="btn btn-outline-primary btn-sm rounded-circle" data-id="'.$sold['id_transaction'].'">
                    <i class="bi bi-pencil" data-id="'.$sold['id_transaction'].'"></i>
                </a>
          
                <a href="action.php?delete='.$sold['id_transaction'].'&token=' . $_SESSION['token'] . '" class="btn btn-outline-danger btn-sm rounded-circle">
                <i class="bi bi-trash"></i>
            </a>
        </td>
    </tr>';
}


?>


                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <nav class="text-center">
                    <ul class="pagination d-flex justify-content-center m-2">
                        <li class="page-item disabled">
                            <span class="page-link">
                                <i class="bi bi-arrow-left"></i>
                            </span>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">Juillet 2023</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.php">Juin 2023</a>
                        </li>
                        <li class="page-item">
                            <span class="page-link">...</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.php">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>
    </div>

    <div class="position-fixed bottom-0 end-0 m-3">
        <a href="add.php" class="btn btn-primary btn-lg rounded-circle">
            <i class="bi bi-plus fs-1"></i>
        </a>
    </div>

    <?php

require 'include/footer.php'
?>