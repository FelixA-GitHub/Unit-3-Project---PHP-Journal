<?php

include('inc/connection.php');
require('inc/functions.php');


$title = $date = $time_spent = $learned = $resources = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_NUMBER_INT));
    $time_spent = trim(filter_input(INPUT_POST, 'time_spent', FILTER_SANITIZE_STRING));
    $learned = trim(filter_input(INPUT_POST, 'learned', FILTER_SANITIZE_STRING));
    $resources = trim(filter_input(INPUT_POST, 'resources', FILTER_SANITIZE_STRING));

    $dateMatch = explode('-',$date);

    if (empty($title) || empty($date) || empty($time_spent) || empty($learned) || empty($resources)) {
        $error_message = 'Please fill in the required fields: Title, Date, Time-Spent, What-I-Learned, Resources-To-Remember';
    } elseif (count($dateMatch) != 3
             || strlen($dateMatch[0]) != 4
             || strlen($dateMatch[1]) != 2
             || strlen($dateMatch[2]) != 2
             || !checkdate($dateMatch[2],$dateMatch[1],$dateMatch[0])) {
          $error_message = 'Invalid Date';

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
                        echo "<p class='error_message'>" . $error_message . "</p>";
                    }
                    ?>
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
