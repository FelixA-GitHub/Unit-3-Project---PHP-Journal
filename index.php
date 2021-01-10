<?php

include('inc/connection.php');
include('inc/header.php');
include('inc/functions.php');



?>

<!DOCTYPE html>
<html>

    <body>
          <section>
              <div class="container">
                  <div class="entry-list">

                          <?php
                           foreach(get_journal_entries() as $item){
                                echo "<article>";
                                echo "<h2><a href='detail.php?id=" . $item["id"] . "'>" . $item["title"] . "</a></h2>";
                                echo "<time datetime=" . $item["date"] . ">" . date('F d, Y', strtotime($item["date"])); . "</time>";
                                echo "</article>";
                            }
                          ?>
                  </div>
              </div>

          </section>
    </body>
  <?php
    include('inc/footer.php');
    ?>
</html>
