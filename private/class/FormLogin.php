<?php

class FormLogin 
{
    /**
     * traiter le formulaire de contact
     * (note: cette fonction appelle une autre fonction getInfo)
     * @return le message de confirmation (feedback)
     * 
     */
    function process ($form)
    {
        // attention
        // on peut utiliser des variables globales
        // mais il faut prévenir PHP

        $feedback = "";
        // traitement du formulaire
        $email          = $form->getInfo("email");
        $passwordForm   = $form->getInfo("password");
        if (($email != "") && ($passwordForm != "") && (filter_var($email, FILTER_VALIDATE_EMAIL)))
        {
            $objModel = Site::Get("Model");
            $objPDOStatement = $objModel->readLine("User", "email", $email);
            $tabLine = [];
            // on utilise $objPDOStatement comme Traversable
            foreach($objPDOStatement as $tabLine)
            {
                // rien à faire
            }
            // https://www.php.net/manual/fr/function.empty.php
            if (!empty($tabLine))
            {
                // OK, on a trouvé une ligne qui correspond
                // https://www.php.net/manual/fr/function.extract.php
                extract($tabLine);
                // attention: extract crée des variables locales à partir des colonnes
                // (notamment ici $password)
                if (password_verify($passwordForm, $password))
                {
                    // on mémorise les infos User dans une session
                    Site::Get("Session")
                            ->set("levelUser",  $level)     // SECURITE: DONNE LES ACCES
                            ->set("roleUser",   $role)      // SECURITE: DONNE LES ACCES
                            ->set("idUser",     $id)
                            ->set("emailUser",  $email)
                            ->set("loginUser",  $login);
                    
                    // redirection suivant level
                    if ($level == 10)
                    {
                        // https://www.php.net/manual/fr/function.header.php
                        // header("Location: /membre");

                        // pour redirection avec Ajax
                        $form->addFeedback("redirection", "/membre");

                    } 

                    // redirection suivant level
                    if ($level == 100)
                    {
                        // https://www.php.net/manual/fr/function.header.php
                        // header("Location: /admin");

                        // pour redirection avec Ajax
                        $form->addFeedback("redirection", "/admin");
                    } 

                    // message feedback
                    $feedback = "bienvenue ($login)";                
                }
                else
                {
                    // mauvais mot de passe
                    $feedback = "désolé ($email)";                
                }
            }
            else
            {
                // email inconnu
                $feedback = "désolé ($email)";                
            }
        }

        return $feedback;
    }

    /**
     * 
     */
    function processRegister ($form)
    {
        $feedback = "...MERCI DE VOTRE PATIENCE...";
        $objController = Site::Get("Controller");

        // SECURITE
        $levelUser = Site::Get("Session")->get("levelUser");
        if ($levelUser >= 0)
        {
            $now = date("Y-m-d H:i:s");
            $feedback = $objController
                            ->check("login",      "uri", "", "unique", "User")
                            ->check("email",      "email", "", "unique", "User")
                            ->check("password",   "password")
                            ->addData("creationDate", $now)
                            ->addData("level", 10)
                            ->addData("role", "member")
                            // ajouter la ligne
                            ->insertLine("User", "votre compte est activé")
                            // récupérer le message de confirmation
                            ->getFeedback();
            // on envoie un mail 
            extract($objController->getTabForm());   
            Site::Get("Email")->send("inscription/$email/$login", 
                                        "nouvel user inscrit: $email / $login / $now");
        }
        return $feedback;
    }
}