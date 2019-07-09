<?php

/**
 * 
 */
class View
{
    /**
      * 
     */
    function showPost ($filterColumn, $filterValue, $sortColumn)
    {
        $objModel           = Site::Get("Model");
        $objPDOStatement    = $objModel->readLine("Post", $filterColumn, $filterValue, $sortColumn);
        
        // mise en buffer de l'affichage
        // https://www.php.net/manual/fr/function.ob-start.php
        ob_start();
        foreach($objPDOStatement as $tabLine)
        {
            // SECURITE: protection contre les attaques XSS
            // https://www.php.net/manual/fr/function.array-map.php
            array_map("htmlspecialchars", $tabLine);
            extract($tabLine);
        
            $htmlMedia = "";
            if ($urlMedia != "")
            {
                $baseDir = Site::Get("baseDir");
                if (is_file("$baseDir/public/$urlMedia"))
                {
                    $htmlMedia = 
<<<CODEHTML
<div>
    <img src="/$urlMedia" alt="$urlMedia" title="$urlMedia">
</div>
CODEHTML;
                }
            }
            echo 
<<<HTML

    <article>
        <h3>$title</h3>
        <div class="content"><pre class="post">$code</pre></div>
        $htmlMedia
    </article>

HTML;

        }
        
        // fin du buffer
        // https://www.php.net/manual/fr/function.ob-get-clean.php
        $htmlPost = ob_get_clean();
        
        echo $htmlPost;
        
    }
}