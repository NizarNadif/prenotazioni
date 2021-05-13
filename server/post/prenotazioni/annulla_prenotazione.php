<?php

include_once "../../config.php";

$response = array();
$response['status'] = 0;

$dati = file_get_contents("php://input");
$dati = json_decode($dati, true);

// variabili valorizzate tramite POST
$codice_prenotazione = $dati['codice_prenotazione'];

$sql = 'UPDATE prenotazione 
        SET prenotazione.annullato = true
        WHERE prenotazione.codice = :codice';

$stmt = $pdo->prepare($sql);
$stmt->execute(['codice'=>$codice_prenotazione]);

$sql = 'SELECT * FROM prenotazione WHERE codice = :codice AND prenotazione.annullato = true';
$pren = $pdo->prepare($sql);
$pren->execute(['codice'=>$codice_prenotazione]);

if($pren->fetch() != null){
    $response['status'] = 1;
}

echo json_encode($response);
// ridirige il browser verso la pagina indicata nella location
//header('Location:./prenotazioni/index.php');