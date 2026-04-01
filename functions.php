<?php
// Functie: Functies declareren

// Inititialisatie
// Koppelen van configuratiebestand
include_once 'config.php';

// Main
// Verbinden met database
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

// Ophalen van data
function getData($table, $selection = "*", $conditions = [], $orderBy = null) {
    // Verbinding maken met database
    $conn = connectDb();

    // SQL-Query opstellen
    $sql = "SELECT $selection FROM `$table`";

    // Parameters
    $params = [];

    // Where conditie toevoegen
    if(!empty($conditions)){
        $sql .= " WHERE ";
        $whereParts = [];
        foreach($conditions as $column => $value){
            $whereParts[] = "`$column` = ?";
            $params[] = $value;
        }
        $sql .= implode(" AND ", $whereParts);
    }

    // Order by toevoegen aan SQL-Querie
    if($orderBy){
        $sql .= " ORDER BY " . $orderBy;
    }

    // SQL-Querie verzenden naar database server
    $stmt = $conn->prepare($sql);

    // SQL-Querie uitvoeren
    $stmt->execute($params);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Resultaten teruggeven
    return $data;
}

// Producten laten zien
function showProducts($data) {
    if (empty($data)) {
        echo "<p>Geen producten gevonden voor deze console.</p>";
        return;
    }

    echo "<section class='product-container'>";
    foreach ($data as $game) {
        echo "<article class='game-card' onclick=\"openModal('" . htmlspecialchars($game['name']) . "', '" . $game['price'] . "')\">";
        echo "<img class='game-img' src='img/games/" . htmlspecialchars($game['foto']) . "'>";
        echo "<h3>" . htmlspecialchars($game['name']) . "</h3>";
        echo "<p>Prijs: €" . number_format($game['price'], 2, ',', '.') . "</p>";
        echo "</article>";
    }
    echo "</section>";
}
?>