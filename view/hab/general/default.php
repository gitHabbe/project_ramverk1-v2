<?php

namespace Anax\View;

// var_dump($topTags);
// var_dump($topUsers);
// var_dump($latesThreads);

?>

<h1>Välkommen till forumet om The Boys!</h1>

<h4>Översikt av senaste trådar</h4>

<ul>
<?php foreach (array_slice($latestThreads, 0, 5) ?? [] as $thread) : ?>
    <li>(<?= $thread->points ?>p) <a href="<?= $this->di->url->create("thread/id/" . $thread->id) ?>"><?= $thread->topic ?></a></li>
<?php endforeach; ?>
</ul>


<h4>Översikt av mest populära användare</h4>
<ul>
<?php foreach (array_slice($topUsers, 0, 5) ?? [] as $user) : ?>
    <li>(<?= $user[1] ?>p) <a href="<?= $this->di->url->create("user/id/" . $user[0]->id) ?>"><?= $user[0]->username ?></a></li>
<?php endforeach; ?>
</ul>

<h4>Oversikt av mest använda taggar</h4>
<ul>
<?php foreach (array_slice($topTags, 0, 5) ?? [] as $tag) : ?>
    <li>(<?= $tag[1] ?>) <a href="<?= $this->di->url->create("thread/tagid/" . $tag[0]->id) ?>"><?= $tag[0]->name ?></a></li>
<?php endforeach; ?>
</ul>
