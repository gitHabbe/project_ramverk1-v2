<?php

namespace Anax\View;

function getGravatar($user) {
    if ($user->gravatar === null || $user->gravatar === "") {
        return "https://www.gravatar.com/avatar/00000000000000000000000000000000";
    }
    return $user->gravatar;
}

// var_dump($answer);

$isAnswer = $answer->id != null ? "isAnswer" : "";

?>

<div class="thread">
    <div class="profile">
        <img src="<?= getGravatar($user) ?>" alt="User Picture" class="picture">
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
<?php if($user->id) : ?>
    <form action="<?= $this->di->url->create("comment/new/" . $realThread->id) ?>" method="post">
        <input style="display:none;" value="<?= count($comments) ?>" type="text" name="commentsLen">
        <input type="text" placeholder="Ex: #4" name="replyTo">
        <textarea value="" name="comment" cols="30" rows="10">
        </textarea>
        <button type="submit">Post comment</button>
    </form>
<?php endif; ?>
<?php $i = 0; ?>
<?php foreach ($comments2 as $comment) : ?>
    <div class="comment <?= $isAnswer ?>">
        <?php if ($answer->comment_id == $comment->id) : ?>
            <div>ANSWER</div>
        <?php endif; ?>
        <div class="profile">
            <a href="<?= $this->di->url->create("user/id/" . $comments[$i]->user_id) ?>">
                <img src="<?= getGravatar($comments[$i]) ?>" alt="User Picture" class="picture">
                <div class="user"><?= $comments[$i]->username ?></div>
            </a>
                <form action="<?= $this->di->url->create("comment/answer/") ?>" method="post">
                    <input style="display:none;" value="<?= $realThread->id ?>" type="text" name="threadid">
                    <input style="display:none;" value="<?= $comment->id ?>" type="text" name="commentid">
                    <?php if ($answer->id === null) : ?>
                        <button type="submit" name="comment-vote" value="up">
                            <i class="fas fa-check-square"></i>
                        </button>
                    <?php endif; ?>
                </form>
            <div class="comment-points">
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
        <div>
            <a href="#<?= $i + 1 ?>">
                <span id="<?= $i + 1 ?>">#<?= $i + 1 ?></span>
            </a>
            <?php if ($comment->reply_num) : ?>
                <span>This is a reply to comment -><a href="#<?= $comment->reply_num ?>">#<?= $comment->reply_num ?></a></span>
            <?php endif; ?>
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