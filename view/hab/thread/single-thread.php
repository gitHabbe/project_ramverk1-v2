<?php

namespace Anax\View;

function getGravatar($user) {
    if ($user->gravatar === null || $user->gravatar === "") {
        return "https://www.gravatar.com/avatar/00000000000000000000000000000000";
    }
    return $user->gravatar;
}

// $total = 0;
$total = $thread->points;
foreach ($comments ?? [] as $comment) {
    $total += $comment->points;    
}


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
        <div class="topic"><?= "TITLE: " . $thread->topic ?> (<?= $total ?>p)</div>
        <?php foreach ($tags as $tag) : ?>
            <span><a href="" class="thread-tag"><?= "#" . $tag->name ?></a></span>
        <?php endforeach; ?>
        <div class="content"><?= $my_html ?></div>
    </div>
</div>

<?php if($user->id) : ?>
    <div class="post-form">
        <form action="<?= $this->di->url->create("comment/new/" . $realThread->id) ?>" method="post">
            <span>Reply to comment #</span>
            <input style="display:none;" value="<?= count($comments) ?>" type="text" name="commentsLen">
            <input type="text" placeholder="Ex: #4" name="replyTo">
            <span>Comment</span>
            <textarea value="" name="comment" cols="30" rows="10"></textarea>
                <button type="submit" class="button orange">Post comment</button>
        </form>
    </div>
<?php endif; ?>
<div>
    <form action="<?= $this->di->url->create("thread/id/" . $realThread->id) ?>" method="get">
        <span>Sort comment by: </span>
        <select name="sort" id="comment-sort" onchange="this.form.submit()">
            <option value=""></option>
            <option value="date">Date</option>
            <option value="points">Points</option>
        </select>
    </form>
</div>

<?php $i = 0; ?>
<?php foreach ($comments2 as $comment) : ?>
    <?php $isAnswer = $answer->comment_id == $comment->id ? " isAnswer" : ""; ?>
    <div class="comment<?= $isAnswer ?>">
        <div class="profile">
            <a href="<?= $this->di->url->create("user/id/" . $comments[$i]->user_id) ?>">
                <img src="<?= getGravatar($comments[$i]) ?>" alt="User Picture" class="picture">
                <div class="user"><?= $comments[$i]->username ?></div>
            </a>
            <?php if ($answer->id === null && $sessionUser["id"] === $thread->user_id) : ?>
                <div class="comment-answerBtn">
                    <form action="<?= $this->di->url->create("comment/answer/") ?>" method="post">
                        <input style="display:none;" value="<?= $realThread->id ?>" type="text" name="threadid">
                        <input style="display:none;" value="<?= $comment->id ?>" type="text" name="commentid">
                        <button type="submit" name="comment-vote" value="up">
                            <i class="fas fa-check-square mark-answer"></i>
                        </button>
                    </form>
                </div>
            <?php endif; ?>
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
        <div class="content">
            <?php if ($answer->comment_id == $comment->id) : ?>
                <span>ANSWER</span>
            <?php endif; ?>
            <div>
                <a href="#<?= $comment->num ?>">
                    <span id="<?= $comment->num ?>">#<?= $comment->num ?></span>
                </a>
                <?php if ($comment->reply_num) : ?>
                    <span>This is a reply to comment -><a href="#<?= $comment->reply_num ?>">#<?= $comment->reply_num ?></a></span>
                <?php endif; ?>
            </div>
            <?= $comment->name ?>
        </div>
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