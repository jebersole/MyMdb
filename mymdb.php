<?php
# front page after logging in
include("common.php");
include("common_php.php");
include("common_session.php");
?>

    <h1>The One Degree of Kevin Bacon</h1>
    <p>Type in an actor's name to see if he/she was ever in a movie with Kevin Bacon!</p>
    <p><img src="kevin_bacon.jpg" alt="Kevin Bacon" style="height: 300px"/></p>

<?php if(isset($_GET["fail"])) { ?>
    <p style="color: red;">Please enter only letters.</p>
<?php } include("common2.php"); ?>
