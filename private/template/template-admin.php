<?php

// cette page devra être protégée
// si le visiteur ne s'est pas identifié comme un administrateur
// alors on le renvoie vers la page de login
$levelUser = Site::Get("Session")->get("levelUser", 0);
if ($levelUser < 100)
{
    // accès interdit    
    // important: erreur 404 pour les moteurs de recherche
    // https://www.php.net/manual/fr/function.header.php
    header("HTTP/1.1 404 Not Found");
    require_once("$viewDir/template-404.php");
}
else
{
    // accès ok
    $loginUser = Site::Get("Session")->get("loginUser");

    require_once("$viewDir/part/header-admin.php");
    require_once("$viewDir/part/section-post.php");
    require_once("$viewDir/part/footer-admin.php");
}
