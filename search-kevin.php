<?php
# search for films which contain given actor and Kevin Bacon
include("common.php");
include("common_php.php");
include("common_session.php");

if (isset($_GET["firstname"]) && isset($_GET["lastname"])) {
    $db = make_db();
    $firstname = prep($_GET["firstname"]);
    $lastname = prep($_GET["lastname"]);
    if ($firstname == "Kevin" && $lastname == "Bacon") {
        echo "Kevin Bacon is in all his own films. How about searching for someone else?";
        include("common2.php");
        die();
    }
    $bakid = get_id($db, 'kevin', 'bacon');
    $id = get_id($db, $firstname, $lastname);
    # more than one film by the same name means a match
    $query = "SELECT m.name, ANY_VALUE(m.year), ANY_VALUE(m.id) FROM movies m JOIN roles r ON
        r.movie_id = m.id JOIN actors a ON a.id = r.actor_id WHERE a.id = ? || a.id = ?
        GROUP BY 1 HAVING count(*) > 1";
    if ($id) { # results present for entered actor
        $rows = get_results($db, $query, $bakid, $id);
        if (count($rows) > 0) {
            include("common_search.php");
        }
    } else { ?>
         <div>
         <h3>Sorry, no results for <?=$firstname . " $lastname"?> and Kevin Bacon.</h3>
        </div>
<?php
    }  ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="mymdb.js"></script>
<?php
}
include("common2.php"); ?>
