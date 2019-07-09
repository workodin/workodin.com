<section>
    <div class="postMain">
        <h2><?php echo $title ?></h2>
<pre class="post">
<?php echo $code ?? "" ?>
</pre>
    </div>

    <div class="listPost row">
<?php Site::Get("View")->showPost("category", $pageUri, "publicationDate") ?>
    </div>
</section>