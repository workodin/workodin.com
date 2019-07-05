<?php

/**
 * gestion de la BDD MySQL
 */
class Model 
{
    /**
     * DSN pour se connecter à la database
     */
    public $dsnSQL = "";

    /**
     * 
     */
    public $userSQL = "";

    /**
     * 
     */
    public $passwordSQL = "";

    /**
     * 
     */
    public $objPDO = null;

    /**
     * 
     */
    public $objPDOStatement = null;

    /**
     * constructeur
     */
    function __construct ($tabSQLConfig=[])
    {
        // paramètres DEV habituels
        $host       = "localhost";
        $user       = "root";
        $password   = "";
        $database   = "workodin";

        // on écrase les valeurs précédentes avec celles fournies en paramètre
        // https://www.php.net/manual/fr/function.extract.php    
        extract($tabSQLConfig);

        // https://www.php.net/manual/fr/pdo.construct.php
        $this->dsnSQL       = "mysql:host=$host;dbname=$database;charset=utf8";
        $this->userSQL      = $user;
        $this->passwordSQL  = $password;
        
    }

    /**
     * 
     */
    function executeSQL ($requestSQL, $tabToken=[])
    {
        // connexion seulement la première fois
        if ($this->objPDO == null)
        {
            // https://www.php.net/manual/fr/pdo.construct.php
            $this->objPDO = new PDO($this->dsnSQL, $this->userSQL, $this->passwordSQL);
            // https://www.php.net/manual/fr/pdo.error-handling.php
            $this->objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }

        // SECURITE
        // PROTECTION CONTRE LES INJECTIONS SQL
        // https://www.php.net/manual/fr/pdo.prepare.php
        $this->objPDOStatement = $this->objPDO->prepare($requestSQL);
        // https://www.php.net/manual/fr/pdostatement.execute.php
        $this->objPDOStatement->execute($tabToken);

        // pour la lecture des données
        // https://www.php.net/manual/fr/pdostatement.setfetchmode.php
        // https://www.php.net/manual/fr/pdostatement.fetch.php
        $this->objPDOStatement->setFetchMode(PDO::FETCH_ASSOC);

        return $this->objPDOStatement;
    }

}