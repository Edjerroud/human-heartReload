<?php require_once '../include/functions.php';
session_start();

if (isset($_POST['validate'])) {

    $errors = array();
    require_once '../include/database.php'; //appel du fichier relationnel de la base de données

    //nom d'utilisateur conditions et implémentation dans la base de données
    if (empty($_POST['title'])) {
        $errors['title'] = "Ce titre ne peut être vide";
    } else {
        $req = $pdo->prepare('SELECT idcategorie FROM categorie WHERE `Title`=?');
        $req->execute([$_POST['title']]);
        $category = $req->fetch();
    }

    //envoi des données dans la base de données. cryptage du mot de passe
    if (empty($errors)) {
        require_once '../include/database.php';  //appel du fichier relationnel de la base de donnée
        $req = $pdo->prepare("INSERT INTO categorie (`Title`, don_iddon) value (?, ?)");
        $title = htmlspecialchars($_POST['title']);
        $don_iddon = htmlspecialchars($_POST['don_iddon']);
        $req->execute([$title,1]);
        $_SESSION['flash']['success'] = 'Votre categorie a bien été créé';
        header('Location: dashboardCategory.php');
        exit();
    }
}
