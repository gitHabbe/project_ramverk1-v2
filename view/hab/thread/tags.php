<?php

namespace Anax\View;

// var_dump($tags);

?>

<h3>Taggar</h3>

<p>Här kan du finna alla taggar som finns på hemsidan.</p>
<p>Klicka på en tag för att hitta alla trådar under just det ämnet.</p>
<br>


<ul class="tag-list">
    <?php foreach ($tags ?? [] as $tag) : ?>
        <li><a href="<?= $this->di->url->create("thread/tagid/" . $tag->id) ?>"><?= $tag->name ?></a></li>
    <?php endforeach; ?>
</ul>