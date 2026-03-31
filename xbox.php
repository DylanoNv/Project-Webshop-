<?php
// Auteur: Dion Breur
// Functie: Tonen van Xbox producten

// Initialisatie
include_once 'functions.php';

// Main
$games = getData(GAMETABLE, "*", ['categorie_id' => 3]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xbox Producten</title>
    <link rel="stylesheet" href="Xbox/scss/main.css">
</head>
<body class="xbox-page">
    <header>
        <img class="logo" src="img/Logo.png">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="playstation.php">Playstation</a></li>
                <li><a href="pc.php">PC</a></li>
                <li><a class="selected-page" href="#">Xbox</a></li>
                <li><a href="nintendo.php">Nintendo</a></li>
            </ul>
        </nav>
        <img class="winkelmandje-img" src="img/Winkelmandje.png">
    </header>

    <main>
        <?php
        showProducts($games);
        ?>
    </main>

    <footer>

    </footer>
</body>
</html>