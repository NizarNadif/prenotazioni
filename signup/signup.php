<?php

include_once "../config.php";

// variabili valorizzate tramite POST
$username = $_POST['username'];
$password = $_POST['password'];
$psw_hashed = password_hash($password, PASSWORD_DEFAULT);

// query di inserimento preparata
$sql = "INSERT INTO utenti VALUES (NULL, '$username', '$psw_hashed')";

$pdo->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Prenotazione</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
registrazione avvenuta con successo
</div>
</body>
</html>