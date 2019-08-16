<section>
    <div class="postMain">
        <h2><?php echo $title ?></h2>
<pre class="post">
<?php echo Site::Get("View")->buildCode($code ?? "") ?>
</pre>
    </div>

    <div class="listPost row">
<?php Site::Get("View")->showPost("category", $pageUri, [ "priority DESC", "publicationDate DESC"  ]) ?>
    </div>
</section>