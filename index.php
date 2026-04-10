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
    <?php renderTimeoutMessage(); ?>
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

<section class="review-section">
    
    <section class="review-form">
        <h2 class="review-title">Laat een review achter</h2>

        <?php if (isLoggedIn()): ?>
            <form method="post">
                <p>
                    <label>Rating (1 t/m 5)</label><br>
                    <input type="number" name="rating" min="1" max="5" required class="rating-input">
                </p>

                <p>
                    <label>Review</label><br>
                    <textarea name="review" rows="6" placeholder="Schrijf hier je review..." required class="review-textarea"></textarea>
                </p>

                <button type="submit" name="add_review" class="submit-btn">
                    Verstuur
                </button>
            </form>
        <?php else: ?>
            <p>Log in om een review te plaatsen.</p>
        <?php endif; ?>
    </section>

    <section class="recent-reviews">
        <h2 class="review-title">Recente reviews</h2>

        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review-item">
                    <strong><?php echo htmlspecialchars($review['username']); ?></strong><br>
                    <small>Rating: <?php echo $review['rating']; ?>/5</small>
                    <p class="review-comment"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>

                    <?php if (isLoggedIn() && getCurrentUserId() == $review['user_id']): ?>
                        <a href="review_edit.php?id=<?php echo $review['id']; ?>" class="edit-link">Wijzig</a>

                        <form method="post" class="inline-form">
                            <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                            <button type="submit" name="delete_review" class="delete-btn">
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
