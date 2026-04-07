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
        .cart-page {
            background-color: #f5f5f5;
            padding: 20px;
        }
        

        .header-user-menu {
            position: absolute;
            right: 100px;
            top: 15px;
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
            font-size: 14px;
            padding: 5px 10px;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .btn-logout {
            background-color: #dc3545;
            color: white !important;
            padding: 8px 15px !important;
            padding: 6px 12px !important;
        }
        
        .user-info {
            font-size: 14px;
            font-size: 12px;
            color: #666;
        }
        
        header {
            position: relative;
        }
        
        .cart-container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .cart-empty {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        .cart-empty a {
            color: #007bff;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
}
        
        .cart-item {
            display: grid;
            grid-template-columns: 100px 1fr 100px 100px 100px 80px;
            gap: 15px;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 15px;
        }
        
        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .cart-item-details h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        
        .cart-item-details p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 14px;
        }
        
        .cart-item-price {
            font-weight: bold;
            font-size: 16px;
            color: #007bff;
        }
        
        .cart-item-quantity input {
            width: 60px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
        }
        
        .cart-item-total {
            font-weight: bold;
            font-size: 16px;
            color: #333;
        }
        
        .cart-item-remove {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        
        .cart-item-remove:hover {
            background-color: #c82333;
        }
        
        .cart-summary {
            text-align: right;
            padding-top: 20px;
            border-top: 2px solid #ddd;
        }
        
        .cart-summary h2 {
            margin: 20px 0 30px 0;
            font-size: 24px;
            color: #333;
        }
        
        .cart-actions {
            gap: 10px;
            justify-content: flex-end;
        }
        
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-continue {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-continue:hover {
            background-color: #5a6268;
        }
        
        .btn-checkout {
            background-color: #28a745;
            color: white;
        }
        
        .btn-checkout:hover {
            background-color: #218838;
        }
        
        .cart-header {
            display: none;
        }
        
        
            .cart-header {
                display: grid;
                grid-template-columns: 100px 1fr 100px 100px 100px 80px;
                gap: 15px;
                padding: 15px;
                border-bottom: 2px solid #333;
                margin-bottom: 15px;
                font-weight: bold;
                color: #333;
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