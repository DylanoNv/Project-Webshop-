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

    // Handle checkout
    if (isset($_POST['checkout'])) {
        if (checkoutCart($userId)) {
            header("Location: afgerekend.php");
            exit();
        } else {
            header("Location: winkelmandje.php?status=checkout_empty");
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
    <link rel="stylesheet" href="scss/main.css?v=1">
</head>
<body class="cart-page">
    <?php renderTimeoutMessage(); ?>
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
            <h1>Mijn Winkelmandje</h1>

            <?php if (isset($_GET['status']) && $_GET['status'] === 'checkout_empty'): ?>
                <p>Winkelmand is leeg.</p>
            <?php endif; ?>
            
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
                                <form method="POST">
                                    <input type="hidden" name="cart-id" value="<?php echo $item['id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="100">
                                    <button type="submit" name="update-quantity" class="btn btn-update">Update</button>
                                </form>
                            </div>
                            <div class="cart-item-total">
                                €<?php echo number_format($item['price'] * $item['quantity'], 2, ',', '.'); ?>
                            </div>
                            <form method="POST">
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
                        <form method="POST">
                            <button type="submit" name="checkout" class="btn btn-checkout">Afrekenen</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>

    </footer>
</body>
</html>