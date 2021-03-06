<?php

/**
 * 
 */
class FormPost 
{
    /**
     * 
     */
    function processCreate ()
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
        }
        return $feedback;
    }

    /**
     * 
     */
    function processDelete ()
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
        }
        return $feedback;
    }

    /**
     * 
     */
    function processUpdate ()
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
        }
        return $feedback;
    }

}