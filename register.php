<?php
// Functie: Registratie pagina

// Initialisatie
session_start();
include_once 'functions.php';

// Controleer of gebruiker al ingelogd is
if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

$error = '';
$success = '';

// Handle registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $password_confirm = trim($_POST['password_confirm'] ?? '');
    
    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
        $error = 'Voer alstublieft alle velden in';
    } elseif (strlen($username) < 3) {
        $error = 'Gebruikersnaam moet minstens 3 tekens lang zijn';
    } elseif (strlen($password) < 6) {
        $error = 'Wachtwoord moet minstens 6 tekens lang zijn';
    } elseif ($password !== $password_confirm) {
        $error = 'Wachtwoord en bevestiging komen niet overeen';
    } else {
        $result = registerUser($username, $email, $password);
        if ($result['success']) {
            $success = $result['message'] . ' Je kunt nu inloggen.';
            // Optioneel: automatisch inloggen
            // header("Location: login.php");
        } else {
            $error = $result['message'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren - Webshop</title>
    <link rel="shortcut icon" href="img/homepage-picto.png" type="image/x-icon">
    <link rel="stylesheet" href="scss/main.css">
</head>
<body class="auth-page">
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
        <a href="winkelmandje.php"><img class="winkelmandje-img" src="img/Winkelmandje.png"></a>
    </header>

    <main>
        <div class="auth-container">
            <h1>Registreren</h1>
            
            <?php if (!empty($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="username">Gebruikersnaam</label>
                    <input type="text" id="username" name="username" minlength="3" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email adres</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Wachtwoord</label>
                    <input type="password" id="password" name="password" minlength="6" required>
                </div>
                
                <div class="form-group">
                    <label for="password_confirm">Wachtwoord bevestigen</label>
                    <input type="password" id="password_confirm" name="password_confirm" minlength="6" required>
                </div>
                
                <button type="submit" name="register" class="btn-register">Registreren</button>
            </form>
            
            <div class="login-link">
                Al een account? <a href="login.php">Inloggen</a>
            </div>
        </div>
    </main>

    <footer>

    </footer>
</body>
</html>
