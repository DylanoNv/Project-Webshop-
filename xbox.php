<?php
// Auteur: Dion Breur
// Functie: Tonen van Xbox producten

// Initialisatie
include_once 'functions.php';

// Main
$products = getData("products", "*", ['console_id' => 3]);

if(isset($_POST['']))
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xbox Producten</title>
    <link rel="stylesheet" href="scss/main.css">
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
            <form class="search-bar" action="" method="post">
                <input type="text" name="search-inp">
                <section class="filter-wrapper">
                    <section class="filter-icon">
                        <span class="bar long"></span>
                        <span class="bar medium"></span>
                        <span class="bar short"></span>
                    </section>
                </section>
                <button type="submit">Zoeken</button>
            </form>

        <?php
        showProducts($products);
        ?>

        <section id="gameModal" class="game-modal">
            <section class="modal-content">
                <span onclick="closeModal()">&times;</span>
                <img id=modalImg src="" alt="Game afbeelding">
                <h2 id="modalTitle"></h2>
                <p id="modalPrice"></p>
                <button class="winkelmand-btn">
                    Voeg toe aan winkelmandje
                    <img src="img/Add-to-cart.png" alt="Winkelmandje">
                </button>
                <button class="wishlist-btn">
                    Voeg toe aan wishlist
                    <img src="img/Add_to_wishlist.png" alt="Wishlist">
                </button>
            </section>
        </section>
    </main>

    <footer>

    </footer>

    <script>
        function openModal(name, price, imgSrc){
            const modalImageElement = document.getElementById('modalImg');
            modalImageElement.src = imgSrc;
            modalImageElement.alt = "Afbeelding van " + name;

            document.getElementById('modalTitle').innerText = name;
            document.getElementById('modalPrice').innerText = "Prijs: €" + price;
            document.getElementById('gameModal').style.display = 'block';
        }
        function closeModal(){
            document.getElementById('gameModal').style.display = 'none';
            document.getElementById('modalImg').src = "";
        }
    </script>
</body>
</html>