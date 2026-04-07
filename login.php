<?php
// Functie: Login pagina

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

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        
        if (empty($username) || empty($password)) {
            $error = 'Voer alstublieft gebruikersnaam en wachtwoord in';
        } else {
            $result = loginUser($username, $password);
            if ($result['success']) {
                header("Location: index.php");
                exit();
            } else {
                $error = $result['message'];
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen - Webshop</title>
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
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }
        
        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-login:hover {
            background-color: #0056b3;
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
        
        .register-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .register-link a {
            color: #007bff;
            text-decoration: none;
        }
        
        .register-link a:hover {
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
            </ul>
        </nav>
        <a href="winkelmandje.php"><img class="winkelmandje-img" src="img/Winkelmandje.png"></a>
    </header>

    <main>
        <div class="auth-container">
            <h1>Inloggen</h1>
            
            <?php if (!empty($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="username">Gebruikersnaam</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Wachtwoord</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" name="login" class="btn-login">Inloggen</button>
            </form>
            
            <div class="register-link">
                Nog geen account? <a href="register.php">Registreren</a>
            </div>
        </div>
    </main>

    <footer>

    </footer>
</body>
</html>
