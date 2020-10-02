<?php

namespace Anax\View;

?>

<ul>
    <?php foreach ($threads as $thread) : ?>
        <p><a href="thread/id/<?= $thread->id ?>"><?= $thread->topic ?></a></p>
    <?php endforeach; ?>
</ul>