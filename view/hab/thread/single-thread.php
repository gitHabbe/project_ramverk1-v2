<?php

namespace Anax\View;

?>

<p>TOPIC: <?= $thread->topic ?></p>
<p>POINTS: <?= $thread->points ?></p>

<ul>
    <?php foreach ($comments as $comment) : ?>
        <p><?= $comment->name ?></p>
    <?php endforeach; ?>
</ul>