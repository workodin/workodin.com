<?php

// on change les doits d'accès
Site::Get("Session")
->set("levelUser",  -1)             // SECURITE: DONNE LES ACCES
->set("roleUser",   "logout")       // SECURITE: DONNE LES ACCES
;

// on ne reste pas sur cette page intermédiaire
// https://www.php.net/manual/fr/function.header.php
// on redirige le visiteur vers la page de login
header("Location: /login");
