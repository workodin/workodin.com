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
    function check($name, $type, $defaultValue="")
    {
        $value = $this->form->getInfo($name, $defaultValue);
        $this->tabForm[$name] = $value;

        if ($value == "")
        {
            $this->tabError[] = "($name manquant)";
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
}