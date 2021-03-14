<?php


//Pull journal entries and tags from db and list on index page
function get_journal_entries(){
    include ('connection.php');

    try{
        return $db->query("SELECT id, title, date FROM entries
	                         ORDER BY date DESC");
    } catch(Exception $e) {
        echo "Error!: ".$e->getMessage();
        return array();
    }

}

//List journal details and include link to edit entry
function journal_details($journal_id){
    include ('connection.php');

    $sql = 'SELECT * FROM entries WHERE id = ?';

    try{
        $results = $db->prepare($sql);
        $results->bindValue(1,$journal_id,PDO::PARAM_INT);
        $results->execute();
    } catch(Exception $e){
        echo "Error!: ".$e->getMessage();
        return false;
    }

    return $results->fetch();
}

//add or edit journal entries to journal entry page
function add_journal($title, $date, $time_spent, $learned, $resources = null, $tags = null, $journal_id = null){
    include ('connection.php');

    if($journal_id){
        $sql = 'UPDATE entries SET title = ?, date = ?, time_spent = ?, learned = ?, resources = ?, tags = ? WHERE id = ?';
    } else {
        $sql = 'INSERT INTO entries (title, date, time_spent, learned, resources, tags) VALUES (?, ?, ?, ?, ?, ?)';
    }

    try{
        $results = $db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $date, PDO::PARAM_STR);
        $results->bindValue(3, $time_spent, PDO::PARAM_STR);
        $results->bindValue(4, $learned, PDO::PARAM_STR);
        $results->bindValue(5, $resources, PDO::PARAM_STR);
        $results->bindValue(6, $tags, PDO::PARAM_STR);
        if ($journal_id) {
           $results->bindValue(7, $journal_id, PDO::PARAM_INT);
        }
        $results->execute();

    } catch(Exception $e){
        echo "Error!: " .$e->getMessage(). "<br />\n";
        return false;
    }
    return $results->fetch();
}


//delete entries from journal on index page
function delete_entries($journal_id){
    include ('connection.php');

    $sql = 'DELETE FROM entries WHERE id = ?';

    try{
        $results = $db->prepare($sql);
        $results->bindValue(1,$journal_id,PDO::PARAM_INT);
        $results->execute();
    } catch(Exception $e){
        echo "Error!: ".$e->getMessage();
        return false;
    }

    return true;
}



?>
