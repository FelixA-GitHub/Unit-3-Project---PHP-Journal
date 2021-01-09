<?php

include('inc/connection.php');
include('inc/header.php');
include('inc/functions.php');


if(isset($_GET["id"])){
    $journal_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    $item = journal_details($journal_id);
}



?>

<!DOCTYPE html>
<html>

    <body>

        <section>
            <div class="container">
                <div class="entry-list single">
                    <article>
                        <h1><?php echo $item["title"]; ?></h1>
                        <time datetime="<?php echo $item["date"]; ?>"><?php echo date('F d, Y', strtotime($item["date"])); ?></time>
                        <div class="entry">
                            <h3>Time Spent: </h3>
                            <p><?php echo $item["time_spent"]; ?></p>
                        </div>
                        <div class="entry">
                            <h3>What I Learned:</h3>
                            <p><?php echo $item["learned"]; ?></p>
                        </div>
                        <div class="entry">
                            <h3>Resources to Remember:</h3>
                            <ul>
                                <li><a href="">Lorem ipsum dolor sit amet</a></li>
                                <li><a href="">Cras accumsan cursus ante, non dapibus tempor</a></li>
                                <li><a href="">Nunc ut rhoncus felis, vel tincidunt neque</a></li>
                                <li><a href="">Ipsum dolor sit amet</a></li>
                            </ul>
                        </div>
                    </article>
                </div>
            </div>
            <div class="edit">
                <p><a href="<?php echo 'edit.php'; ?>">Edit Entry</a></p>
            </div>
        </section>

    </body>
    <?php
      include('inc/footer.php');
      ?>
</html>
