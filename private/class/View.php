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

            // convert code
            // build links
            // https://www.php.net/manual/fr/function.preg-replace.php
            $pattern     = ',(https://[^ ]+),i';
            $replacement = '<a href="${1}" target="_blank" rel="nofollow">${1}</a>';
            $code = preg_replace($pattern, $replacement, $code);

            echo 
<<<HTML

    <article id="$uri">
        <h3><a href="#$uri">$title</a></h3>
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

    /**
     * On peut stocker un menu au format JSON 
     * dans la colonne code de Post
     * 
     * {
     * "index": {"label": "accueil", "href": "/", "class":"hs" },
     * "news": {"label": "news", "href": "/news", "class":"" },
     * "formation": {"label": "formation", "href": "/formation", "class":"" },
     * "emploi": {"label": "emploi", "href": "/emploi", "class":"" },
     * "contact": {"label": "contact", "href": "/contact", "class":"" }
     * }
     * 
     */
    function showMenu ($uri)
    {
        $objModel           = Site::Get("Model");
        $objPDOStatement    = $objModel->readLine("Post", "uri", $uri, "publicationDate");
        foreach($objPDOStatement as $tabLine)
        {
            extract($tabLine);
            // le code doit être au format JSON
            // https://www.php.net/manual/fr/function.json-decode.php
            $tabCode = json_decode($code, true);
            if (!empty($tabCode))
            {
                foreach($tabCode as $item => $tabItem)
                {
                    $class = "";
                    $href  = "";
                    $label = "";
                    $rel   = "";

                    // attention à ne pas écraser d'autres variables existantes
                    extract($tabItem);
                    // $class, $href, $label 
                    echo 
<<<CODEHTML
                    <li class="$class"><a href="$href" rel="$rel">$label</a></li>
CODEHTML;

                }
            }
        }
    }
}