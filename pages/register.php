<?php

if (isset($_POST['register'])) {
    if (account::getByEmail($_POST['email']) !== null) {
        $_SESSION["name"] = $_POST["name"];
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["error"] = "E-mailadres bestaat al.";

        header('Location: ' . ROOT_DIR . 'register');
        exit;
    }

    if ($_POST['password'] !== $_POST['passwordRepeat']) {
        $_SESSION["name"] = $_POST["name"];
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["error"] = "Wachtwoorden komen niet overheen.";

        header('Location: ' . ROOT_DIR . 'register');
        exit;
    }

    $password =  password_hash($_POST["password"], PASSWORD_DEFAULT);
    account::create($_POST["name"], $_POST["email"], $password);

    $_SESSION["accountID"] = (int)getPDO()->lastInsertId();

    header('Location: ' . ROOT_DIR);
    exit;
}

$name = htmlspecialchars($_SESSION["name"] ?? "");
$email = htmlspecialchars($_SESSION["email"] ?? "");

?>

        <form method="POST">
            <header>Register an account</header>

            <?php if (isset($_SESSION["error"])) : ?>
                <p><?= $_SESSION["error"] ?></p>
            <?php endif ?>

            <label>
                <header>Name</header>
                <input type="text" name="name" value="<?= $name ?>">
            </label>

            <label>
                <header>E-mail</header>
                <input type="email" name="email" value="<?= $email ?>">
            </label>

            <label>
                <header>Password</header>
                <input type="password" name="password">
            </label>

            <label>
                <header>Repeat password</header>
                <input type="password" name="passwordRepeat">
            </label>

            <input type="submit" name="register" value="register" />

            <footer><a title="Annuleer registratie" href="<?= ROOT_DIR ?>inloggen">Annuleren</a></footer>
        </form>
    </div>
<?php

unset($_SESSION["name"]);
unset($_SESSION["email"]);
unset($_SESSION["error"]);

?>