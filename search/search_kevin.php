<?php
# search for films which contain given actor and Kevin Bacon
include($_SERVER['DOCUMENT_ROOT'].'/mymdb/header.php');
include($_SERVER['DOCUMENT_ROOT'].'/mymdb/common.php');
include($_SERVER['DOCUMENT_ROOT'].'/mymdb/user/common_session.php');

if (isset($_GET["firstname"]) && isset($_GET["lastname"])) {
    $db = make_db();
    $firstname = prep($_GET["firstname"]);
    $lastname = prep($_GET["lastname"]);
    if ($firstname == "Kevin" && $lastname == "Bacon") {
        echo "Kevin Bacon is in all his own films. How about searching for someone else?";
        include($_SERVER['DOCUMENT_ROOT'].'/mymdb/search/search_forms.php');
        die();
    }
    $bakid = get_id($db, 'kevin', 'bacon');
    $id = get_id($db, $firstname, $lastname);
    # more than one film by the same name means a match
    $query = "SELECT m.name, m.year, m.id FROM movies m JOIN roles r ON
        r.movie_id = m.id JOIN actors a ON a.id = r.actor_id WHERE a.id = ? || a.id = ?
        GROUP BY 1 HAVING count(*) > 1";
    if ($id) $rows = get_results($db, $query, $bakid, $id);
    if ($rows) { # results present for entered actor
        include($_SERVER['DOCUMENT_ROOT'].'/mymdb/search/common_search.php');
    } else { ?>
         <div>
         <h3>Sorry, no results for <?=$firstname . " $lastname"?> and Kevin Bacon.</h3>
        </div> <?

    }
} ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="/mymdb/js/mymdb.js"></script>
<script>
    var cap = $('caption');
    if (cap.length) {
        var text = cap.html();
        text += " and Kevin Bacon";
        $('caption').html(text);
    }
</script>
<? include($_SERVER['DOCUMENT_ROOT'].'/mymdb/search/search_forms.php'); ?>
