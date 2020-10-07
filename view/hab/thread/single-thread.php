<?php

namespace Anax\View;


// var_dump($thread);
// die();
?>

<div class="thread">
    <div class="profile">
        <img src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50" alt="User Picture" class="picture">
        <div class="user"><?= $thread->username ?></div>
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

<?php foreach ($comments as $comment) : ?>
    <div class="comment">
        <div class="profile">
            <img src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50" alt="User Picture" class="picture">
            <div class="user"><?= $comment->username ?></div>
            <div class="comment-points">
                <form action="<?= $this->di->url->create("comment/point/" . $comment->id) ?>" method="post">
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