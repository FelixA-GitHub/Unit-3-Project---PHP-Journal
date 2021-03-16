<?php

include('inc/connection.php');
include('inc/header.php');
include('inc/functions.php');

//error_reporting(E_ALL ^ E_WARNING);

if (isset($_POST['delete'])) {
    if (delete_entries(filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT))) {
        header ("Location: index.php?msg=Entries+Deleted");
        exit;
    } else {
        header ("Location: index.php?msg=Unable+To+Delete+Entries");
        exit;
    }
}

if (isset($_POST['delete'])) {
    if (delete_tags(filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT))) {
        header ("Location: index.php?msg=Tags+Deleted");
        exit;
    } else {
        header ("Location: index.php?msg=Unable+To+Delete+Tags");
        exit;
    }
}

if (isset($_GET['msg'])) {
    $error_message = trim(filter_input(INPUT_GET, 'msg', FILTER_SANITIZE_STRING));
}

?>

<!DOCTYPE html>
<html>

    <body>
          <section>
              <div class="container">
                  <div class="entry-list">
                  <?php if(isset($error_message)) {
                            echo "<p class='error-msg'>" .$error_message. "</p><br>\n";
                  }
                  ?>
                          <?php
                           foreach(get_journal_entries() as $item){
                                echo "<article>";
                                echo "<h2><a href='detail.php?id=" . $item["id"] . "'>" . $item["title"] . "</a></h2>";
                                echo "<time datetime=" . $item["date"] . ">" . date('F d, Y', strtotime($item["date"])) . "</time>";
                                echo "<form method='post' action='index.php'>";
                                echo "<input type='hidden' value='" . $item["id"] . "' name='delete' />\n";
                                echo "<input type='submit' class='button delete journal entry' value='Delete' />\n";
                                echo "</form>";
                                echo "</article>";
                            }
                            foreach(get_tag_list() as $item){
                                 echo "<article>";
                                 echo "<h2><a href='detail.php?id=" . $item["tag_id"] . "'>" . $item["tags"] . "</a></h2>";
                                 echo "<form method='post' action='index.php'>";
                                 echo "<input type='hidden' value='" . $item["tag_id"] . "' name='delete' />\n";
                                 echo "<input type='submit' class='button delete journal entry' value='Delete' />\n";
                                 echo "</form>";
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
