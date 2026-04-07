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
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        
        header {
            background-color: white;
            padding: 20px 0;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
            gap: 40px;
        }
        
        header img.logo {
            width: 80px;
            margin-left: 20px;
        }
        
        nav ul {
            display: flex;
            list-style: none;
            gap: 20px;
            margin: 0;
            padding: 0;
        }
        
        nav a {
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }
        
        nav a:hover {
            color: #007bff;
        }
        
        header .winkelmandje-img {
            width: 30px;
            margin-left: auto;
            margin-right: 20px;
            cursor: pointer;
        }
        
        main {
            min-height: calc(100vh - 300px);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        footer {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            margin-top: 40px;
        }
        
        .auth-container {
            max-width: 400px;
            margin: 50px auto;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .auth-container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #28a745;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.3);
        }
        
        .btn-register {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-register:hover {
            background-color: #218838;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .login-link a {
            color: #28a745;
            text-decoration: none;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <img class="logo" src="img/Logo.png">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="playstation.php">Playstation</a></li>
                <li><a href="pc.php">PC</a></li>
                <li><a href="xbox.php">Xbox</a></li>
                <li><a href="nintendo.php">Nintendo</a></li>
                <li><a href="winkelmandje.php">Winkelmandje</a></li>
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
