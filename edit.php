<?php

include('inc/connection.php');
include('inc/header.php');
include('inc/functions.php');

//error_reporting(E_ALL ^ E_WARNING);

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

    if (empty($title) || empty($date) || empty($time_spent) || empty($learned)) {
        $error_message = "Please fill in the required fields: Title, Date, Time-Spent, What-I-Learned";
    } else {
          add_journal($title, $date, $time_spent, $learned, $resources, $journal_id);
          header("Location: index.php?id=" .$journal_id);
    }
    $error_message = "Could not add entry";
}

?>

<!DOCTYPE html>
<html>

    <body>

        <section>
            <div class="container">
                <div class="edit-entry">
                    <?php
                    if(isset($error_message)) {
                          echo "<p class='error-msg'>" . $error_message . "</p><br>\n";
                    }
                    ?>
                    <h2>Edit Entry</h2>
                    <form method="POST">

                        <label for="title">Title</label>
                        <input id="title" type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" /><br>
                        <label for="date">Date</label>
                        <input id="date" type="date" name="date" value="<?php echo htmlspecialchars($date); ?>" /><br>
                        <label for="time_spent">Time Spent</label>
                        <input id="time_spent" type="text" name="time_spent" value="<?php echo htmlspecialchars($time_spent); ?>" /><br>
                        <label for="learned">What I Learned</label>
                        <textarea id="learned" rows="5" name="learned"><?php echo htmlspecialchars($learned); ?></textarea>
                        <label for="resources">Resources to Remember</label>
                        <textarea id="resources" rows="5" name="resources"><?php echo htmlspecialchars($resources); ?></textarea>
                        <label for="tags">Tags</label>
                        <input id="tags" type="text" name="tags" value="<?php echo htmlspecialchars($tags); ?>" /><br>

                        <?php
                        if(!empty($journal_id)) {
                            echo "<input type='hidden' name='id' value='" . $journal_id . "' />";
                        } 
                        ?>
                        <input type="submit" value="Publish Entry" class="button">
                        <a href="<?php echo 'index.php'; ?>" class="button button-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </section>

    </body>
    <?php
      include('inc/footer.php');
      ?>
</html>
