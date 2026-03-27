<?php
// Functie: Functies declareren

// Inititialisatie
include_once 'config.php';

// Main
function connectDb(){
    try{
        // Verbinding maken met de database
        $conn = new PDO("mysql:host=" . SERVERNAME . ";dbname=" . DATABASE, USERNAME, PASSWORD);

        // Errormode naar acceptatie
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Database verbinding teruggeven
        return $conn;
    } catch(PDOException $e) {
        // Foutmelding
        echo "Connection failed: " . $e->getMessage();
    }
}
?>