<?php

namespace Anax\View;

// var_dump($user);

?>

<h1>Dashboard</h1>

<p>Välkommen <?= $user->username ?></p>

<p><a href="<?= $this->di->url->create("user/edit") ?>">Redigera din information</a></p>

<p><a href="<?= $this->di->url->create("user/id") . "/" . $user->id ?>">Kolla användarstatistik</a></p>