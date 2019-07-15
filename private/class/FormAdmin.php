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
                    $feedback = ob_get_clean();

                    // on ajoute le tableau des résultats
                    $form->addFeedback("tabResult", $objPDOStatement->fetchAll());

                }
            }               
        }
        
        return $feedback;
    }

}