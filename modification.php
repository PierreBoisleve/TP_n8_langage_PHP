<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifications</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">TP n°8 PHP</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="citation.php">Informations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="recherche.php">Recherche</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="modification.php">Modifications</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<body>
<br>
<?php
include 'database/connexpdo.php';

//Connect BDD
try{
    $db = connexpdo('pgsql:dbname=citations;host=localhost;port=5433','postgres','new_password');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //pour activer l'affichage des erreurs pdo
} catch(PDOException $e){
    echo 'ERROR: ' . $e->getMessage();
}

echo '<div class="container col-sm-9 jumbotron" ><h1>Ajouter une citation</h1><hr>
        <form method="POST" action="modification.php">
            <div class="form-group">
                <label>ID de l\'auteur</label>
                <input name="authorId" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nom de l\'auteur</label>
                <input name="authorLastName" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Prénom de l\'auteur</label>
                <input name="authorFirstName" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label>ID du siècle</label>
                <input name="centuryId" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Siècle</label>
                <input name="century" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Citation</label>
                <input name="citationChoice" type="text" class="form-control" required>
            </div><br>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
<br><br>';

echo '<h1>Supprimer une citation</h1><hr><br>
        <form method="POST" action="modification.php">
            <div class="form-group">
                <select class="form-control" name="citationChoiceId">
                    <option selected disabled>Sélectionnez l\'ID d\'une citation</option>';
$query = "SELECT id, phrase FROM citation";
$numero = $db->query($query);
foreach ($numero as $data){
    echo "<option value=".$data['id'].">".$data['phrase']."</option>";
}

echo'           </select>
             </div><br>
            <button type="submit" class="btn btn-primary">Supprimer</button>
        </form>
';

echo '</div>';

//Formulaire d'ajout
$auteurId=$_POST['authorId'];
$auteurNom=$_POST['authorLastName'];
$auteurPrenom=$_POST['authorFirstName'];
$siecleId=$_POST['centuryId'];
$siecle=$_POST['century'];
$citation=$_POST['citationChoice'];

if($_POST['authorId'] != NULL && $_POST['authorLastName'] != NULL && $_POST['authorFirstName'] != NULL
    && $_POST['centuryId'] != NULL && $_POST['century'] != NULL && $_POST['citationChoice'] != NULL) {

    $nbr_citations = 0;
    $query0 = "SELECT phrase FROM citation";
    $nbr = $db->query($query0);
    foreach ($nbr as $data) {
        $nbr_citations++;
    }
    $nbr_citations += 1;

    $sql2 = "INSERT INTO auteur (id, nom, prenom) VALUES (" . $auteurId . ", " . $auteurNom . ", " . $auteurPrenom . ")";
    if ($db->query($sql2) === TRUE) {
        print_r("New author added successfully");
    } else {
        print_r("Error: " . $sql2 . "<br>" . $db->error);
    }

    $sql3 = "INSERT INTO siecle (id, numero) VALUES (" . $siecleId . ", " . $siecle . ")";
    if ($db->query($sql3) === TRUE) {
        print_r("New siecle added successfully");
    } else {
        print_r("Error: " . $sql3 . "<br>" . $db->error);
    }

    $sql = "INSERT INTO citation (id, phrase, auteurid, siecleid) VALUES (" . $nbr_citations . ", " . $citation . ", " . $auteurId . ", " . $siecleId . ")";
    if ($db->query($sql) === TRUE) {
        print_r( "New citation added successfully");
    } else {
        print_r("Error: " . $sql . "<br>" . $db->error);
    }
}

//Formulaire de Suppression
$citationId=$_POST['citationChoiceId'];

if($_POST['citationChoiceId'] != NULL) {
    $db->exec("DELETE FROM citation WHERE id=" . $citationId);
}