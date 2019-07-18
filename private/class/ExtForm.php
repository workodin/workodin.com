<?php

/**
 * 
 */
class ExtForm
{

    /**
     * 
     */
    function runLogout ($txtParam)
    {
        $result = "";
        // on change les doits d'accès
        Site::Get("Session")
        ->set("levelUser",  -1)             // SECURITE: DONNE LES ACCES
        ->set("roleUser",   "logout")       // SECURITE: DONNE LES ACCES
        ;

        // on ne reste pas sur cette page intermédiaire
        // https://www.php.net/manual/fr/function.header.php
        // on redirige le visiteur vers la page de login
        header("Location: /login");

        return $result;
    }

    /**
     * 
     */
    function runInfo ($txtParam)
    {
        $result = "";
        ob_start();
        phpinfo();
        $result = ob_get_clean();
        return $result;
    }

    /**
     * 
     */
    function runPost ($txtParam)
    {
        $result = "";

        $objPDOStatement = Site::Get("Model")->readLine("Post", "uri", $txtParam);
        foreach($objPDOStatement as $tabLine)
        {
            extract($tabLine);

            $result = "</pre>$code<pre>";
        }

        return $result;
    }

    /**
     * 
     */
    function runInscription ($txtParam)
    {
        $result = "";

        $result =  
<<<MONHTML

<form id="form-inscription" action="#form-inscription" method="POST" class="ajax">
    <label for="form-login">login</label>
    <input id="form-login" type="text" name="login" required placeholder="votre login">
    <label for="form-email">email</label>
    <input id="form-email" type="email" name="email" required placeholder="votre email">
    <label for="form-password">mot de passe</label>
    <input id="form-password" type="password" name="password" required placeholder="votre mot de passe">
    <button type="submit">créer votre compte</button>
    <input type="hidden" name="formTag" value="Login">
    <input type="hidden" name="formTagMethod" value="Register">
    <div class="feedback">
    </div>
</form>

MONHTML;


        return "</pre>$result<pre>";
    }

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