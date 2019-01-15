<?php
# search query should be only latin alphabet, and is then capitalized
function prep($string) {
    $string = filter_var($string, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (!preg_match("/^[A-Za-z]+$/", $string)) {
        header("Location:".baseUrl()."mymdb.php?fail=true");
        die();
    }
    $string = strtolower($string);
    $string = ucfirst($string);
    return $string;
}

# query db and return results given 0 or more parameters
function get_results($db, $query, $var1, $var2) {
    $pdb = $db->prepare($query);
    if ($var1 == null && $var2 == null) {
        $pdb->execute();
    } else if ($var1 == null && $var2 != null) {
        $pdb->execute(array($var2));
    } else if ($var2 == null && $var1 != null) {
        $pdb->execute(array($var1));
    } else {
        $pdb->execute(array($var1, $var2));
    }
    $rows = $pdb->fetchAll();
    return $rows;
}

# find actor id
function get_id($db, $firstname, $lastname) {
    $query = "SELECT a.id FROM actors a WHERE a.first_name = ? && a.last_name = ?";
    $rows = get_results($db, $query, $firstname, $lastname);
    return $rows ? $rows[0][0] : 0;
}

# check user is logged in
function init_session() {
    session_start();
    if (!isset($_SESSION["user_name"])) {
        header("Location:".baseUrl()."start.php?fail=true");
        die();
    }
    $user_name = $_SESSION["user_name"];
    session_write_close();
    return $user_name;
}

# init db object
function make_db() {
    $db = new PDO("mysql:dbname=mymdb;host=somehost", "username", "password",
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

# get user's wish list
function get_wished($db, $user_name) {
    $query = "SELECT movie_id FROM wish_list w JOIN users u ON u.user_id = w.user_id WHERE u.user_name = ?";
    $rows = get_results($db, $query, $user_name, null);
    if ($rows) { # entries exist in wish_list
        $query = "SELECT m.id, m.name, m.year FROM movies m WHERE m.id IN (";
        $query .= $rows[0][0];
        for ($i = 1; $i < count($rows); $i++) {
            $query .= ',' . $rows[$i][0];
        }
        $query .= ")";
        $rows = get_results($db, $query, null, null);
    }
    return $rows;
}

function baseUrl() {
  return sprintf( "%s://%s%s", isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ?
    'https' : 'http', $_SERVER['SERVER_NAME'], '/mymdb/');
}
?>
