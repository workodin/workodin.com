<?php

/**
 * gestion de la BDD MySQL
 */
class Model 
{
    // (static) propriétés collectives de Classe

    /**
     * connesion unique à la BDD MySQL
     */
    public static $objPDO   = null;

    // propriétés individuelles d'objet

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
        if (self::$objPDO == null)
        {
            // https://www.php.net/manual/fr/pdo.construct.php
            self::$objPDO = new PDO($this->dsnSQL, $this->userSQL, $this->passwordSQL);
            // https://www.php.net/manual/fr/pdo.error-handling.php
            self::$objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }

        // SECURITE
        // PROTECTION CONTRE LES INJECTIONS SQL
        // https://www.php.net/manual/fr/pdo.prepare.php
        $this->objPDOStatement = self::$objPDO->prepare($requestSQL);
        // https://www.php.net/manual/fr/pdostatement.execute.php
        $this->objPDOStatement->execute($tabToken);

        // debug
        // https://www.php.net/manual/fr/pdostatement.debugdumpparams.php
        // $this->objPDOStatement->debugDumpParams();

        // pour la lecture des données
        // https://www.php.net/manual/fr/pdostatement.setfetchmode.php
        // https://www.php.net/manual/fr/pdostatement.fetch.php
        $this->objPDOStatement->setFetchMode(PDO::FETCH_ASSOC);

        return $this->objPDOStatement;
    }

    /**
     * 
     */
    function insertLine($tableName, $tabColumnValue)
    {
        $listColumn = "";
        $listToken  = "";
        $first      = true;
        foreach($tabColumnValue as $col => $val)
        {
            if ($first)
            {
                $listColumn .= "`$col`";
                $listToken  .= ":$col";
                $first = false;
            }
            else 
            {
                $listColumn .= ", `$col`";
                $listToken  .= ", :$col";
            }

        }
        // on construit une requête SQL préparée avec des jetons/tokens
        $codeSQL =
<<<SQL
 
 INSERT INTO `$tableName`
 ( $listColumn ) 
 VALUES 
 ( $listToken );

SQL;

        // on exécute la requête preparée
        return $this->executeSQL($codeSQL, $tabColumnValue);

    }

    /**
     * 
     */
    function count ($tableName, $filterColumn="", $filterValue="")
    {
        $tabColumnValue = [];
        $filterWhere    = "";
        if ($filterColumn != "")
        {
            $filterWhere = "WHERE `$filterColumn` = :$filterColumn";
            $tabColumnValue[$filterColumn] = $filterValue;
        }
        // on construit une requête SQL préparée avec des jetons/tokens
        $codeSQL =
<<<SQL
 
SELECT count(*) 
FROM `$tableName`
$filterWhere

SQL;

        // on exécute la requête preparée
        $objPDOStatement = $this->executeSQL($codeSQL, $tabColumnValue);
        // on renvoie directement la valeur
        // https://www.php.net/manual/fr/pdostatement.fetchcolumn.php
        return $objPDOStatement->fetchColumn();
    }

    /**
     * 
     */
    function readLine ($tableName, $filterColumn="", $filterValue="")
    {
        $tabColumnValue = [];
        $filterWhere    = "";
        if ($filterColumn != "")
        {
            $filterWhere = "WHERE `$filterColumn` = :$filterColumn";
            $tabColumnValue[$filterColumn] = $filterValue;
        }
        // on construit une requête SQL préparée avec des jetons/tokens
        $codeSQL =
<<<SQL
 
SELECT * 
FROM `$tableName`
$filterWhere

SQL;

        // on exécute la requête preparée
        return $this->executeSQL($codeSQL, $tabColumnValue);

    }

    /**
     * ATTENTION: PEUT SUPPRIMER TOUTES LES LIGNES SI MAL UTILISE
     */
    function deleteLine ($tableName, $filterColumn="", $filterValue="")
    {
        $tabColumnValue = [];
        $filterWhere    = "";
        if ($filterColumn != "")
        {
            $filterWhere = "WHERE `$filterColumn` = :$filterColumn";
            $tabColumnValue[$filterColumn] = $filterValue;
        }
        // on construit une requête SQL préparée avec des jetons/tokens
        $codeSQL =
<<<SQL
 
DELETE 
FROM `$tableName`
$filterWhere

SQL;

        // on exécute la requête preparée
        return $this->executeSQL($codeSQL, $tabColumnValue);

    }

}