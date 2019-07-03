<?php

/**
 * configure le mode de développement
 */
function setSiteMode ($mode)
{
    if ($mode == "DEV") 
    {
        error_reporting(E_ALL);
        ini_set("display_errors", "1");        
    }
}

/**
 * récupère une info envoyée la navigateur à travers un formulaire
 * exemple:
 * <input name="nom">
 * $nom = getInfo("nom");
 */
function getInfo($name, $default="")
{
    return trim(strip_tags($_REQUEST["$name"] ?? "$default"));
}

