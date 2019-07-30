<?php

/**
 * 
 */
class View
{

    /**
     * 
     */
    function buildCode ($code)
    {
        $result = $code;
        if ($code != "")
        {

            // parcours ligne par ligne
            $tabCode2 = [];
            $tabCode = explode("\n", $code);
            foreach($tabCode as $lineCode)
            {
                // si la ligne commence par @/
                // https://www.php.net/manual/fr/function.mb-strpos.php
                if (mb_strpos($lineCode, "@/") === 0)
                {
                    $lineCode = $this->runCommand($lineCode);

                    if ($lineCode != "")
                    {
                        $tabCode2[] = $lineCode;
                    }
                }
                else
                {
                    $tabPattern = [];
                    $tabReplace = [];

                    // convertir le code
                    // pour ajouter des liens sur les URLs
                    // https://www.php.net/manual/fr/function.preg-replace.php
                    $tabPattern[]     = ',(https://workodin.com/[^\s]+.pro),i';
                    // bircolage: on rajoute @ pour marquer l'url comme non concernée pour le pattern suivant 
                    $tabReplace[] = '<a class="iframe" href="${1}" target="_blank" rel="noopener">@${1}</a>';

                    $tabPattern[]     = ',[^"@](https://[^\s]+),i';
                    $tabReplace[] = '<a href="${1}" target="_blank" rel="noopener">${1}</a>';

                    $lineCode    = preg_replace($tabPattern, $tabReplace, $lineCode);
                    $tabCode2[]  = $lineCode;
                }
            }
            // on reconstruit le code
            $result = implode("\n", $tabCode2);
        }

        return $result;
    }

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

            // on construit le code
            $code = $this->buildCode($code);

            $codeLength = round(0.001 * mb_strlen($code));

            echo 
<<<HTML

    <article id="$uri" class="l$codeLength">
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
     * 
     */
    function runCommand ($lineCode)
    {
        $result = "";

        $tabCommand     = explode("/", trim($lineCode));
        $commandClass   = $tabCommand[1] ?? "";
        $commandMethod  = $tabCommand[2] ?? "";
        $commandParam   = $tabCommand[3] ?? "";
        if (!empty($commandClass) && !empty($commandMethod))
        {
            // conventon du framework
            // les commandes sont des methodes de classes
            // exemple:
            // ExtForm::runContact
            // sera activée avec la ligne
            // @/form/contact/

            // https://www.php.net/manual/en/function.ucfirst.php
            $commandClass   = "Ext" . ucfirst($commandClass);
            $commandMethod  = "run" . ucfirst($commandMethod);
            if (method_exists($commandClass, $commandMethod))
            {
                $result = Site::Get($commandClass)->$commandMethod($commandParam);                
            }
        }
        else 
        {
            // $result = "debug/$commandClass/$commandMethod/$commandParam";
        }
        return $result;
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