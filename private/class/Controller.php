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
            return "il y a $nbError erreur(s)";
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

}