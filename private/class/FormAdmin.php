<?php

class FormAdmin
{
    /**
     * DANGER: ON PEUT EXECUTER N'IMPORTE QUELLE REQUETE SQL
     * (note: cette fonction appelle une autre fonction getInfo)
     * @return le message de confirmation (feedback)
     * 
     */
    function processSql ($form)
    {
        $feedback = "";

        $objController = Site::Get("Controller");

        // SECURITE
        $levelUser = Site::Get("Session")->get("levelUser");
        if ($levelUser == 100)
        {
            $feedback = $objController
                            ->check("code",    "text")
                            ->check("format",  "uri")
                            // récupérer le message de confirmation
                            ->getFeedback()
                            ;
            if (0 == $objController->getNbError())
            {
                // récupère les variables $code et $format
                extract($objController->getTabForm());
                if ($format == "sql")
                {
                    ob_start();
                    // DANGER: ON PEUT EXECUTER N'IMPORTE QUELLE REQUETE SQL
                    $objPDOStatement = Site::Get("Model")->executeSQL($code);
                    // debug
                    // https://www.php.net/manual/fr/pdostatement.debugdumpparams.php
                    $objPDOStatement->debugDumpParams();
                    // https://www.php.net/manual/fr/pdostatement.errorinfo.php
                    print_r($objPDOStatement->errorInfo());
                    $feedback = ob_get_clean();
                    // bricolage pour seulement retourner des résultats sur un SELECT
                    if(0 === strpos($code, "SELECT"))
                    {
                        // on ajoute le tableau des résultats
                        $form->addFeedback("tabResult", $objPDOStatement->fetchAll());
                    }

                }
            }               
        }
        
        return $feedback;
    }

    /**
     * 
     */
    function processCreate ($form)
    {
        $feedback = "";
        $objController = Site::Get("Controller");

        // SECURITE
        $levelUser = Site::Get("Session")->get("levelUser");
        if ($levelUser == 100)
        {
            $now = date("Y-m-d H:i:s");
            $feedback = $objController
                            ->check("title",    "text")
                            ->check("uri",      "uri", "", "unique", "Post")
                            ->check("category", "text")
                            ->check("template", "uri", "", "optional")
                            ->check("code",     "code", "", "optional")
                            // compléter les infos manquantes
                            ->addUpload("urlMedia", "media", "", "optional")
                            ->addData("creationDate", $now)
                            ->addData("modificationDate", $now)
                            ->addData("publicationDate", $now)
                            // ajouter la ligne
                            ->insertLine("Post", "votre contenu est publié")
                            // récupérer le message de confirmation
                            ->getFeedback()
                            ;

            // on ajoute le tableau des résultats
            $objModel           = Site::Get("Model");
            $objPDOStatement    = $objModel->readLine("Post", "", "", "creationDate");
            $form->addFeedback("tabResult", $objPDOStatement->fetchAll());

        }
        return $feedback;
    }

    /**
     * 
     */
    function processDelete ($form)
    {
        $feedback = "";
        $objController = Site::Get("Controller");

        // SECURITE: ATTENTION PEUT SUPPRIMER TOUTE UNE TABLE
        $levelUser = Site::Get("Session")->get("levelUser");
        if ($levelUser == 100)
        {
            $feedback = $objController
                            ->deleteLine("Post", "le contenu a été supprimé")
                            // récupérer le message de confirmation
                            ->getFeedback()
                            ;
            // on ajoute le tableau des résultats
            $objModel           = Site::Get("Model");
            $objPDOStatement    = $objModel->readLine("Post", "", "", "creationDate");
            $form->addFeedback("tabResult", $objPDOStatement->fetchAll());
        }
        return $feedback;
    }

    /**
     * 
     */
    function processUpdate ($form)
    {
        $feedback = "";
        $objController = Site::Get("Controller");

        // SECURITE
        $levelUser = Site::Get("Session")->get("levelUser");
        if ($levelUser == 100)
        {
            $now = date("Y-m-d H:i:s");
            $idUser = Site::Get("Session")->get("idUser");

            $feedback = $objController
                            ->check("title",    "text")
                            ->check("uri",      "uri", "", "unique1", "Post")
                            ->check("category", "uri")
                            ->check("template", "uri", "", "optional")
                            ->check("code",     "code", "", "optional")
                            ->check("publicationDate", "datetime", $now)
                            // compléter les infos manquantes
                            ->addUpload("urlMedia",         "media", "", "optional")
                            ->addData("modificationDate",   $now)
                            ->addData("idUser",             $idUser)
                            // ajouter la ligne
                            ->updateLine("Post", "votre contenu est modifié")
                            // récupérer le message de confirmation
                            ->getFeedback()
                            ;
            // on ajoute le tableau des résultats
            $objModel           = Site::Get("Model");
            $objPDOStatement    = $objModel->readLine("Post", "", "", "creationDate");
            $form->addFeedback("tabResult", $objPDOStatement->fetchAll());
        }
        return $feedback;
    }

    /**
     * 
     */
    function processRead ($form)
    {
        $feedback = "";
        $objController = Site::Get("Controller");

        // SECURITE
        $levelUser = Site::Get("Session")->get("levelUser");
        if ($levelUser == 100)
        {
            // on ajoute le tableau des résultats
            $objModel           = Site::Get("Model");
            $objPDOStatement    = $objModel->readLine("Post", "", "", "creationDate");
            $form->addFeedback("tabResult", $objPDOStatement->fetchAll());
        }
        return $feedback;
    }

}