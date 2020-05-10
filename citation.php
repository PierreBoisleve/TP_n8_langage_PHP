<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Citation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">TP n°8 PHP</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="citation.php">Informations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="recherche.php">Recherche</a>
                </li>
                <li class="nav-item">
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
$db = connexpdo('pgsql:dbname=citations;host=localhost;port=5433','postgres','new_password');

$r=rand (1, 6);
$nbr_citations = 0;

echo '<div class="container col-sm-9 jumbotron" ><h1>La citation du jour</h1><hr>';

$query0 = "SELECT phrase FROM citation";
$nbr = $db->query($query0);
foreach ($nbr as $data) {
    $nbr_citations++;
}

echo '<p>Il y a <strong>'. $nbr_citations .' </strong> citations répertoriées.</p>';
echo "<p>Et voici l'une d'entre elles qui est générée aléatoirement : </p>";



//Citation de la BDD
$query1 = "SELECT phrase, auteurid, siecleid FROM citation WHERE id = ".$r;
$citation = $db->query($query1);
foreach ($citation as $data){
    echo '<p><strong>'.$data['phrase'].'</strong></p>';
    $auteurid = $data['auteurid'];
    $siecleid = $data['siecleid'];
}

//Auteur de la citation
$query2= "SELECT nom, prenom FROM auteur WHERE id =". $auteurid;
$auteur = $db->query($query2);
foreach ($auteur as $data){
    echo "<p><i>". $data['prenom'] ." ". $data['nom'] . "</i> ";
}

//Siècles de la BDD
$query3 = "SELECT numero FROM siecle WHERE id=".$siecleid;
$siecle = $db->query($query3);
foreach ($siecle as $data){
    echo $data['numero'] . "ème siècle </></p></div></body></html>";
}
