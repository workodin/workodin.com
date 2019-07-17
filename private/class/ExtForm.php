<?php

/**
 * 
 */
class ExtForm
{
    /**
     * 
     */
    function runNewsletter ($txtParam)
    {
        $result = "";

        $result = 
<<<CODEHTML

<form>
        <input type="text" name="name">
        <button type="submit">inscription</button>
</form>

CODEHTML;

        return "</pre>$result<pre>";
    }
}