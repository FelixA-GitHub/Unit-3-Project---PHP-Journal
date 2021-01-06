<?php

include('inc/connection.php');
require('inc/functions.php');

$pageTitle = "New Entry";
$page = "Journal_Entries";

//$title = $date = $time_spent = $learned = $resources;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_INT));
    $time_spent = trim(filter_input(INPUT_POST, 'time-spent', FILTER_SANITIZE_STRING));
    $learned = trim(filter_input(INPUT_POST, 'what-i-learned', FILTER_SANITIZE_STRING));
    $resources = trim(filter_input(INPUT_POST, 'resources-to-remember', FILTER_SANITIZE_STRING));

    if (empty($title) || empty($date) || empty($time_spent) || empty($learned) || empty($resources)) {
        $error_message = 'Please fill in the required fields: Title, Date, Time-Spent, What-I-Learned, Resources-To-Remember';
    } else {
          if (add_journal($title, $date, $time_spent, $learned, $resources)){
              header ('Location: index.php');
              exit;
          /*echo "title = $title<br />";
          echo "date = $date<br />";
          echo "time-spent = $time_spent<br />";
          echo "what-i-learned = $learned<br />";
          echo "resources-to-remember = $resources<br />";*/
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
                    <form>
                        <label for="title"> Title</label>
                        <input id="title" type="text" name="title"><br>
                        <label for="date">Date</label>
                        <input id="date" type="date" name="date"><br>
                        <label for="time-spent"> Time Spent</label>
                        <input id="time-spent" type="text" name="timeSpent"><br>
                        <label for="what-i-learned">What I Learned</label>
                        <textarea id="what-i-learned" rows="5" name="whatILearned"></textarea>
                        <label for="resources-to-remember">Resources to Remember</label>
                        <textarea id="resources-to-remember" rows="5" name="ResourcesToRemember"></textarea>
                        <input type="submit" value="Publish Entry" class="button">
                        <a href="#" class="button button-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </section>
     </body>
     <?php
      include('inc/footer.php');
      ?>
</html>
