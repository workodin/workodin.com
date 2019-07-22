<?php

class FormAdmin
{
    /**
     * 
     */
    function processFile ($form)
    {
        $feedback = "";
        $objController = Site::Get("Controller");

        // SECURITE
        $levelUser = Site::Get("Session")->get("levelUser");
        if ($levelUser == 100)
        {
            $now = date("Y-m-d H:i:s");
            $feedback = $objController
                            ->check("path",    "path")
                            ->check("code",    "code", "", "optional")
                            // compléter les infos manquantes
                            ->addData("creationDate", $now)
                            ->addData("modificationDate", $now)
                            // ajouter la ligne
                            ->insertLine("File", "votre fichier est enregistré")
                            // récupérer le message de confirmation
                            ->getFeedback()
                            ;

            // crée les variables
            extract($objController->getTabForm());

            // créer le dossier cache
            $dataDir = Site::Get("baseDir") . "/my-work";
            if(!is_dir($dataDir))
            {
                mkdir($dataDir);
            }
            // créer le fichier cache
            $md5path = md5($path);
            file_put_contents("$dataDir/my-$md5path", $code);

            // on ajoute le tableau des résultats
            $objModel           = Site::Get("Model");
            $objPDOStatement    = $objModel->readLine("File", "", "", "modificationDate");
            $form->addFeedback("tabFile", $objPDOStatement->fetchAll());

        }
        return $feedback;

    }
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
            $objPDOStatement    = $objModel->readLine("Post", "", "", "publicationDate");
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
            // TODO: improve security
            $table = $form->getInfo("table");
            $id    = $form->getInt("id");
            $feedback = $objController
                            ->deleteLine($table, "la ligne ($id) a été supprimée")
                            // récupérer le message de confirmation
                            ->getFeedback()
                            ;

            // on ajoute le tableau des résultats
            $objModel           = Site::Get("Model");
            $objPDOStatement    = $objModel->readLine("Post", "", "", "publicationDate");
            $form->addFeedback("tabResult", $objPDOStatement->fetchAll());

            $objPDOStatement    = $objModel->readLine("File", "", "", "modificationDate");
            $form->addFeedback("tabFile", $objPDOStatement->fetchAll());
        }
        return $feedback;
    }

    /**
     * 
     */
    function processFileDelete ($form)
    {
        $feedback = "";
        $objController = Site::Get("Controller");

        // SECURITE: ATTENTION PEUT SUPPRIMER TOUTE UNE TABLE
        $levelUser = Site::Get("Session")->get("levelUser");
        if ($levelUser == 100)
        {
            // TODO: improve security
            $table = $form->getInfo("table");
            $id    = $form->getInt("id");
            $objPDOStatement = Site::get("Model")->readLine("File", "id", $id);
            $md5path         = "";
            $feedbackVirtual = "";
            foreach($objPDOStatement as $tabLine)
            {
                extract($tabLine);
                $md5path = md5($path);

            }
            if ($md5path != "") {
                $baseDir = Site::get("baseDir");
                $virtualPath = "$baseDir/my-work/my-$md5path";
                if (is_file($virtualPath))
                {
                    // DANGER: on supprime un fichier
                    unlink($virtualPath);
                    // réinitialise le cache PHP
                    // https://www.php.net/manual/fr/function.clearstatcache.php
                    clearstatcache(true, $virtualPath);

                    $feedbackVirtual = "et aussi le fichier virtuel ($virtualPath)";
                }    
            }

            $feedback = $objController
                            ->deleteLine($table, "la ligne ($id) a été supprimée. $feedbackVirtual")
                            // récupérer le message de confirmation
                            ->getFeedback()
                            ;

            // on ajoute le tableau des résultats
            $objModel           = Site::Get("Model");
            $objPDOStatement    = $objModel->readLine("Post", "", "", "publicationDate");
            $form->addFeedback("tabResult", $objPDOStatement->fetchAll());

            $objPDOStatement    = $objModel->readLine("File", "", "", "modificationDate");
            $form->addFeedback("tabFile", $objPDOStatement->fetchAll());
        }
        return $feedback;
    }

    /**
     * 
     */
    function processFileCacheReset ($form)
    {
        $feedback = "";
        $objController = Site::Get("Controller");

        // SECURITE: ATTENTION PEUT SUPPRIMER TOUTE UNE TABLE
        $levelUser = Site::Get("Session")->get("levelUser");
        if ($levelUser == 100)
        {
            $baseDir = Site::get("baseDir");
            $cacheMask = "$baseDir/my-work/my-*";
            // https://www.php.net/manual/fr/function.glob.php
            $tabCache = glob($cacheMask);
            $count = 0;
            foreach($tabCache as $cache)
            {
                // DANGER: on supprime le fichier de cache
                unlink($cache);
                $count++;
            }

            $feedback = "$count fichiers supprimés";
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
            $objPDOStatement    = $objModel->readLine("Post", "", "", "publicationDate");
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
            // on ajoute le tableau des résultats Post
            $objModel           = Site::Get("Model");
            $objPDOStatement    = $objModel->readLine("Post", "", "", "publicationDate");
            $form->addFeedback("tabResult", $objPDOStatement->fetchAll());

            // on ajoute le tableau des résultats File
            $objPDOStatement    = $objModel->readLine("File", "", "", "modificationDate");
            $form->addFeedback("tabFile", $objPDOStatement->fetchAll());
        }
        return $feedback;
    }

}