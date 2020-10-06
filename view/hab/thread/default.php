<?php

namespace Anax\View;
$commentSum = 0;

?>


<ul>
    <?php foreach ($threads as $thread) : ?>
        <?php foreach($comments as $comment) : ?>
            <?php if ($comment->thread_id === $thread->id) : ?>
                <?php $commentSum += 1 ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <span><?= $commentSum ?></span>
        <?php $commentSum = 0; ?>
        <span><a href="thread/id/<?= $thread->id ?>"><?= $thread->topic ?></a></span>
        <br>
    <?php endforeach; ?>
</ul>