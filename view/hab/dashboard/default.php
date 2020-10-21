<?php

namespace Anax\View;

// var_dump($user);
var_dump($user);

?>

<h1>Dashboard</h1>

<p>Welcome <?= $user->username ?></p>

<p><a href="<?= $this->di->url->create("user/edit") ?>">Edit your information</a></p>
