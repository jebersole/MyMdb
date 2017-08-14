<?php
# get a list of all films with a given actor
include("common.php");
include("common_php.php");
include("common_session.php");

if (isset($_GET["firstname"]) && isset($_GET["lastname"])) {
    $db = make_db();
    $firstname = prep($_GET["firstname"]);
    $lastname = prep($_GET["lastname"]);
    $query = "SELECT m.name, ANY_VALUE(m.year), ANY_VALUE(m.id) FROM movies m JOIN roles r ON
        r.movie_id = m.id JOIN actors a ON a.id = r.actor_id WHERE a.first_name = ? &&
        a.last_name = ? ORDER BY m.year DESC;";
    $rows = get_results($db, $query, $firstname, $lastname);
    if (count($rows) > 0) {
        include("common_search.php");
} else { ?>
    <div>
    <h3>Sorry, no results for <?=$firstname . " $lastname."?></h3>
    </div>
<?php  }  ?>

<?php
} ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="mymdb.js"></script>
<?php include("common2.php"); ?>
