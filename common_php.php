<?php
# search query should be only latin alphabet, and is then capitalized
function prep($string) {
    $string = filter_var($string, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (!preg_match("/^[A-Za-z]+$/", $string)) {
        header("Location: mymdb.php?fail=true");
        die();
    }
    $string = strtolower($string);
    $string = ucfirst($string);
    return $string;
}

# get actor by id
function checknames($db, $id) {
    $query = "SELECT a.first_name, a.last_name FROM actors a WHERE a.id = ?";
    $names = get_results($db, $query, $id, 0);
    $firstname = $names['first_name'];
    $lastname = $names['last_name'];
    return array($firstname, $lastname);
}

# query db and return results given 1 or more parameters
function get_results($db, $query, $var1, $var2) {
    $pdb = $db->prepare($query);
    if ($var2 !== 0) {
        $pdb->execute(array($var1, $var2));
    } else {
        $pdb->execute(array($var1));
    }
    $rows = $pdb->fetchAll();
    return $rows;
}

# find actor id
function get_id($db, $firstname, $lastname) {
    $query = "SELECT a.id FROM actors a WHERE a.first_name LIKE '$firstname%' && a.last_name = '$lastname'";
    $actors = get_results($db, $query, $firstname, $lastname);
    $acount = array();
    foreach ($actors as $actor) {
        $query = "SELECT m.year FROM movies m JOIN roles r ON r.movie_id = m.id JOIN actors a ON
        a.id = r.actor_id WHERE a.id = ?;";
        $acount[$actor['id']] = count(get_results($db, $query, $actor['id'], 0));
    }
    $count = 0;
    $max = 0;
    $selected = 0;
    foreach ($acount as $key => $value) {
        if ($value > $count) {
            $max = $value;
            $count = $max;
            $selected = $key;
        }
    }
    return $selected = ($selected > 0 ? $selected : 0);
}

# check user is logged in
function init_session() {
    session_start();
    if (!isset($_SESSION["user_name"])) {
        header("Location: start.php?fail=true");
        die();
    }
    $user_name = $_SESSION["user_name"];
    session_write_close();
    return $user_name;
}

# init db object
function make_db() {
    $db = new PDO("mysql:dbname=imdb", "root", "zz123456",
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

# get user's wish list
function get_wished($db, $user_name) {
    $query = "SELECT wish_list FROM users u WHERE u.user_name = ?";
    $wished_rows = get_results($db, $query, $user_name, 0);
    return $wished_rows;
}

# check if film entries in search results are also in wish list
function check_wished($wished, $row) {
    $wished = preg_split('/,(?={)/', $wished[0][0]);
    for ($i = 0; $i < count($wished); $i++) {
        $wish = json_decode($wished[$i], true);
        if ($wish['id'] == $row[2]) {
            array_splice($wished, $i, 1);
            return true;
        }
    }
    return false;
}
?>
