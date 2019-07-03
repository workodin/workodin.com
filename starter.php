<?php
// on garde ce dossier comme base pour tous les chemins
$baseDir = __DIR__;

// programmation fonctionnelle
// charger les déclarations des fonctions avant de pouvoir les utiliser
require_once("$baseDir/private/function.php");

// mode dev: debug plus facile
setSiteMode("DEV");

// variables globales
$today      = date("Y-m-d");
$now        = date("H:i:s");

// garder un log du visiteur
trackVisit();

// recomposer la page eavec les tranches de HTML
require_once("$baseDir/private/template/header.php");
require_once("$baseDir/private/template/section-index.php");
require_once("$baseDir/private/template/footer.php");
