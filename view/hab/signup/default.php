<?php

namespace Anax\View;

?>
<?php if (isset($error)) : ?>
    <p><?= $error ?></p>
<?php endif; ?>

<h4>Registrera dig!</h4>

<div class="login-form">
    <form action="signup" method="POST">
        <label for="username">Användarnamn</label>
        <input type="text" name="username">
        <label for="password1">Lösenord</label>
        <input type="password" name="password1">
        <label for="password2">Lösenord igen</label>
        <input type="password" name="password2">
        <button type="submit" class="button orange">Registrera</button>
    </form>
</div>