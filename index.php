<?php
// Functie: Homepage voor de webshop

// Initialisatie
include_once 'functions.php';

// Main
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="shortcut icon" href="img/homepage-picto.png" type="image/x-icon">
    <link rel="stylesheet" href="scss/main.css">
    <style>
        .header-user-menu {
            position: absolute;
            right: 100px;
            top: 15px;
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .header-user-menu a {
            color: #333;
            text-decoration: none;
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .header-user-menu a:hover {
            background-color: #f0f0f0;
        }
        
        .btn-logout {
            background-color: #dc3545;
            color: white !important;
            padding: 8px 15px !important;
        }
        
        .btn-logout:hover {
            background-color: #c82333 !important;
        }
        
        .user-info {
            font-size: 14px;
            color: #666;
        }
        
        header {
            position: relative;
        }
    </style>
</head>
<body class="home-page">
    <header>
        <img class="logo" src="img/Logo.png">
        <nav>
            <ul>
                <li><a class="selected-page" href="#">Home</a></li>
                <li><a href="playstation.php">Playstation</a></li>
                <li><a href="pc.php">PC</a></li>
                <li><a href="xbox.php">Xbox</a></li>
                <li><a href="nintendo.php">Nintendo</a></li>
            </ul>
        </nav>
        <div class="header-user-menu">
            <?php if (isLoggedIn()): ?>
                <span class="user-info">Welkom, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
                <a href="logout.php" class="btn-logout">Uitloggen</a>
            <?php else: ?>
                <a href="login.php">Inloggen</a>
                <a href="register.php">Registreren</a>
            <?php endif; ?>
        </div>
        <a href="winkelmandje.php"><img class="winkelmandje-img" src="img/Winkelmandje.png"></a>
    </header>

    <main>

    </main>

    <footer>

    </footer>
</body>
</html>