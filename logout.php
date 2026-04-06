<?php
// Functie: Logout pagina

// Initialisatie
include_once 'functions.php';

// Logout
logoutUser();

// Redirect to home
header("Location: index.php");
exit();
