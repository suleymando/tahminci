<?php
// index.php (Entry Point)
require_once 'app/core/Database.php';
require_once 'app/core/Controller.php';
require_once 'app/core/App.php';
require_once 'app/core/Language.php';

// Initialize Language Global
$language = new Language();

// Initialize App
$app = new App();
