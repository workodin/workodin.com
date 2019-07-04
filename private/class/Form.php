<?php

/**
 * gestion des formulaires 
 */
class Form
{
    /**
     * traiter le formulaire envoyé dans une requête
     * (note: cette fonction appelle une autre fonction getInfo)
     * @param  l'étiquette du formulaire 
     * 
     */
    function process ($formFeedback="")
    {
        // on garde des valeurs dans une variable static
        // pour les réutiliser à travers plusieurs appels à la même focntion
        static $tabFeedback = [];

        if ($formFeedback == "")
        {
            $formTag        = $this->getInfo("formTag");
            $formTagMethod  = $this->getInfo("formTagMethod", "process");
            // filtrer pour ne garder que les lettres et les chiffres
            // https://www.php.net/manual/fr/function.preg-replace.php
            $formTag        = preg_replace("/[^a-zA-Z0-9]/", "", $formTag);
            $formTagMethod  = preg_replace("/[^a-zA-Z0-9]/", "", $formTagMethod);
        
            // framework dynamique
            // on prend comme convention que le traitement du formulaire est géré 
            // par une fonction dont le nom commence par processForm
            // et finit par l'étiquette du formulaire
            // exemple: 
            // <input type="hidden" name="formTag" value="Newsletter">
            // <input type="hidden" name="formTagMethod" value="process">
            // sera traité par la méthode FormNewsletter::process
            if (($formTag != "") && ($formTagMethod != ""))
            {
                // SECURITE: 
                // on préfixe le nom de la classe avec Form
                // pour ne pas pouvoir activer n'importe quel classe
                $nomClasse = "Form$formTag";
                // https://www.php.net/manual/fr/function.method-exists.php
                if (method_exists($nomClasse, $formTagMethod)) {
                    // assez étrange, mais ça fonctionne avec PHP ;-p
                    // et on mémorise le feedback pour pouvoir l'afficher plus tard
                    // WARNING: EXTREMENT DANGEREUX CAR UN FORMULAIRE POURRAIT ACTIVER UN CODE PHP ARBITRAIRE
                    // TODO: SECURITE
                    $objet = new $nomClasse;
                    $tabFeedback[$formTag] = $objet->$formTagMethod($this);
                }    
            }    
        }
        else 
        {
            // on affiche le message feedback 
            // pour permettre l'affichage dans la partie view
            echo $tabFeedback[$formFeedback] ?? "";
        }
    }

    /**
     * récupère une info envoyée la navigateur à travers un formulaire
     * exemple:
     * <input name="nom">
     * $nom = getInfo("nom");
     */
    function getInfo($name, $default="")
    {
        $value = $default;
        if (isset($_REQUEST["$name"]))
        {
            $value = trim(strip_tags($_REQUEST["$name"]));
        }
        return $value;
    }

}