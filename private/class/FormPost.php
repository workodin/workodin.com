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
        // SECURITE
        $levelUser = Site::Get("Session")->get("levelUser");
        if ($levelUser == 100)
        {
            $feedback = "...en cours...";

        }
        return $feedback;
    }
}