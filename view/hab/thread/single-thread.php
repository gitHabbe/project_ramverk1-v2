<?php

namespace Anax\View;


// var_dump($realThread->id);
// var_dump($my_html);
// die();
?>

<div class="thread">
    <div class="profile">
        <img src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50" alt="User Picture" class="picture">
        <div class="user"><?= $thread->username ?></div>
        <div class="thread-points">
            <form action="<?= $this->di->url->create("thread/point/" . $realThread->id) ?>" method="post">
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
    <div class="thread-content">
        <div class="topic"><?= "TITLE: " . $thread->topic ?></div>
        <?php foreach ($tags as $tag) : ?>
            <span><a href="" class="thread-tag"><?= "#" . $tag->name ?></a></span>
        <?php endforeach; ?>
        <div class="content"><?= $my_html ?></div>
    </div>
</div>
<?php if($user["id"]) : ?>
    <form action="<?= $this->di->url->create("comment/new/" . $realThread->id) ?>" method="post">
        <textarea value="" name="comment" cols="30" rows="10">
        </textarea>
        <button type="submit">Post comment</button>
    </form>
<?php endif; ?>
<?php $i = 0; ?>
<?php foreach ($comments2 as $comment) : ?>
    <div class="comment">
        <div class="profile">
            <img src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50" alt="User Picture" class="picture">
            <div class="user"><?= $comments[$i]->username ?></div>
            <div class="comment-points">
            <!-- <div class=""><?= $comment->id ?></div> -->
                <form action="<?= $this->di->url->create("comment/point/" . $comment->id) ?>" method="post">
                    <input style="display:none;" value="<?= $realThread->id ?>" type="text" name="threadid">
                    <button type="submit" name="comment-vote" value="up">
                        <i class="fas fa-arrow-circle-up vote-up"></i>
                    </button>
                    <span class="points"><?= $comment->points ?></span>
                    <button type="submit" name="comment-vote" value="down">
                        <i class="fas fa-arrow-circle-down vote-down"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="content"><?= $comment->name ?></div>
    </div>
    <?php $i += 1; ?>
<?php endforeach; ?>

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