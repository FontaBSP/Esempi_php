<?php

require 'config.php';


echo "<h2>Messaggi</h2>";
echo"<ul>";
foreach(mostra_messaggi() as $message) {
    echo "<li>".$message."</li>";
}

echo "</ul>";

function mostra_messaggi() {
    try {
        /* Connetto al db, se funziona crea variabile $conn e apre
           istanza di PDO (classe), creando stringa con dati per il collegamento
           alle variabili in superglobale */
        $conn = new PDO("mysql:host=".$GLOBALS['dbhost'].";dbname=".$GLOBALS['dbname'], $GLOBALS['dbuser'], $GLOBALS['dbpassword']);
        /* Il metodo set_attribute stamperà un eventiuale errore */
        $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        /* La Query */
        $stmt = $conn->prepare("SELECT messaggio FROM messaggi_utenti");
        /* Lancio la query (anti SQL injection) */
        $stmt->execute([]);
        /* Creo array vuoto da riempire poi con risultati query */
        $array = array();
        /* Riempio l'array in modo da scorrere i risultati della query,
           il parametro "PDO::FETCH_ASSOCH" della funzione "fetch"
           farà in modo che non compaia solo la prima riga ma tutte,
           è indispensabile per l'utilizzo del while. */
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            /* Inserisco tutti i 'name' nell'array */
            array_push($array,$row['messaggio']);
        }
        /* Stampo il risultato */
        return $array;
        /* Stampo l'errore in caso di esito negativo */
    }catch(PDOexception $e) {
    echo $e->getMessage();
    return array();
    }
}

