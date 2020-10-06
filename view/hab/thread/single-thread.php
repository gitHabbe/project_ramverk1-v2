<?php

namespace Anax\View;


// var_dump($this->di->url->create("/thread/point/" . $thread->id));
// die();
?>

<div class="thread">
    <div class="profile">
        <img src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50" alt="User Picture" class="picture">
        <div class="user">USERNAME PLACEHOLDER</div>
        <div class="thread-points">
        <form action="<?= $this->di->url->create("thread/point/" . $thread->id) ?>" method="post">
            <button type="submit" name="thread-vote" value="up">
                <i class="fas fa-arrow-circle-up vote-up"></i>
            </button>
            <span class="points"><?= $thread->points ?></span>
            <button type="submit" name="thread-vote" value="down">
                <i class="fas fa-arrow-circle-down vote-down"></i>
            </button>
        </form>
        </div>
    </div>
    <div class="topic"><?= $thread->topic ?></div>
    <div class="content"><?= $thread->content ?></div>
</div>

<p>TOPIC: <?= $thread->topic ?></p>
<p>POINTS: <?= $thread->points ?></p>

<ul>
    <?php foreach ($comments as $comment) : ?>
        <p>COMMENT: <?= $comment->name ?> POINTS: <?= $comment->points ?></p>
        <p>User: <?= $comment->username ?> Quote: <?= $comment->quote ?></p>
    <?php endforeach; ?>
</ul>

<script>

// document.querySelector(".vote-up").addEventListener("click", changePoints);
// document.querySelector(".vote-down").addEventListener("click", changePoints);

// function changePoints(e) {
//     var points = document.querySelector(".points");
//     var test = e.target.classList.contains("vote-up");
//     if (test) {
//         points.innerHTML = parseInt(points.innerHTML) + 1;
//     } else {
//         points.innerHTML = parseInt(points.innerHTML) - 1;
//     }
// }
</script>