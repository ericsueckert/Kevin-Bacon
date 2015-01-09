<?php
/*
 * Eric Eckert CSE 154 AC
 * Kevin Bacon
 * Searches movies in which actor starred with Kevin Bacon
 */

include 'common.php';
$firstName = $_GET["firstname"];
$lastName = $_GET["lastname"];
$db = new PDO("mysql:dbname=imdb;host=localhost;charset=utf8", "eric95", "NpMcq7pLTj");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$rows = searchKevin($firstName, $lastName, $db);

if ($rows->rowCount() === 0) {
    $rows = returnName($firstName, $lastName, $db);
}

heading();
?>
<div id="main">
    <h1>Results For <?= $firstName . " " . $lastName ?></h1>
    <p>Films with <?= $firstName . " " . $lastName ?> and Kevin Bacon</p>
    <!-- put table here -->
    <?php
    if (!($rows->rowCount() === 0)) {
        writeTable($rows);
    } else {
        ?>
        <p><?= $firstName . " " . $lastName ?> was not in any films with Kevin Bacon.</p>

    <?php
    }
    search();
    ?>
</div> <!-- end of #main div -->
<?php footing(); ?>