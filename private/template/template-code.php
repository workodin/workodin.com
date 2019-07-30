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
        echo $code ?? "";
        break;
    case "code":
        echo Site::Get("View")->buildCode($code ?? "");
        break;
    case "go":
        // pas d'indexation
        header("X-Robots-Tag: noindex, nofollow", true);
        // redirection vers une autre url
        header("Location: $code");
        break;
    case "pro":
    case "proxy":
        // redirection vers une autre url
        echo file_get_contents("$code");
        break;
    default:
        header("Content-Type: text/plain");
        // ce template permet de renvoyer seulement le contenu de la colonne code
        if ($category == "command")
        {
            echo Site::Get("View")->buildCode($code ?? "");
        }
        else
        {
            echo $code ?? "";
        }
}

