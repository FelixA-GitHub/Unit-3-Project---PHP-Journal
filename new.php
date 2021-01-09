<?php

include('inc/connection.php');
require('inc/functions.php');

$pageTitle = "New Entry";
$page = "Add_New_Entries";

$title = $date = $time_spent = $learned = $resources = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $time_spent = trim(filter_input(INPUT_POST, 'time-spent', FILTER_SANITIZE_STRING));
    $learned = trim(filter_input(INPUT_POST, 'what-i-learned', FILTER_SANITIZE_STRING));
    $resources = trim(filter_input(INPUT_POST, 'resources-to-remember', FILTER_SANITIZE_STRING));

    if (empty($title) || empty($date) || empty($time_spent) || empty($learned) || empty($resources)) {
        $error_message = 'Please fill in the required fields: Title, Date, Time-Spent, What-I-Learned, Resources-To-Remember';
    } else {
          if (add_journal($title, $date, $time_spent, $learned, $resources)){
              header("Location: index.php");
              exit;
              } else {
                    $error_message = 'Could not add entry';
                }
       }
}

include('inc/header.php');
?>

<!DOCTYPE html>
<html>

    <body>
        <section>
            <div class="container">
                <div class="new-entry">
                    <h2>New Entry</h2>
                    <?php
                    if (isset($error_message)) {
                        echo "<p class='message'>$error_message</p>";
                    }
                    ?>
                    <form method="post">

                        <label for="title">Title<span class="required">*</span></label>
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
