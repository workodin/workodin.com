<?php

class FormInstall 
{
    /**
     * traiter le formulaire de Install
     * (note: cette fonction appelle une autre fonction getInfo)
     * @return le message de confirmation (feedback)
     * 
     */
    function process ($form)
    {
        // attention
        // on peut utiliser des variables globales
        // mais il faut prévenir PHP
        global $modelDir, $installKey;

        $feedback = "...";
        // traitement du formulaire
        $key    = $form->getInfo("key");
        $code   = $form->getInfo("code");
        if (($key != "") && ($key == $installKey) && ($code != ""))
        {
            // création de la table Post
            $objModel = Site::Get("Model");
            $filePost = "$modelDir/Post.sql";
            if (is_file($filePost)) 
            {
                $sqlPost = file_get_contents($filePost);
                $objModel->executeSQL($sqlPost);
            }

            $feedback = "code exécuté";
        }
        else 
        {
            $feedback = "désolé";
        }
        return $feedback;
    }

}