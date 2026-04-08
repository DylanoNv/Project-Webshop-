// Dylano Nietveld
// Review aanpassen

<?php
include_once 'functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$userId = getCurrentUserId();
$reviewId = $_GET['id'] ?? 0;
$reviewData = getReviewById($reviewId, $userId);

if (!$reviewData) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review = trim($_POST['review'] ?? '');
    $rating = (int)($_POST['rating'] ?? 0);

    if ($review !== '' && $rating >= 1 && $rating <= 5) {
        updateReview($reviewId, $userId, $review, $rating);
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review aanpassen</title>
    <link rel="stylesheet" href="scss/main.css">
</head>
<body>
    <main style="padding: 40px;">
        <h1>Review aanpassen</h1>

        <form method="post">
            <p>
                <label>Rating (1 t/m 5)</label><br>
                <input type="number" name="rating" min="1" max="5" value="<?php echo htmlspecialchars($reviewData['rating']); ?>">
            </p>

            <p>
                <label>Review</label><br>
                <textarea name="review" rows="6" cols="50"><?php echo htmlspecialchars($reviewData['review']); ?></textarea>
            </p>

            <button type="submit">Opslaan</button>
            <a href="index.php">Terug</a>
        </form>
    </main>
</body>
</html>