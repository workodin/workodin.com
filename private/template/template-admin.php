<?php

// cette page devra être protégée
// si le visiteur ne s'est pas identifié comme un administrateur
// alors on le renvoie vers la page de login
$levelUser = Site::Get("Session")->get("levelUser", 0);
if ($levelUser < 100)
{
    // accès interdit    
    // https://www.php.net/manual/fr/function.header.php
    header("Location: /login");
}
else
{
    // accès ok
    $loginUser = Site::Get("Session")->get("loginUser");

    require_once("$viewDir/part/header-admin.php");
    require_once("$viewDir/part/section-post.php");
    require_once("$viewDir/part/footer-admin.php");
}
