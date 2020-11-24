<?php

namespace Anax\View;


?>

<h1>Logga in!</h1>

<?php if (isset($error)) : ?>
    <p><?= $error ?></p>
<?php endif; ?>
<div class="login-form">
    <form action="login" method="post">
        <label for="username">Användarnamn</label>
        <input type="text" name="username">
        <label for="password">Lösenord</label>
        <input type="password" name="password">
        <button type="submit" class="button green">Logga in</button>
    </form>
</div>

<p>Har du inte ett konto? Klicka <a href="<?= $this->di->url->create("user/signup") ?>">här</a> för att registrera dig.</p>