<?php

/**
 * gestion des formulaires 
 */
class Form
{
    /**
     * 
     */
    public $tabKeyVal = [];

    /**
     * on garde des valeurs dans une propriété
     * pour les réutiliser à travers plusieurs appels à la même fonction
     */
    public $tabFeedback = [];

    /**
     * 
     */
    function __construct ()
    {
        $keyPrivate = md5(json_encode(stat(__FILE__)));
        $keyPublic  = base64_encode(password_hash($keyPrivate, PASSWORD_DEFAULT));
        $this->set("formKeyPrivate", $keyPrivate);
        $this->set("formKeyPublic", $keyPublic);

    }

    /**
     * traiter le formulaire envoyé dans une requête
     * (note: cette fonction appelle une autre fonction getInfo)
     * @param  l'étiquette du formulaire 
     * 
     */
    function process ($formFeedback="")
    {

        if ($formFeedback == "")
        {
            $formKey        = $this->getInfo("formKey");
            $formTag        = $this->getInfo("formTag");
            // filtrer pour ne garder que les lettres et les chiffres
            // https://www.php.net/manual/fr/function.preg-replace.php
            $formTag        = preg_replace("/[^a-zA-Z0-9]/", "", $formTag);
        
            // framework dynamique
            // on prend comme convention que le traitement du formulaire est géré 
            // par une fonction dont le nom commence par processForm
            // et finit par l'étiquette du formulaire
            // exemple: 
            // <input type="hidden" name="formTag" value="Newsletter">
            // <input type="hidden" name="formTagMethod" value="process">
            // sera traité par la méthode FormNewsletter::process
            if (($formKey != "") && ($formTag != ""))
            {
                // SECURITE: 
                // on préfixe le nom de la classe avec Form
                // pour ne pas pouvoir activer n'importe quel classe
                $nomClasse = "Form$formTag";

                $formTagMethod  = $this->getInfo("formTagMethod");
                $formTagMethod  = preg_replace("/[^a-zA-Z0-9]/", "", $formTagMethod);
                $formTagMethod = "process$formTagMethod";
                
                // https://www.php.net/manual/fr/function.method-exists.php
                if (method_exists($nomClasse, $formTagMethod)) {
                    // assez étrange, mais ça fonctionne avec PHP ;-p
                    // et on mémorise le feedback pour pouvoir l'afficher plus tard
                    // WARNING: EXTREMENT DANGEREUX CAR UN FORMULAIRE POURRAIT ACTIVER UN CODE PHP ARBITRAIRE
                    // TODO: SECURITE
                    $objet = new $nomClasse;
                    $this->tabFeedback[$formTag] = $objet->$formTagMethod($this);
                }    
            }    
        }
        else 
        {
            // on affiche le message feedback 
            // pour permettre l'affichage dans la partie view
            echo $this->tabFeedback[$formFeedback] ?? "";
        }
    }

    /**
     * récupère une info envoyée la navigateur à travers un formulaire
     * exemple:
     * <input name="nom">
     * $nom = getInfo("nom");
     */
    function getInfo ($name, $default="")
    {
        $value = $default;
        if (isset($_REQUEST["$name"]))
        {
            $value = trim(strip_tags($_REQUEST["$name"]));
        }
        return $value;
    }

    /**
     * récupère une info envoyée la navigateur à travers un formulaire
     * SECURITE: DANGER, ON NE PASSE AUCUN FILTRE
     */
    function getInfo0 ($name, $default="")
    {
        return $_REQUEST["$name"] ?? $default;
    }

    /**
     * SECURITE: transforme le texte extérieur en nombre entier
     */
    function getInt ($name, $default=0)
    {
        return intval($this->getInfo($name, $default));
    }

    /**
     * 
     */
    function set ($key, $value)
    {
        $this->tabKeyVal[$key] = $value;
    }

    /**
     * 
     */
    function get ($key, $default="")
    {
        return $this->tabKeyVal[$key] ?? $default;
    }

    /**
     * 
     */
    function show ($key, $default="")
    {
        echo $this->tabKeyVal[$key] ?? $default;
    }

    /**
     * 
     */
    function getInfoUpload ($name)
    {
        $tabInfo = $_FILES[$name] ?? [];
        return $tabInfo;
    }

    /**
     * 
     */
    function getJSON ($tabData=[])
    {
        // on ajoute les feedbacks dans la réponse
        $tabResponse = $tabData + $this->tabFeedback;
        $tabResponse["timestamp"] = time();

        $texteJSON = json_encode($tabResponse);

        return $texteJSON;
    }

    /**
     * 
     */
    function addFeedback ($key, $value)
    {
        // on stocke dans le tableau associatif
        $this->tabFeedback[$key] = $value;
        // pour permettre le chainage des appels
        return $this;
    }
}