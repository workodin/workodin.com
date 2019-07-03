<?php
// on garde ce dossier comme base pour tous les chemins
$baseDir = __DIR__;

// programmation fonctionnelle
require_once("$baseDir/private/function.php");

// mode dev: debug plus facile
setSiteMode("DEV");

// ajout de log pour suivre les visiteurs
// https://www.php.net/manual/fr/function.date-default-timezone-set.php
date_default_timezone_set("Europe/Paris");
$today      = date("Y-m-d");
$now        = date("H:i:s");
$uri        = $_SERVER["REQUEST_URI"];
$userAgent  = $_SERVER["HTTP_USER_AGENT"];
$ip         = $_SERVER["REMOTE_ADDR"];

// sauvegarder dans un fichier CSV
file_put_contents("$baseDir/private/visit-$today.csv", "$today $now,$uri,$ip,'$userAgent'\n", FILE_APPEND);

// recomposer la page eavec les tranches de HTML
require_once("$baseDir/private/template/header.php");
require_once("$baseDir/private/template/section-index.php");
require_once("$baseDir/private/template/footer.php");
