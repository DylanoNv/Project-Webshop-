<?php
// Functie: Functies declareren

// Inititialisatie
// Session starten
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

// Zorg dat default user bestaat
function ensureDefaultUserExists($userId = 1) {
    $conn = connectDb();
    
    // Check of user bestaat
    $sql = "SELECT id FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
    
    if (!$user) {
        // Voeg standaard user toe
        $sql = "INSERT INTO users (id, username, email, password, is_admin) VALUES (?, 'gast', 'gast@webshop.nl', '1234', 0)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$userId]);
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
    // Controleren of er data is gevonden
    if (empty($data)) {
        echo "<p>Geen producten gevonden voor deze console.</p>";
        return;
    }

    // Als er data is gevonden dan wordt dat getoont
    echo "<section class='product-container'>";
    foreach ($data as $product) {
        // HIER GEBEURT HET: We voegen het pad naar de foto toe als 3e parameter
        $fotoPad = "img/games/" . htmlspecialchars($product['foto']);
        
        echo "<article class='game-card' onclick=\"openModal('" . htmlspecialchars($product['id']) . "', '" . htmlspecialchars($product['name']) . "', '" . $product['price'] . "', '" . $fotoPad . "')\">";
        
        echo "<img class='game-img' src='" . $fotoPad . "'>";
        echo "<h3>" . htmlspecialchars($product['name']) . "</h3>";
        echo "<p>Prijs: €" . number_format($product['price'], 2, ',', '.') . "</p>";
        echo "</article>";
    }
    echo "</section>";
}

// Producten zoeken
function searchProducts($searchInp, $data){
    // Als er geen data is wordt er niet gezocht
    if(empty($data) || empty($searchInp)){
        return $data;
    }

    $filteredData = [];
    foreach ($data as $product) {
        if(str_contains(strtolower($product['name']), strtolower($searchInp))){
            $filteredData[] = $product;
        }
    }
    return $filteredData;
}

// Producten filteren op prijs
function sortProductsByPrice($data, $type) {
    if (empty($data)) return $data;

    // Sorteren
    usort($data, function($a, $b) use ($type) {
        if ($type === 'price_low') {
            // Van laag naar hoog
            return $a['price'] <=> $b['price'];
        } else {
            // Van hoog naar laag
            return $b['price'] <=> $a['price'];
        }
    });

    return $data;
}

// Product toevoegen aan winkelmandje
function addToCart($productId, $userId = 1) { // Default user_id op 1 voor nu
    // Zorg dat user bestaat
    ensureDefaultUserExists($userId);
    
    $conn = connectDb();

    // Check of het product al in de mand staat voor deze gebruiker
    $sqlCheck = "SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->execute([$userId, $productId]);
    $item = $stmtCheck->fetch();

    if ($item) {
        // Als het al bestaat: quantity verhogen
        $sql = "UPDATE cart SET quantity = quantity + 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt = $stmt->execute([$item['id']]);
    } else {
        // Als het nieuw is: toevoegen
        $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$userId, $productId]);
    }
}

// Product toevoegen aan wishlist
function addToWishlist($productId, $userId = 1) {
    // Zorg dat user bestaat
    ensureDefaultUserExists($userId);
    
    $conn = connectDb();

    // Check of het product al op de wishlist staat voor deze gebruiker
    $sqlCheck = "SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->execute([$userId, $productId]);
    $exists = $stmtCheck->fetch();

    // Alleen toevoegen als het nog niet bestaat
    if (!$exists) {
        $sql = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$userId, $productId]);
        return true;
    }
    return false;
}

// Get cart items with product details
function getCartItems($userId = 1) {
    $conn = connectDb();
    
    $sql = "SELECT c.id, c.product_id, c.quantity, p.name, p.price, p.foto 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = ?
            ORDER BY c.id DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userId]);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Remove item from cart
function removeFromCart($cartId) {
    $conn = connectDb();
    
    $sql = "DELETE FROM cart WHERE id = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$cartId]);
}

// Update cart quantity
function updateCartQuantity($cartId, $quantity) {
    $conn = connectDb();
    
    if ($quantity <= 0) {
        return removeFromCart($cartId);
    }
    
    $sql = "UPDATE cart SET quantity = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$quantity, $cartId]);
}

// Clear entire cart
function clearCart($userId = 1) {
    $conn = connectDb();
    
    $sql = "DELETE FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$userId]);
}

// Get cart total
function getCartTotal($userId = 1) {
    $conn = connectDb();
    
    $sql = "SELECT SUM(p.price * c.quantity) as total 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userId]);
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}
?>