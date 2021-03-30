<?php

include('inc/connection.php');
include('inc/header.php');
include('inc/functions.php');


if(isset($_GET["id"])){
    $journal_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    list($title) = journal_details($journal_id);
}

//foreach(get_entries_for_tag($je["id"]) as $entry) {
//    echo "<p><a href='detail.php?id=" . $tag["tag_id"] . "'>" . $entry["title"] . "</p></li>";
//}

?>

<!DOCTYPE html>
<html>

    <body>

        <section>
            <div class="container">
                <div class="entry-list single">
                    <article>
                        <h1><?php
                              //echo $title["title"];
                              foreach(get_journal_entries() as $je){
                                    echo "<article>";
                                    echo "<h2><a href='detail.php?id=" . $je["id"] . "'>" . $je["title"] . "</a></h2>";
                                    foreach(get_entries_for_tag($je["id"]) as $entry) {
                                        echo "<p><a href='detail.php?id=" . $tag["tag_id"] . "'>" . $entry["title"] . "</p></li>";
                                    }
                                    echo "<form method='post' action='index.php'>";
                                    echo "</form>";
                                    echo "</article>";
                              }
                            ?>
                        </h1>

                    </article>
                </div>
            </div>
            <div class="edit">
                <?php
                echo "<p><a href='edit.php?id=" . $title["id"] . "'>Edit Tag</a></p>";
                ?>
            </div>
        </section>

    </body>
    <?php
      include('inc/footer.php');
      ?>
</html>
