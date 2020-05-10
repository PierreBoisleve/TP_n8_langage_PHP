<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">TP n°8 PHP</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="citation.php">Informations</a>
                </li>
                <li class="nav-item active">
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
include 'connexpdo.php';

//Connect BDD
$db = connexpdo('pgsql:dbname=citations;host=localhost;port=5433','postgres','new_password');

$i=1;

echo '<div class="container col-sm-9 jumbotron" ><h1>Rechercher une citation</h1><hr>
        <form method="POST" action="recherche.php">
          <div class="form-group">
            <label>Auteur</label>
            <select class="form-control" name="auteur">';
$query1 = "SELECT nom, prenom, id FROM auteur";
$auteur = $db->query($query1);
foreach ($auteur as $data){
    echo "<option value=".$data['id'].">".$data['prenom']." ".$data['nom']."</option>";
    $i++;
}
echo '</select>';
echo'</div>';
echo '<div class="form-group">
            <label>Siècle</label>
            <select class="form-control" name="siecle">';
$query2 = "SELECT numero, id FROM siecle";
$siecle = $db->query($query2);
foreach ($siecle as $data){
    echo "<option value=".$data['id'].">".$data['numero']."</option>";
}
echo '</select>';
echo'</div>';
echo '<button type="submit" class="btn btn-primary">Rechercher</button>
        </form>';
$j=0;
echo'<br>';
echo'<table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Citation</th>
                <th scope="col">Auteur</th>
                <th scope="col">Siècle</th>
            </tr>
        </thead>
        <tbody>';


$nbr_citations=0;
$query0 = "SELECT phrase FROM citation WHERE auteurid =".$_POST['auteur']. " AND siecleid = ".$_POST['siecle'];
$nbr = $db->query($query0);

foreach ($nbr as $data) {
    $nbr_citations++;
}

if($nbr_citations>=1) {
    $query1 = "SELECT phrase FROM citation WHERE auteurid =" . $_POST['auteur'] . " AND siecleid = " . $_POST['siecle'];
    $sth = $db->prepare($query1);
    $sth->execute();
    $result=$sth->fetchAll();

    for ($k = 0; $k < $nbr_citations; $k++) {
        $index=$k+1;
        echo '<tr>';
        echo '<th scope="row">'.$index.'</th>';
        echo '<td>' . $result[$k]['phrase'] . '</td>';

        $query2 = "SELECT nom, prenom FROM auteur WHERE id =" . $_POST['auteur'];
        $auteur2 = $db->query($query2);
        foreach ($auteur2 as $data) {
            echo '<td>' . $data['prenom'] . " " . $data['nom'] . '</td>';
        }

        $query3 = "SELECT numero FROM siecle WHERE id =" . $_POST['siecle'];
        $siecle2 = $db->query($query3);
        foreach ($siecle2 as $data) {
            echo '<td>' . $data['numero'] . '</td>';
        }
        echo '</tr>';
    }
}
else {
    echo "Cet auteur n'a pas fait de citations durant ce siècle. <br><br>";
}
echo'</tbody>
</table>';