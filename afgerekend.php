// Dylano Nietveld
// Pagina na afrekenen

<?php
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
    <title>Bestelling geplaatst</title>
    <link rel="stylesheet" href="scss/main.css?v=1">
</head>
<body>
    <header>
        <img class="logo" src="img/Logo.png">
    </header>

    <main>
        <div class="cart-container">
            <h1>Bestelling geplaatst</h1>
            <p>Je bestelling is succesvol afgerond.</p>

            <a href="index.php" class="btn btn-continue">
                Terug naar shop
            </a>
        </div>
    </main>
</body>
</html>