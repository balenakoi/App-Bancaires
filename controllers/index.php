<?php

// On enregistre notre autoload.
function chargerClasse($classname)
{
    if (file_exists('../models/' . $classname . '.php')) {
        require '../models/' . $classname . '.php';
    } else {
        require '../entities/' . $classname . '.php';
    }
}
spl_autoload_register('chargerClasse');

// //conection to database
$db = Database::DB();

$AccountManager = new AccountManager($db);
$arrayAccounts = ['Compte courant', 'PEL', 'Livret A', 'Compte Joint'];
$_SESSION['Error'] = "ce compte est déja existe.";

// verifaction for creating an account
if (!empty($_POST['name'])) {
    if ($_POST['name'] == 'Compte courant' || $_POST['name'] == 'PEL' || $_POST['name'] == 'Livret A' || $_POST['name'] == 'Compte Joint') {
        if ($AccountManager->existAccount() == 0) {
        // create new account
            $createAccount = new Account([
                'name' => addslashes(strip_tags($_POST['name'])),
                'balance' => 80
            ]);
            $AccountManager->addAccount($createAccount);


        } else {
            echo $_SESSION['Error'];
        }
    }
}


//verifaction and geting payment
if (!empty($_POST['payment']) && !empty($_POST['balance']) && !empty($_POST['id'])) {

    $payment = htmlspecialchars(addslashes(strip_tags($_POST['payment'])));
    $id = htmlspecialchars(addslashes(strip_tags($_POST['id'])));
    $balance = htmlspecialchars(addslashes(strip_tags($_POST['balance'])));

    $getAccount = $AccountManager->getAccountId($id);
    $getAccount->paymentBalance($balance);
    $AccountManager->updateAccount($getAccount);
}


//verifaction and withdrawal money
if (!empty($_POST['debit']) && !empty($_POST['balance']) && !empty($_POST['id'])) {

    $debit = htmlspecialchars(addslashes(strip_tags($_POST['debit'])));
    $id = htmlspecialchars(addslashes(strip_tags($_POST['id'])));
    $balance = htmlspecialchars(addslashes(strip_tags($_POST['balance'])));

    $takeAccount = $AccountManager->getAccountId($id);
    $takeAccount->withdrawalBalance($balance);
    $AccountManager->updateAccount($takeAccount);

}


//verifaction and transfer money
if (!empty($_POST['idDebit']) && !empty($_POST['idPayment']) && !empty($_POST['balance']) && !empty($_POST['transfer'])) {

    $idDebit = htmlspecialchars(addslashes(strip_tags($_POST['idDebit'])));
    $idPayment = htmlspecialchars(addslashes(strip_tags($_POST['idPayment'])));
    $balance = htmlspecialchars(addslashes(strip_tags($_POST['balance'])));
    $transfert = htmlspecialchars(addslashes(strip_tags($_POST['transfer'])));

    if ($idPayment !== $idDebit) {
        $giveMoney = $AccountManager->getAccountId($idDebit);
        $takeMoney = $AccountManager->getAccountId($idPayment);
        $giveMoney->sendBalance($takeMoney, $balance);
        $AccountManager->updateAccount($giveMoney);
        $AccountManager->updateAccount($takeMoney);
    }
}



//verifaction and deleting an account
if (isset($_POST['id']) && isset($_POST['delete'])) {


    $delete = intval($_POST['id']);
    $AccountManager->deleteAccount($delete);

}
$takeAccounts = $AccountManager->getAccounts();

include "../views/indexView.php";
