<?php

namespace Anax\View;

?>

<h1>Edit user data</h1>

<form action="user/edit" method="post">
    <label for="password">Password</label>
    <input type="password" name="password">
    <label for="quote">Quote</label>
    <input type="text" name="quote" value=<?= $user->quote ?>>
    <label for="gravitar">Gravitar</label>
    <input type="text" name="gravitar" value="<?= $user->gravitar ?>">
    <button type="submit">Submit changes</button>
</form>

<?= $user->quote ?>