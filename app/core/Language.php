<?php
// app/core/Language.php

class Language {
    private $lang;
    private $translations = [];

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Default language
        if (!isset($_SESSION['lang'])) {
            $_SESSION['lang'] = 'tr';
        }

        // Handle switch request
        if (isset($_GET['lang'])) {
            $_SESSION['lang'] = $_GET['lang'];
        }

        $this->lang = $_SESSION['lang'];
        $this->loadTranslations();
    }

    private function loadTranslations() {
        $file = __DIR__ . '/../../lang/' . $this->lang . '.php';
        if (file_exists($file)) {
            $this->translations = require $file;
        } else {
            // Fallback to EN if file missing
            $file = __DIR__ . '/../../lang/en.php';
            if (file_exists($file)) {
                $this->translations = require $file;
            }
        }
    }

    public function get($key) {
        return isset($this->translations[$key]) ? $this->translations[$key] : $key;
    }

    public function getCurrentLang() {
        return $this->lang;
    }
}

// Global helper function
function __($key) {
    global $language;
    return $language->get($key);
}
