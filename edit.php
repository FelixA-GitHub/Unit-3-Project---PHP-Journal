<?php

include('inc/connection.php');
include('inc/header.php');
include('inc/functions.php');

$title = $date = $time_spent = $learned = $resources = '';

if(isset($_GET["id"])){
    $journal_id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    list($journal_id, $title, $date, $time_spent, $learned, $resources) = journal_details($journal_id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $journal_id = trim(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT));
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_NUMBER_INT));
    $time_spent = trim(filter_input(INPUT_POST, 'time_spent', FILTER_SANITIZE_STRING));
    $learned = trim(filter_input(INPUT_POST, 'learned', FILTER_SANITIZE_STRING));
    $resources = trim(filter_input(INPUT_POST, 'resources', FILTER_SANITIZE_STRING));

    $dateMatch = explode('-', $date);

    if (empty($title) || empty($date) || empty($time_spent) || empty($learned) || empty($resources)) {
        $error_message = "Please fill in the required fields: Title, Date, Time-Spent, What-I-Learned, Resources-To-Remember";
    } elseif (count($dateMatch) != 3
             || strlen($dateMatch[0]) != 4
             || strlen($dateMatch[1]) != 2
             || strlen($dateMatch[2]) != 2
             || !checkdate($dateMatch[2],$dateMatch[1],$dateMatch[0])) {
          $error_message = "Invalid Date";
    } else {
          if (add_journal($journal_id, $title, $date, $time_spent, $learned, $resources)){
              header("Location: detail.php?id=" .$journal_id);
              exit;
           } else {
                 $error_message = "Could not add entry";
           }
    }
}

/*
<select id="title" type="text" name="title">
      <option value=""><?php echo htmlspecialchars($title) ?></option><br>
      <?php
      foreach (get_journal_entries() as $item) {
              echo "<option value='" . $item["id"] . "'>"
                  . $item["title"] . "</option>";
      }
      ?>
</select>
*/

?>

<!DOCTYPE html>
<html>

    <body>

        <section>
            <div class="container">
                <div class="edit-entry">
                    <?php if(isset($error_message)) {
                              echo "<p class='error-msg'>" . $error_message . "</p><br>\n";
                          }
                    ?>
                    <h2>Edit Entry</h2>
                    <form method="post">

                        <label for="title">Title</label>
                        <input id="title" type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" /><br>
                        <label for="date">Date</label>
                        <input id="date" type="date" name="date" value="<?php echo htmlspecialchars($date); ?>" /><br>
                        <label for="time_spent">Time Spent</label>
                        <input id="time_spent" type="text" name="time_spent" value="<?php echo htmlspecialchars($time_spent); ?>" /><br>
                        <label for="learned">What I Learned</label>
                        <textarea id="learned" rows="5" name="learned"><?php echo htmlspecialchars($learned); ?></textarea>
                        <label for="resources">Resources to Remember</label>
                        <textarea id="learned" rows="5" name="learned"><?php echo htmlspecialchars($learned); ?></textarea>

                        <?php
                        if(!empty($journal_id)) {
                            echo "<input type='hidden' name='id' value='" . $journal_id . "' />";
                        }
                        ?>
                        <input type="submit" value="Publish Entry" class="button">
                        <a href="<?php echo 'detail.php?id=' .$journal_id; ?>" class="button button-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </section>

    </body>
    <?php
      include('inc/footer.php');
      ?>
</html>
