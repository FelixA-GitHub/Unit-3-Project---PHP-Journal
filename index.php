<?php

include('inc/connection.php');
include('inc/header.php');
require('inc/functions.php');



?>

<!DOCTYPE html>
<html>

    <body>
          <section>
              <div class="container">
                  <div class="entry-list">
                      <ul class="items">
                          <?php
                          foreach (get_journal_entries() as $item) {
                              echo "<li>" . $item['title'] . $item['date'] . "</li>";
                          }
                          ?>
                      </ul>
                      <article>
                          <h2><a href="detail.php">The best day I’ve ever had</a></h2>
                          <time datetime="2016-01-31">January 31, 2016</time>
                      </article>
                      <article>
                          <h2><a href="edit.php">The absolute worst day I’ve ever had</a></h2>
                          <time datetime="2016-01-31">January 31, 2016</time>
                      </article>
                      <article>
                          <h2><a href="detail_3.php">That time at the mall</a></h2>
                          <time datetime="2016-01-31">January 31, 2016</time>
                      </article>
                      <article>
                          <h2><a href="detail_4.php">Dude, where’s my car?</a></h2>
                          <time datetime="2016-01-31">January 31, 2016</time>
                      </article>
                  </div>
              </div>

          </section>
    </body>
  <?php
    include('inc/footer.php');
    ?>
</html>