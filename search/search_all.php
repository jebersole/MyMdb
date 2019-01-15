<?php
# get a list of all films with a given actor
include($_SERVER['DOCUMENT_ROOT'].'/mymdb/header.php');
include($_SERVER['DOCUMENT_ROOT'].'/mymdb/common.php');
include($_SERVER['DOCUMENT_ROOT'].'/mymdb/user/common_session.php');

if (isset($_GET["firstname"]) && isset($_GET["lastname"])) {
    $db = make_db();
    $firstname = prep($_GET["firstname"]);
    $lastname = prep($_GET["lastname"]);
    $query = "SELECT m.name, m.year, m.id FROM movies m JOIN roles r ON
        r.movie_id = m.id JOIN actors a ON a.id = r.actor_id WHERE a.first_name = ? &&
        a.last_name = ? ORDER BY m.year DESC";
    $rows = get_results($db, $query, $firstname, $lastname);
    if ($rows) {
        include($_SERVER['DOCUMENT_ROOT'].'/mymdb/search/common_search.php');
    } else { ?>
    <div>
        <h3>Sorry, no results for <?=$firstname . " $lastname."?></h3>
    </div> <?
    }
} ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="/mymdb/js/mymdb.js"></script>
<?php include($_SERVER['DOCUMENT_ROOT'].'/mymdb/search/search_forms.php'); ?>
