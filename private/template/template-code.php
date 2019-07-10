<?php

$extension = Site::Get("pagePathExtension");
switch ($extension)
{
    case "js":
        header("Content-Type: application/javascript; charset=UTF-8");
        break;
    default:
        header("Content-Type: text/plain");
}

// ce template permet de renvoyer seulement le contenu de la colonne code
echo $code;
