<?php

namespace Anax\View;

// var_dump($tag);

?>
<h3>Trådar med taggen: <b><?= $tag->name ?></b></h3>

<p>Här kan du finna alla trådar som finns under taggen <?= $tag->name ?>.</p>
<p>Klicka på en tråd för att navigera till frågan och läsa diskussionen</p>
<br>

<ul class="thread-tag-list">
    <?php foreach ($threads ?? [] as $thread) : ?>
        <li><a href="<?= $this->di->url->create("thread/id/" . $thread->id) ?>"><?= $thread->topic ?></a></li>
    <?php endforeach; ?>
</ul>