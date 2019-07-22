<?php

// require_once("$viewDir/part/header.php");
// require_once("$viewDir/part/section-post.php");
// require_once("$viewDir/part/footer.php");

$tabBuild = $this->loadTabFile([
                "private/template/part/header.php",
                "private/template/part/section-post.php",
                "private/template/part/footer.php",
            ]);
            
foreach($tabBuild as $build)
{
    require_once($build);
}            