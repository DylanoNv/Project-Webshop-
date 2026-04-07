<?php
// Auteur: Dion Breur
// Functie: Tonen van winkelmandje

// Initialisatie
include_once 'functions.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Get current user ID
$userId = getCurrentUserId();

// Handle delete item
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove-item'])) {
        $cartId = isset($_POST['cart-id']) ? intval($_POST['cart-id']) : 0;
        if ($cartId > 0) {
            removeFromCart($cartId);
            header("Location: winkelmandje.php?status=removed");
            exit();
        }
    }
    
    // Handle quantity update
    if (isset($_POST['update-quantity'])) {
        $cartId = isset($_POST['cart-id']) ? intval($_POST['cart-id']) : 0;
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
        if ($cartId > 0 && $quantity > 0) {
            updateCartQuantity($cartId, $quantity);
            header("Location: winkelmandje.php?status=updated");
            exit();
        }
    }
}

// Get cart items
$cartItems = getCartItems($userId);
$cartTotal = getCartTotal($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelmandje</title>
    <link rel="shortcut icon" href="img/homepage-picto.png" type="image/x-icon">
    <link rel="stylesheet" href="scss/main.css">
        <style>
        .header-user-menu {
            position: absolute;
            right: 20px;
            top: 8px;
            display: flex;
            gap: 15px;
            align-items: center;
            z-index: 2;
        }
        
        .header-user-menu a {
            color: #333;
            text-decoration: none;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .header-user-menu a:hover {
            background-color: #f0f0f0;
        }
        
        .btn-logout {
            background-color: #dc3545;
            color: white !important;
            padding: 6px 12px !important;
        }
        
        .btn-logout:hover {
            background-color: #c82333 !important;
        }
        
        .user-info {
            font-size: 12px;
            color: #666;
        }
        
        header {
            position: relative;
        }

        .winkelmandje-img {
            display: block;
            margin-top: 40px;
        }
    </style>
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
        <a href="winkelmandje.php"><img class="winkelmandje-img" src="img/Winkelmandje.png"></a>
    </header>

    <main>
        <div class="cart-container">
            <h1>Mijn Winkelmandje</h1>
            
            <?php if (empty($cartItems)): ?>
                <div class="cart-empty">
                    <h2>Je winkelmandje is leeg</h2>
                    <p>Voeg producten toe door op de productpagina's te bladeren.</p>
                    <a href="index.php" class="btn btn-continue">Terug naar winkelen</a>
                </div>
            <?php else: ?>
                <div class="cart-items">
                    <div class="cart-header">
                        <div>Afbeelding</div>
                        <div>Product</div>
                        <div>Prijs</div>
                        <div>Aantal</div>
                        <div>Totaal</div>
                        <div>Actie</div>
                    </div>
                    
                    <?php foreach ($cartItems as $item): ?>
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
                            <div class="cart-item-quantity">
                                <form method="POST" style="display: flex; gap: 5px;">
                                    <input type="hidden" name="cart-id" value="<?php echo $item['id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="100" style="width: 50px;">
                                    <button type="submit" name="update-quantity" class="btn" style="padding: 4px 8px; background-color: #007bff; color: white;">Update</button>
                                </form>
                            </div>
                            <div class="cart-item-total">
                                €<?php echo number_format($item['price'] * $item['quantity'], 2, ',', '.'); ?>
                            </div>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="cart-id" value="<?php echo $item['id']; ?>">
                                <button type="submit" name="remove-item" class="cart-item-remove">Verwijderen</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="cart-summary">
                    <h2>Totaal: €<?php echo number_format($cartTotal, 2, ',', '.'); ?></h2>
                    <div class="cart-actions">
                        <a href="index.php" class="btn btn-continue">Doorgaan met winkelen</a>
                        <button class="btn btn-checkout" onclick="alert('Checkout functionaliteit komt binnenkort!')">Afrekenen</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>

    </footer>
</body>
</html>


