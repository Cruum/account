
<?php

require 'include/_database.php';
// require 'includes/_functions.php';

// exit
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opérations de Juillet 2023 - Mes Comptes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>



<body>

    <div class="container-fluid">
        <header class="row flex-wrap justify-content-between align-items-center p-3 mb-4 border-bottom">
            <a href="index.html" class="col-1">
                <i class="bi bi-piggy-bank-fill text-primary fs-1"></i>
            </a>
            <nav class="col-11 col-md-7">
                <ul class="nav">
                    <li class="nav-item">
                        <a href="index.html" class="nav-link link-secondary" aria-current="page">Opérations</a>
                    </li>
                    <li class="nav-item">
                        <a href="summary.html" class="nav-link link-body-emphasis">Synthèses</a>
                    </li>
                    <li class="nav-item">
                        <a href="categories.html" class="nav-link link-body-emphasis">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a href="import.html" class="nav-link link-body-emphasis">Importer</a>
                    </li>
                </ul>
            </nav>
            <form action="" class="col-12 col-md-4" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Rechercher..."
                        aria-describedby="button-search">
                    <button class="btn btn-primary" type="submit" id="button-search">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </header>
    </div>

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
$query = $dbCo->prepare("SELECT transaction.id_transaction, transaction.name, transaction.amount, transaction.date_transaction, category.category_name, category.icon_class FROM transaction LEFT JOIN category ON transaction.id_category = category.id_category WHERE DATE_FORMAT(transaction.date_transaction, '%Y-%m') = '2023-07' ORDER BY transaction.date_transaction DESC");                    $query->execute();
                    $result = $query->fetchAll();
                        // var_dump($result);
                        
                        ?>
                    <?php


foreach($result as $sold){
    echo '<tr data-id="'.$sold['id_transaction'].'">
        <td width="50" class="ps-3">
            <i class="bi bi-'.$sold['icon_class'].' fs-3"></i>
        </td>
        
        <td>
            <time datetime="" class="d-block fst-italic fw-light" data-text-id="'.$sold['id_transaction'].'">'. $sold['date_transaction'] .'</time>
            '.$sold['name'].'
        </td>
        <td class="text-end">
            <span class="rounded-pill text-nowrap bg-warning-subtle px-2">
                '.$sold['amount'].'
            </span>
        </td>
        <td class="text-end text-nowrap">
                <input type="hidden" name="id" value="'.$sold['id_transaction'].'">
                <button  class="btn btn-outline-primary btn-sm rounded-circle">
                    <i class="bi bi-pencil"></i>
                </button>
          
            <a href="delete.php?id='.$sold['id_transaction'].'" class="btn btn-outline-danger btn-sm rounded-circle">
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
                            <a class="page-link" href="index.html">Juin 2023</a>
                        </li>
                        <li class="page-item">
                            <span class="page-link">...</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.html">
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

    <footer class="py-3 mt-4 border-top">
        <p class="text-center text-body-secondary">© 2023 Mes comptes</p>
    </footer>
    <template id="renameFormTemplate">
        <form action="" method="post" data-form-id="">
            <input type="text" name="choiceText" value="">
            <input type="hidden" name="idChoice" value="">
            <input type="submit" value="valider">
        </form>
    </template>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script> 
</body>

</html>