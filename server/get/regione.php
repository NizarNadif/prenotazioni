<?php

include_once '../config.php';

//prende il nome della regione dal vettore get
$nome_regione = $_GET['regione'];

$sql = 'SELECT regione.nome FROM regione';

//preparo la query
$stmt = $pdo -> prepare($sql);

//eseguo la query
$stmt->execute([
    'nome_regione'=>$nome_regione
]);

echo json_encode($stmt->fetch());