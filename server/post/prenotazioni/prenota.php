<?php
include_once "../../config.php";

$response = array();
$response['status'] = 0;

$dati = file_get_contents("php://input");
$dati = json_decode($dati, true);

// variabili valorizzate tramite POST
$codice_fiscale = $dati['user'];
$data = $dati['day'];
$presidio = $dati['presidio']['presidio'];

$codice = strtoupper(uniqid());

// query di inserimento preparata
$sql = "INSERT INTO prenotazione (codice_fiscale, codice, data, id_presidio)
        VALUES (:codice_fiscale, :codice_prenotazione, :data, :id_presidio)";

// inviamo la query al database che la tiene pronta
$stmt = $pdo->prepare($sql);
// inviamo i dati concreti che verranno messi al posto dei segnaposto
$stmt->execute(
    [
        'codice_fiscale' => $codice_fiscale,
        'codice_prenotazione' => $codice,
        'data' => $data,
        'id_presidio'=>$presidio
    ]
);
//query per prendere la prenotazione
$sql_pren = 'SELECT prenotazione.id, prenotazione.codice_fiscale, prenotazione.data, prenotazione.codice,
        prenotazione.eseguito, prenotazione.note, prenotazione.annullato, presidio.nome AS nome_presidio,
        provincia.nome AS nome_provincia
        FROM prenotazione, presidio, provincia
        WHERE prenotazione.codice_fiscale = :codice_fiscale AND prenotazione.codice = :codice 
          AND prenotazione.id_presidio = presidio.id AND presidio.id_provincia = provincia.id';
$stmt = $pdo->prepare($sql_pren);

$stmt->execute([
    'codice_fiscale'=> $codice_fiscale,
    'codice'=>$codice
]);

$prenotazione = $stmt->fetch(PDO::FETCH_ASSOC);

if($prenotazione != null){
    $response['dati'] = $prenotazione;
    $response['status'] = 1;
}
//mando la risposta
echo json_encode($response);