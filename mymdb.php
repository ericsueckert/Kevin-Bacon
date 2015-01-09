<?php
/*
 * Eric Eckert CSE 154 AC
 * Kevin Bacon
 * Beginning page, where user may search movies in which an actor starred, or
 * movies in which an actor starred with Kevin Bacon
 */
include 'common.php';
heading();
?>

<div id="main">
    <h1>The One Degree of Kevin Bacon</h1>
    <p>Type in an actor's name to see if he/she was ever in a movie with Kevin Bacon!</p>
    <p><img src="https://webster.cs.washington.edu/images/kevinbacon/kevin_bacon.jpg" alt="Kevin Bacon" /></p>

    <?php search(); ?>
</div> <!-- end of #main div -->

<?php footing(); ?>
