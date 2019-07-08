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

        $feedback = "";
        // traitement du formulaire
        $password   = $form->getInfo("password");
        $code       = $form->getInfo("code");
        if (($password != "") && ($password == $installKey) && ($code != ""))
        {
            $objModel = Site::Get("Model");

            $tabScript = explode("\n", $code);
            foreach($tabScript as $lineScript)
            {
                $lineScript = trim($lineScript);
                $feedback .= "($lineScript)";
                if ($lineScript == "SQL")
                {
                    // création des tables SQL
                    $filePost = "$modelDir/Post.sql";
                    if (is_file($filePost)) 
                    {
                        $sqlPost = file_get_contents($filePost);
                        $objModel->executeSQL($sqlPost);

                    }
                }        
                if ($lineScript == "USER")
                {
                    // ajout de l'utilisateur admin
                    $nbUser = $objModel->count("User");
                    if ($nbUser == 0)
                    {
                        global $adminEmail;
                        $adminPassword = $this->createPassword($adminEmail);
                        // https://www.php.net/manual/fr/function.password-hash.php
                        $adminPasswordHash = password_hash($adminPassword, PASSWORD_DEFAULT);
                        $objModel->insertLine("User", [
                            "login"             => "admin",
                            "email"             => $adminEmail,
                            "password"          => $adminPasswordHash,
                            "level"             => 100,
                            "role"              => "admin",
                            "creationDate"      => date("Y-m-d H:i:s"),
                        ]);

                        $feedback .= "($adminPassword)";

                    }
                }
            }
        }
        else 
        {
            $feedback = "désolé";
        }
        return $feedback;
    }


    /**
     * 
     */
    function createPassword ($seed)
    {
        // https://www.php.net/manual/fr/function.password-hash.php
        // https://www.php.net/manual/fr/function.md5.php
        return md5(password_hash($seed, PASSWORD_DEFAULT));
    }
}