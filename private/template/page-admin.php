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
    header("HTTP/1.0 404 Not Found");
    require_once("$viewDir/header.php");
    require_once("$viewDir/section-404.php");
    require_once("$viewDir/footer.php");
}
else
{
    // accès ok
    $loginUser = Site::Get("Session")->get("loginUser");

    require_once("$viewDir/header.php");
    require_once($fichierSection);
    require_once("$viewDir/footer.php");

}
