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
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_review']) && isLoggedIn()) {
        $review = trim($_POST['review'] ?? '');
        $rating = (int)($_POST['rating'] ?? 0);

        if ($review !== '' && $rating >= 1 && $rating <= 5) {
            addReview(getCurrentUserId(), $review, $rating);
            header("Location: index.php");
            exit();
        }
    }

    if (isset($_POST['delete_review']) && isLoggedIn()) {
        $reviewId = $_POST['review_id'] ?? 0;
        deleteReview($reviewId, getCurrentUserId());
        header("Location: index.php");
        exit();
    }
}

$reviews = getReviews();
?>

<section style="max-width: 1100px; margin: 60px auto; display: flex; gap: 60px; align-items: flex-start; color: white;">
    
    <section style="flex: 1; background: #1d254a; padding: 25px; border-radius: 10px;">
        <h2 style="margin-top: 0;">Laat een review achter</h2>

        <?php if (isLoggedIn()): ?>
            <form method="post">
                <p>
                    <label>Rating (1 t/m 5)</label><br>
                    <input type="number" name="rating" min="1" max="5" required
                        style="width: 100%; max-width: 120px; padding: 10px; margin-top: 8px;">
                </p>

                <p>
                    <label>Review</label><br>
                    <textarea name="review" rows="6" placeholder="Schrijf hier je review..." required
                        style="width: 100%; padding: 10px; margin-top: 8px; resize: none;"></textarea>
                </p>

                <button type="submit" name="add_review"
                    style="padding: 10px 20px; background: #8a2be2; color: white; border: none; border-radius: 6px; cursor: pointer;">
                    Verstuur
                </button>
            </form>
        <?php else: ?>
            <p>Log in om een review te plaatsen.</p>
        <?php endif; ?>
    </section>

    <section style="width: 380px; background: #1d254a; padding: 25px; border-radius: 10px;">
        <h2 style="margin-top: 0;">Recente reviews</h2>

        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div style="background: #2a3261; padding: 15px; margin-bottom: 15px; border-radius: 8px;">
                    <strong><?php echo htmlspecialchars($review['username']); ?></strong><br>
                    <small>Rating: <?php echo $review['rating']; ?>/5</small>
                    <p style="margin: 10px 0;"><?php echo nl2br(htmlspecialchars($review['review'])); ?></p>

                    <?php if (isLoggedIn() && getCurrentUserId() == $review['user_id']): ?>
                        <a href="review_edit.php?id=<?php echo $review['id']; ?>" style="color: #caa6ff;">Wijzig</a>

                        <form method="post" style="display:inline;">
                            <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                            <button type="submit" name="delete_review"
                                style="background:none; border:none; color:#ff9db0; cursor:pointer;">
                                Verwijder
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nog geen reviews geplaatst.</p>
        <?php endif; ?>
    </section>

</section>
    </main>

    <footer>

    </footer>
</body>
</html>