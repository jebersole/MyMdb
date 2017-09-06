<?php
# verify user's credentials or create a new account
include("common_php.php");
if (!isset($_POST["user_name"]) || !isset($_POST["password"])) {
	header("Location: start.php?fail=true");
	die();
}
$user_name = filter_var($_POST["user_name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_var($_POST["password"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$db = make_db();

if (isset($_POST["new"])) { # new account creation
    $query = "SELECT * FROM users u WHERE u.user_name = ?";
    $rows = get_results($db, $query, $user_name, 0);
    if (!$rows) { # username
        $query = "INSERT INTO users (user_name, password) VALUES (?, ?)";
        $pdb = $db->prepare($query);
        $pdb->execute(array($user_name, $password));
       } else {
        header("Location: newacc.php?fail=true");
    	die();
    }
} else { # normal login
    $query = "SELECT * FROM users u WHERE u.user_name = ? && u.password = ?";
    $rows = get_results($db, $query, $user_name, $password);
    if (!$rows) {
    	header("Location: start.php?fail=true");
    	die();
    }
}

session_start();
$_SESSION["user_name"] = $user_name;
session_write_close();
header("Location: mymdb.php");
?>
