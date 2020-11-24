<?php

namespace Anax\View;

$p2uTotal = 0;
foreach ($p2u ?? [] as $point) {
    $p2uTotal += intval($point->amount);
}

function getGravatarr($user) {
    if ($user->gravatar === null || $user->gravatar === "") {
        return "https://www.gravatar.com/avatar/00000000000000000000000000000000";
    }
    return $user->gravatar;
}

// var_dump($user);

?>

<h1>Användarinformation</h1>

<p>Profilsida för användare: <b><?= $user->username ?></b></p>

<p>Rykte: <?= $p2uTotal ?>!</p>

<img src="<?= getGravatarr($user) ?>" alt="User Picture" class="picture">

<?php if (strlen($user->quote) > 0) : ?>
    <h6>Citat: "<?= $user->quote ?>"</h6>
<?php endif; ?>

<p>Ryktet är baserat på skapade trådar och kommenterar.</p>
<p>Man får även poäng genom att rösta och ge korrekt svar.</p>

<h4>Trådar skapade av <?= $user->username ?></h4>

<ol class="user-threads">
<?php foreach ($threads ?? [] as $thread) : ?>
    <li>
        <a href="<?= $this->di->url->create("thread/id/" . $thread[0]->id) ?>">
            <?php if ($thread[1]->id) : ?>
                <i class="fas fa-check-square" style="color:green"></i>
            <?php endif; ?>
            <?= $thread[0]->topic ?>
        </a>
    </li>
<?php endforeach; ?>
</ol>

<h4>Kommentarer av <?= $user->username ?></h4>

<ol class="user-comments">
<?php foreach ($comments ?? [] as $comment) : ?>
    <li>
        <a href="<?= $this->di->url->create("thread/id/" . $comment->thread_id) ?>">
            <?= filter_var(strlen($comment->name) > 70 ? substr($comment->name, 0, 70) . "..." : $comment->name, FILTER_SANITIZE_STRING); ?>
        </a>
    </li>
<?php endforeach; ?>
</ol>

<h4>Röster</h4>

<ul>
    <li>Antal kommentar-röster: <?= count($p2c) ?></li>
    <li>Antal tråd-röster: <?= count($p2t) ?></li>
</ul>