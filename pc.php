<?php
// Auteur: Dion Breur
// Functie: Tonen van PC producten

// Initialisatie
include_once 'functions.php';

// Get current user ID (use guest if not logged in)
$userId = isLoggedIn() ? getCurrentUserId() : null;

// Main
$products = getData("products", "*", ['console_id' => 2]);
$recommendedProducts = getRecommendedProducts(2);

// Controleer of er gefilterd of gezocht is
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Sorteren op prijs (Dropdown)
    if (isset($_POST['sortPrice'])) {
        $sortType = $_POST['sortPrice'];
        $products = sortProductsByPrice($products, $sortType);
    }

    // Zoeken op tekst (Input veld)
    if (!empty($_POST['search-inp'])) {
        $searchInp = $_POST['search-inp'];
        $products = searchProducts($searchInp, $products);
    }

    // Voeg product toe aan winkelmandje
    if (isset($_POST['addToCart'])) {
        if (!isLoggedIn()) {
            header("Location: login.php");
            exit();
        }
        if (!empty($_POST['product_id'])) {
            $id = $_POST['product_id'];
            addToCart($id, getCurrentUserId());
            echo "<script>alert('Product toegevoegd aan winkelmandje!');</script>";
            header("Location: pc.php?status=succes");
            exit();
        }
    }

    // Voeg product toe aan wishlist
    if (isset($_POST['addToWish'])) {
        if (!isLoggedIn()) {
            header("Location: login.php");
            exit();
        }
        if (!empty($_POST['product_id'])) {
            $id = $_POST['product_id'];
            addToWishlist($id, getCurrentUserId());
            echo "<script>alert('Product toegevoegd aan je verlanglijst!');</script>";
            header("Location: pc.php?status=succes");
            exit();
        }
    }

    // Verwijder product (admin only)
    if (isset($_POST['deletegame']) && !empty($_POST['product_id'])) {
        if (!isAdmin()) {
            header("Location: pc.php?status=error");
            exit();
        }
        $id = $_POST['product_id'];
        deleteProduct($id);
        echo "<script>alert('Product verwijderd!');</script>";
        header("Location: pc.php?status=deleted");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Producten</title>
    <link rel="shortcut icon" href="img/pc-picto.png" type="image/x-icon">
    <link rel="stylesheet" href="scss/main.css">
</head>
<body class="pc-page">
    <header>
        <img class="logo" src="img/Logo.png">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="playstation.php">Playstation</a></li>
                <li><a class="selected-page" href="#">PC</a></li>
                <li><a href="xbox.php">Xbox</a></li>
                <li><a href="nintendo.php">Nintendo</a></li>
            </ul>
        </nav>
        <div id="headerUserMenu" class="header-user-menu">
            <?php if (isLoggedIn()): ?>
                <!-- <span class="user-info">Welkom, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span> -->
                <a href="logout.php" class="btn-logout">Uitloggen</a>
            <?php else: ?>
                <a href="login.php">Inloggen</a>
                <a href="register.php">Registreren</a>
            <?php endif; ?>
        </div>
        <a href="winkelmandje.php"><img class="winkelmandje-img" src="img/Winkelmandje.png"></a>
    </header>

    <main>
            <form class="search-bar" action="" method="post">
                <input type="text" name="search-inp" placeholder="Typ hier je zoekterm..." value="<?php echo isset($_POST['search-inp']) ? htmlspecialchars($_POST['search-inp']) : ''; ?>">
                <section class="filter-wrapper">
                    <section class="filter-icon">
                        <span class="bar long"></span>
                        <span class="bar medium"></span>
                        <span class="bar short"></span>
                    </section>

                    <section class="filter-content">
                        <h4>Sorteren op:</h4>
                        <label for="sortPrice"><input type="radio" name="sortPrice" value="price_low"> Prijs: Laag - Hoog</label>
                        <label for="sortPrice"><input type="radio" name="sortPrice" value="price_high"> Prijs: Hoog - Laag</label>

                        <button type="submit">Toepassen</button>
                    </section>
                </section>
                <button type="submit" name="zoeken">Zoeken</button>
            </form>

        <?php
        showProducts($products);
        ?>
            <section style="margin-top: 60px; color: white;">
    <h2 class="recommended-h2">Aanbevolen PC games</h2>

    <?php if (!empty($recommendedProducts)): ?>
        <section class="product-container">
            <?php foreach ($recommendedProducts as $product): ?>
                <article class="game-card">
                    <img class="game-img" src="img/games/<?php echo htmlspecialchars($product['foto']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p>Prijs: €<?php echo number_format($product['price'], 2, ',', '.'); ?></p>
                </article>
            <?php endforeach; ?>
        </section>
    <?php else: ?>
        <p>Geen aanbevolen PC games gevonden.</p>
    <?php endif; ?>
    </section>
        

        <section id="gameModal" class="game-modal">
            <section class="modal-content">
                <span onclick="closeModal()">&times;</span>
                <img id=modalImg src="" alt="Game afbeelding">
                <h2 id="modalTitle"></h2>
                <p id="modalPrice"></p>
                <form class="add-to-wish-and-cart" action="" method="post">
                    <input type="hidden" name="product_id" id="modalProductId">
                    <button name="addToCart" type="submit" class="winkelmand-btn">
                        Voeg toe aan winkelmandje
                        <img src="img/Add-to-cart.png" alt="Winkelmandje">
                    </button>
                    <button name="addToWish" type="submit" class="wishlist-btn">
                        Voeg toe aan wishlist
                        <img src="img/Add_to_wishlist.png" alt="Wishlist">
                    </button>
                    <?php
                    if(isAdmin()) {
                        echo "
                            <button id='delGame' name='deletegame' type='submit' class='delete-btn'>
                                Verwijder game
                                <span>🗑️</span>
                            </button>
                        ";
                    }
                    ?>
                </form>
            </section>
        </section>
    </main>

    <footer>

    </footer>

    <script>
        function openModal(id, name, price, imgSrc){
            const modalImageElement = document.getElementById('modalImg');
            modalImageElement.src = imgSrc;
            modalImageElement.alt = "Afbeelding van " + name;

            document.getElementById('modalTitle').innerText = name;
            document.getElementById('modalPrice').innerText = "Prijs: €" + price;
            document.getElementById('modalProductId').value = id;
            document.getElementById('gameModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
            document.getElementById('headerUserMenu').style.display = 'none';
            if(document.getElementById('delGame')) {
                document.getElementById('delGame').style.display = 'block';
            }
        }
        function closeModal(){
            document.getElementById('gameModal').style.display = 'none';
            document.body.style.overflow = '';
            document.getElementById('headerUserMeny').style.display = 'block';
            document.getElementById('modalImg').src = "";
            if(document.getElementById('delGame')) {
                document.getElementById('delGame').style.display = 'none';
            }
        }
    </script>
</body>
</html>