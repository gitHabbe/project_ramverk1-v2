<?php

namespace Anax\View;

?>


<ul>
    <?php foreach ($threads ?? [] as $thread) : ?>
        <li><a href="<?= $this->di->url->create("thread/id/" . $thread->id) ?>"><?= $thread->topic ?></a></li>
    <?php endforeach; ?>
</ul>