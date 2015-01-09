<?php
/*
 * Eric Eckert CSE 154 AC
 * Kevin Bacon
 * Contains common code and methods
 */

//Writes the head and upper banner for each page
function heading() {
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>My Movie Database (MyMDb)</title>
            <meta charset="utf-8" />
            <link href="https://webster.cs.washington.edu/images/kevinbacon/favicon.png" type="image/png" rel="shortcut icon" />

            <!-- Link to your CSS file that you should edit -->
            <link href="bacon.css" type="text/css" rel="stylesheet" />
        </head>
        <body>
            <div id="frame">
                <div id="banner">
                    <a href="mymdb.php"><img src="https://webster.cs.washington.edu/images/kevinbacon/mymdb.png" alt="banner logo" /></a>
                    My Movie Database
                </div>
                <?php
            }

            //Writes the footer for each page
            function footing() {
                ?>
                <div id="w3c">
                    <a href="https://webster.cs.washington.edu/validate-html.php"><img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML5" /></a>
                    <a href="https://webster.cs.washington.edu/validate-css.php"><img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
                </div>
            </div> <!-- end of #frame div -->
        </body>

    </html>
    <?php
}

//writes the search fields
function search() {
    ?>
    <!-- form to search for every movie by a given actor -->
    <form action="search-all.php" method="get">
        <fieldset>
            <legend>All movies</legend>
            <div>
                <input name="firstname" type="text" size="12" placeholder="first name" autofocus="autofocus" /> 
                <input name="lastname" type="text" size="12" placeholder="last name" /> 
                <input type="submit" value="go" />
            </div>
        </fieldset>
    </form>

    <!-- form to search for movies where a given actor was with Kevin Bacon -->
    <form action="search-kevin.php" method="get">
        <fieldset>
            <legend>Movies with Kevin Bacon</legend>
            <div>
                <input name="firstname" type="text" size="12" placeholder="first name" /> 
                <input name="lastname" type="text" size="12" placeholder="last name" /> 
                <input type="submit" value="go" />
            </div>
        </fieldset>
    </form>
    <?php
}

//Searches databse for movies in which the actor with the passed in name has 
//starred in
function searchMovies($firstName, $lastName, $db) {
    $firstName = $db->quote($firstName);
    $lastName = $db->quote($lastName);
    $rows = $db->query("SELECT m.name, m.year, a.first_name, a.last_name
        FROM actors a
        JOIN roles r ON r.actor_id = a.id
        JOIN movies m ON m.id = r.movie_id
        WHERE a.last_name = $lastName AND a.first_name = $firstName
        ORDER BY m.year DESC"
    );
    return $rows;
}

//Searches database for actors with the same last name, and first name as passed
//in name
function searchLikeNames($firstName, $lastName, $db) {
    $firstName = $firstName . "%";
    $firstName = $db->quote($firstName);
    $lastName = $db->quote($lastName);
    $sameName = $db->query("SELECT first_name, last_name, id, film_count
        FROM actors 
        WHERE first_name LIKE $firstName AND last_name = $lastName
        ORDER BY film_count DESC
        LIMIT 1");
    return $sameName;
}

//Searches database for movies in which the actor with the passed in name has
//starred with Kevin Bacon
function searchKevin($firstName, $lastName, $db) {
    $firstName = $db->quote($firstName);
    $lastName = $db->quote($lastName);
    $rows = $db->query("SELECT m.name, m.year, a.first_name, a.last_name
        FROM actors a
        JOIN roles r ON r.actor_id = a.id
        JOIN movies m ON m.id = r.movie_id
        JOIN roles k ON k.movie_id = m.id
        JOIN actors b ON b.id = k.actor_id
        WHERE a.last_name = $lastName AND a.first_name = $firstName AND b.last_name = 'Bacon' AND b.first_name = 'Kevin'
        ORDER BY m.year DESC"
    );
    return $rows;
}

//Writes the html table given the query results
function writeTable($rows) {
    ?>
    <table id="center">
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Year</th>
        </tr>
        <?php
        $i = 1;
        foreach ($rows as $row) {
            ?>

            <tr>
                <td><?= $i ?></td>
                <td><?= $row["name"] ?></td>
                <td><?= $row["year"] ?></td>
            </tr>

            <?php
            $i++;
        }
        ?>
    </table>
    <?php
}

function returnName($firstName, $lastName, $db) {
    $sameName = searchLikeNames($firstName, $lastName, $db);
    foreach ($sameName as $row) {
        $rows = searchKevin($row["first_name"], $lastName, $db);
    }
    return $rows;
}
?>

