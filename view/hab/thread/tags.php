<?php

namespace Anax\View;

// var_dump($tags);

?>


<ul>
    <?php foreach ($tags ?? [] as $tag) : ?>
        <li><a href="<?= $this->di->url->create("thread/tagid/" . $tag->id) ?>"><?= $tag->name ?></a></li>
    <?php endforeach; ?>
</ul>