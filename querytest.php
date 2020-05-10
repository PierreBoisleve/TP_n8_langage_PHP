<?php
include 'connexpdo.php';

//Connect BDD
$db = connexpdo('pgsql:dbname=citations;host=localhost;port=5433','postgres','new_password');

echo  '<html>
<h1>TP_n°8_langage_PHP</h1>
<hr>
<h2></h2>';

//Auteurs de la BDD
$query1 = "SELECT nom, prenom FROM auteur";
$result1 = $db->query($query1);

echo '<h1>Auteurs de la BD</h1><hr>';
echo '<table>';
echo "<tr><td>Nom</td><td>Prénom</td></tr>";
foreach ($result1 as $data){
    echo "<tr><td>".$data['nom']."</td><td>".$data['prenom']."</td></tr>";
}
echo '</table>';

//Citations de la BDD
$query2 = "SELECT phrase FROM citation";
$result2 = $db->query($query2);

echo '<h1>Citations de la BD</h1><hr>';

foreach ($result2 as $data){
    echo $data['phrase'].'<br>';
}

//Siècles de la BDD
$query3 = "SELECT numero FROM siecle";
$result3 = $db->query($query3);

echo '<h1>Siecles de la BD</h1><hr>';

foreach ($result3 as $data){
    echo $data['numero'].'<br>';
}