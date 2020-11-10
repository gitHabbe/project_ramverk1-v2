<?php

namespace Anax\View;
$commentSum = 0;
// var_dump($threads);
?>


<ul>
    <?php foreach ($threads as $thread) : ?>
        <?php foreach($comments as $comment) : ?>
            <?php if ($comment->thread_id === $thread->id) : ?>
                <?php $commentSum += 1 ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <span><i class="fas fa-award"></i><?= $thread->rank ?></span>
        <span><i class="fas fa-comments"></i><?= $commentSum ?></span>
        <span><a href="thread/id/<?= $thread->id ?>"><?= $thread->topic ?></a></span>
        <?php if ($thread->answer->id != null) : ?>
            <i class="fas fa-check-square" style="color:green"></i>
        <?php endif; ?>
        <br>
        <?php $commentSum = 0; ?>
    <?php endforeach; ?>
</ul>