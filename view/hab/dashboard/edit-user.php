<?php

namespace Anax\View;

// var_dump($user);

?>

<h1>Edit user data</h1>

<form action="<?= $this->di->url->create("user/edit/") ?>" method="post">
    <label for="password">Password</label>
    <input type="password" name="password"><br>
    <label for="quote">Quote</label>
    <input value="<?= $user->quote ?>" type="text" name="quote" value=<?= $user->quote ?>><br>
    <label for="gravatar">Gravatar</label>
    <input value="<?= $user->gravatar ?>" type="text" name="gravatar" value="<?= $user->gravatar ?>"><br>
    <button type="submit">Submit changes</button>
</form>
