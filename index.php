<?php

declare(strict_types=1);

require_once("classes/Account.php");

define("ROOT_DIR", substr($_SERVER["PHP_SELF"], 0, -strlen("index.php")));
define("PUBLIC_DIR", ROOT_DIR . "public/");
session_start();
/** Get PDO instance */
function getPDO(): PDO
{
    static $pdo = new PDO("mysql:host=localhost;dbname=socialmedia", "root", "");

    return $pdo;
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= PUBLIC_DIR ?>css/styles.css" />

    <title>Social Media</title>
</head>

<body>
<?php

// Get the page and split on "/"
$path = explode("/", trim(substr($_SERVER["REDIRECT_URL"], strlen(ROOT_DIR)), "/"));

switch ($path[0]) {
    case "register":
        require("pages/{$path[0]}.php");
        break;

    default:
        if (isset($_SESSION["accountID"])) {
            require("pages/feed.php");
        } else {
            require("pages/login.php");
        }

        break;
}

?>
</body>

</html>