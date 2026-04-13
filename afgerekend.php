<?php
// Dylano Nietveld
// Pagina na afrekenen

include_once 'functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelling geplaatst</title>
    <link rel="stylesheet" href="scss/main.css?v=2">
</head>
<body class="cart-page">
    <header>
        <img class="logo" src="img/Logo.png">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="playstation.php">Playstation</a></li>
                <li><a href="pc.php">PC</a></li>
                <li><a href="xbox.php">Xbox</a></li>
                <li><a href="nintendo.php">Nintendo</a></li>
            </ul>
        </nav>
        <div class="header-user-menu">
            <a href="logout.php" class="btn-logout">Uitloggen</a>
        </div>
        <a href="wishlist.php"><img class="wishlist-img" src="img/Add_to_wishlist.png" alt="Wishlist"></a>
        <a href="winkelmandje.php"><img class="winkelmandje-img" src="img/Winkelmandje.png" alt="Winkelmandje"></a>
    </header>

    <main>
        <div class="checkout-success-container">
            <h1>Bestelling geplaatst</h1>
            <p>Je bestelling is succesvol afgerond.</p>
            <a href="index.php" class="btn btn-continue">Terug naar winkel</a>
        </div>
    </main>
</body>
</html>