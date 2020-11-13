<?php

namespace Anax\View;
$commentSum = 0;
// var_dump($threads);
?>

<h4>Trådar</h4>

<p><a href="<?= $this->di->url->create("thread/new") ?>">Skapa ny tråd</a></p>

<?php foreach ($threads as $thread) : ?>
    <div class="thread-item">
        <?php foreach($comments as $comment) : ?>
            <?php if ($comment->thread_id === $thread->id) : ?>
                <?php $commentSum += 1 ?>
            <?php endif; ?>
        <?php endforeach; ?>
        
        <span><i class="fas fa-award"></i><?= $thread->rank ?></span>
        <span><i class="fas fa-comments"></i><?= $commentSum ?></span>
        <span><a href="<?= $this->di->url->create("thread/id/$thread->id") ?>"><?= $thread->topic ?></a></span>
        <?php if ($thread->answer->id != null) : ?>
            <i class="fas fa-check-square" style="color:green"></i>
        <?php endif; ?>
        <br>
        <?php $commentSum = 0; ?>
    </div>
<?php endforeach; ?>