<?php

namespace Anax\View;

// var_dump($threads);

?>

<h1>Användarinformation</h1>

<p>Profilsida för användare: <b><?= $user->username ?></b></p>

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