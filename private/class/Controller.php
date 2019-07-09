<?php

/**
 * 
 */
class Controller
{
    /**
     * 
     */
    public $form = null;

    /**
     * 
     */
    public $tabForm = [];

    /**
     * 
     */
    public $tabError = [];

    /**
     * 
     */
    public $feedback = "";

    /**
     * 
     */
    function __construct ()
    {
        $this->form = Site::Get("Form");
    }

    /**
     * 
     */
    function check($name, $type, $defaultValue="", $params="", $tableName="")
    {
        $value = $this->form->getInfo($name, $defaultValue);

        if ($type == "uri")
        {
            $value = preg_replace("/[^a-zA-Z0-9-]/", "", $value);
            $value = strtolower($value);
        }
        $this->tabForm[$name] = $value;

        $tabParam = explode("/", $params);
        if (in_array("unique", $tabParam))
        {
            $nbLine = Site::Get("Model")->count($tableName, $name, $value);  
            if ($nbLine > 0)
            {
                $this->tabError[] = "($name existe déjà: $value)";
            }      
        }
        if (in_array("unique1", $tabParam))
        {
            $nbLine = 0;
            $objPDOStatement = Site::Get("Model")->readLine($tableName, $name, $value);
            $idCurrent = $this->form->getInt("id");
            foreach($objPDOStatement as $tabLine)
            {
                if ($idCurrent != $tabLine["id"])
                {
                    $nbLine++;
                }
            }
            if ($nbLine > 0)
            {
                $this->tabError[] = "($name existe déjà: $value)";
            }      
        }

        // valeur obligatoire
        if (!in_array("optional", $tabParam))
        {
            if ($value == "")
            {
                $this->tabError[] = "($name manquant)";
            }
        }

        // permet le chainage des appels
        return $this;
    }

    /**
     * 
     */
    function getNbError ()
    {
        return count($this->tabError);
    }

    /**
     * 
     */
    function getFeedback ()
    {
        $nbError = $this->getNbError();
        if ($nbError > 0)
        {
            return "il y a $nbError erreur(s). " 
                    . implode(",", $this->tabError);
        }
        else
        {
            return $this->feedback;
        }
    }

    /**
     * 
     */
    function getTabForm ()
    {
        return $this->tabForm;
    }

    /**
     * 
     */
    function addData ($name, $value)
    {
        $this->tabForm[$name] = $value;

        // permet le chainage des appels
        return $this;
    }

    /**
     * 
     */
    function insertLine($tableName, $feedbackSuccess)
    {
        if ($this->getNbError() == 0)
        {
            Site::Get("Model")->insertLine($tableName, $this->getTabForm());
            $this->feedback = $feedbackSuccess;
        }

        // permet le chainage des appels
        return $this;
    }

    /**
     * 
     */
    function deleteLine ($tableName, $feedbackSuccess, $columnName="id")
    {
        $value = $this->form->getInfo($columnName);
        Site::Get("Model")->deleteLine($tableName, $columnName, $value);
        $this->feedback = $feedbackSuccess;

        // permet le chainage des appels
        return $this;
    }

    /**
     * 
     */
    function updateLine($tableName, $feedbackSuccess, $columnName="id")
    {
        if ($this->getNbError() == 0)
        {
            $value = $this->form->getInfo($columnName);
            Site::Get("Model")->updateLine($tableName, $this->getTabForm(), $value, $columnName);
            $this->feedback = $feedbackSuccess;
        }

        // permet le chainage des appels
        return $this;
    }

    /**
     * 
     */
    function addUpload ($nameInput, $type, $default, $params)
    {
        $tabParam = explode(",", $params);

        $finalPath = "";
        $tabInfo = $this->form->getInfoUpload($nameInput);
        $tabErrorUpload = [];

        if (!empty($tabInfo))
        {
            extract($tabInfo);
            // $name, $type, $size, $tmp_name, $error
            if ($error == UPLOAD_ERR_OK)
            {
                // https://www.php.net/manual/fr/function.pathinfo.php
                $filename = pathinfo($name, PATHINFO_FILENAME);
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $extension = strtolower($extension);
                $tabExtensionOK = [ 
                    "jpg", "jpeg", "png", "gif",
                    "pdf", "txt", 
                    "html", "css", "js", 
                    "svg", "md", 
                    "mp4", "mp3", "ogg",
                ];

                if (in_array($extension, $tabExtensionOK))
                {
                    // filtrer filename
                    preg_replace("/[^a-zA-Z0-9-]/", "", $filename);
                    $filename = strtolower($filename);
                    $uploadDir = Site::Get("uploadDir");
                    if (is_dir($uploadDir))
                    {
                        move_uploaded_file($tmp_name, "$uploadDir/$filename.$extension");
                        $uploadPath = Site::Get("uploadPath");

                        $finalPath = "$uploadPath/$filename.$extension";

                    }
                    else
                    {
                        $tabErrorUpload[] = "(dossier incorrect: $uploadDir)";
                    } 
                }
                else
                {
                    $tabErrorUpload[] = "(extension incorrecte: $extension)";
                } 
            }
            else if ($error == UPLOAD_ERR_NO_FILE)
            {
                // aucun fichier uploadé
                if (!in_array("optional", $tabParam))
                {
                    $tabErrorUpload[] = "(erreur fichier manquant)";
                }
            }
            else
            {
                $tabErrorUpload[] = "(erreur durant upload)";
                print_r($_FILES);
                print_r($tabInfo);

            } 
        }

        if (!empty($tabErrorUpload))
        {
            $this->tabError[] = implode(",", $tabErrorUpload);
        }

        if (!in_array("optional", $tabParam))
        {
            // mémoriser pour SQL
            $this->tabForm[$nameInput] = $finalPath;
        }
        else
        {
            if ($finalPath != "")
            {
                // mémoriser pour SQL
                $this->tabForm[$nameInput] = $finalPath;
            }
        }

        // permet le chainage des appels
        return $this;
    }

}