<?php

$extension = Site::Get("pagePathExtension");
switch ($extension)
{
    case "json":
        header("Content-Type: application/javascript; charset=UTF-8");
        echo $form->getJSON();
        break;
    case "js":
        header("Content-Type: application/javascript; charset=UTF-8");
        // ce template permet de renvoyer seulement le contenu de la colonne code
        echo $code;
        break;
    default:
        header("Content-Type: text/plain");
        // ce template permet de renvoyer seulement le contenu de la colonne code
        echo $code;
}

