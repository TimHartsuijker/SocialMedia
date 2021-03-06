<?php

declare(strict_types=1);

// Only run logic if form is sumbitted
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if ($customer = Account::getByEmail($email)) {
        if (password_verify($password, $customer->getPassword())) {
            $_SESSION["accountID"] = $customer->getID();

            header("Location: " . ROOT_DIR);
            exit;
        }
    }

    $_SESSION["error"] = "Het E-mailadres of het wachtwoord is incorrect";
    // Reaching here means the email or password is incorrect

    $_SESSION["email"] = $email;
    $_SESSION["password"] = $password;

    header("Location: " . ROOT_DIR);
    exit;
}

$email = htmlspecialchars($_SESSION["email"] ?? "");

?>

<form method="POST">
    <header>Inloggen</header>

    <?php if (isset($_SESSION["error"])) : ?>
        <p class="error"><?= $_SESSION["error"] ?></p>
    <?php endif ?>

    <label>
        <header>E-mailadres</header>
        <input type="email" name="email" placeholder="E-mailadres" value="<?= $email ?>" autofocus required />
    </label>

    <label>
        <header>Wachtwoord</header>
        <input type="password" name="password" placeholder="Wachtwoord" required />
    </label>

    <input type="submit" name="login" value="Inloggen" />

    <footer>
        <span>Nog geen account?</span>
        <a class="link" href="<?= ROOT_DIR . "registreren" ?>">Maak er eentje aan!</a>
    </footer>
</form>

<?php

unset($_SESSION["error"]);
unset($_SESSION["email"]);
unset($_SESSION["password"]);

?>