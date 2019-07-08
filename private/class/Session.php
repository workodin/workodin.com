<?php

/**
 * 
 */
class Session
{
    /**
     * 
     */
    function get ($key, $defaultValue="")
    {
        if (!isset($_SESSION))
        {
            // https://www.php.net/manual/fr/function.session-start.php
            // cela va créer le tableau $_SESSION
            session_start();
        }
        // on renvoie la valeur associée à la clé
        // si la clé n'est pas dans le tableau, on renvoie la valeur par défaut
        return $_SESSION[$key] ?? $defaultValue;
    }

    /**
     * 
     */
    function set ($key, $value)
    {
        if (!isset($_SESSION))
        {
            // https://www.php.net/manual/fr/function.session-start.php
            // cela va créer le tableau $_SESSION
            session_start();
        }
        // on stocke les infos dans le tableau associatif $_SESSION
        // ensuite PHP gère la persistence des infos dans un fichier
        $_SESSION[$key] = $value;

        // pour permettre le chainage des appels
        return $this;
    }
}