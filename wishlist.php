<?php
// Auteur: Sven Boender
// Functie: Tonen van wishlist

// Initialisatie
include_once 'functions.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Get current user ID
$userId = getCurrentUserId();

// Handle remove item from wishlist
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove-item'])) {
        $wishlistId = isset($_POST['wishlist-id']) ? intval($_POST['wishlist-id']) : 0;
        if ($wishlistId > 0) {
            removeFromWishlist($wishlistId);
            header("Location: wishlist.php?status=removed");
            exit();
        }
    }
}

// Get wishlist items
$wishlistItems = getWishlistItems($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link rel="shortcut icon" href="img/homepage-picto.png" type="image/x-icon">
    <link rel="stylesheet" href="scss/main.css?v=1">
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
            <!-- <span class="user-info">Welkom, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span> -->
            <a href="logout.php" class="btn-logout">Uitloggen</a>
        </div>
        <a href="wishlist.php"><img class="wishlist-img" src="img/Add_to_wishlist.png" alt="Wishlist"></a>
        <a href="winkelmandje.php"><img class="winkelmandje-img" src="img/Winkelmandje.png"></a>
    </header>

    <main>
        <div class="cart-container">
            <h1>Mijn Wishlist</h1>
            
            <?php if (empty($wishlistItems)): ?>
                <div class="cart-empty">
                    <h2>Je wishlist is leeg</h2>
                    <p>Voeg producten toe door op de productpagina's te bladeren.</p>
                    <a href="index.php" class="btn btn-continue">Terug naar winkelen</a>
                </div>
            <?php else: ?>
                <div class="cart-items">
                    <div class="cart-header">
                        <div>Afbeelding</div>
                        <div>Product</div>
                        <div>Prijs</div>
                        <div>Actie</div>
                    </div>
                    
                    <?php foreach ($wishlistItems as $item): ?>
                        <div class="cart-item">
                            <div>
                                <img src="img/games/<?php echo htmlspecialchars($item['foto']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                            </div>
                            <div class="cart-item-details">
                                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                                <p>Product ID: <?php echo $item['product_id']; ?></p>
                            </div>
                            <div class="cart-item-price">
                                €<?php echo number_format($item['price'], 2, ',', '.'); ?>
                            </div>
                            <form method="POST">
                                <input type="hidden" name="wishlist-id" value="<?php echo $item['id']; ?>">
                                <button type="submit" name="remove-item" class="cart-item-remove">Verwijderen</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="cart-summary">
                    <div class="cart-actions">
                        <a href="index.php" class="btn btn-continue">Doorgaan met winkelen</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>

    </footer>
</body>
</html>