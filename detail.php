<?php

include('inc/connection.php');
include('inc/header.php');
include('inc/functions.php');

if(!isset($_GET["id"])){
    $journal_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    $item = get_journal_entries($journal_id);
}



?>

<!DOCTYPE html>
<html>

    <body>

        <section>
            <div class="container">
                <div class="entry-list single">
                    <article>
                        <h1><?php echo $item['title']; ?></h1>
                        <time datetime="<?php echo $item["date"]; ?>">January 31, 2016</time>
                        <div class="entry">
                            <h3>Time Spent: </h3>
                            <p>15 Hours</p>
                        </div>
                        <div class="entry">
                            <h3>What I Learned:</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ut rhoncus felis, vel tincidunt neque.</p>
                            <p>Cras egestas ac ipsum in posuere. Fusce suscipit, libero id malesuada placerat, orci velit semper metus, quis pulvinar sem nunc vel augue. In ornare tempor metus, sit amet congue justo porta et. Etiam pretium, sapien non fermentum consequat, <a href="">dolor augue</a> gravida lacus, non accumsan. Vestibulum ut metus eleifend, malesuada nisl at, scelerisque sapien.</p>
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
                <p><a href="edit.php">Edit Entry</a></p>
            </div>
        </section>

    </body>
    <?php
      include('inc/footer.php');
      ?>
</html>
