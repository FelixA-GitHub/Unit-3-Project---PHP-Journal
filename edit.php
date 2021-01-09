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
    $journal_id = trim(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING));
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $time_spent = trim(filter_input(INPUT_POST, 'time-spent', FILTER_SANITIZE_STRING));
    $learned = trim(filter_input(INPUT_POST, 'what-i-learned', FILTER_SANITIZE_STRING));
    $resources = trim(filter_input(INPUT_POST, 'resources-to-remember', FILTER_SANITIZE_STRING));

    if (empty($title) || empty($date) || empty($time_spent) || empty($learned) || empty($resources)) {
        $error_message = 'Please fill in the required fields: Title, Date, Time-Spent, What-I-Learned, Resources-To-Remember';
    } else {
          if (add_journal($journal_id, $title, $date, $time_spent, $learned, $resources)){
              header("Location: detail.php?id=" . $journal_id);
              exit;
              } else {
                    $error_message = 'Could not add entry';
                }
       }
}


?>

<!DOCTYPE html>
<html>

    <body>

        <section>
            <div class="container">
                <div class="edit-entry">
                    <h2>Edit Entry</h2>
                    <form method="post">

                        <label for="title">Title<span class="select">*</span></label>
                        <input id="title" type="text" name="title" value="<?php echo htmlspecialchars($title) ?>" /><br>
                        <label for="date">Date<span class="required">*</span></label>
                        <input id="date" type="date" name="date" value="<?php echo htmlspecialchars($date) ?>" /><br>
                        <label for="time-spent">Time Spent<span class="required">*</span></label>
                        <input id="time-spent" type="text" name="timeSpent" value="<?php echo htmlspecialchars($time_spent) ?>" /><br>
                        <label for="what-i-learned">What I Learned<span class="required">*</span></label>
                        <textarea id="what-i-learned" rows="5" name="whatILearned" value="<?php echo htmlspecialchars($learned) ?>"></textarea>
                        <label for="resources-to-remember">Resources to Remember<span class="required">*</span></label>
                        <textarea id="resources-to-remember" rows="5" name="ResourcesToRemember" value"<?php echo htmlspecialchars($resources) ?>"></textarea>
                        <input type="submit" value="Publish Entry" class="button">
                        <a href="<?php echo 'detail.php?=' .$journal_id; ?>" class="button button-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </section>

    </body>
    <?php
      include('inc/footer.php');
      ?>
</html>
