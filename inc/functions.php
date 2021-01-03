<?php

//add or edit journal entries to journal entry page
function add_journal($title, $date, $time_spent, $learned, $resources, $journal_id = null){
    include "inc/connection.php";

    if($journal_id){
        $sql = "UPDATE entries SET title = ?, date = ?, time_spent = ?, learned = ?, resources = ? WHERE id = ?";
    } else {
        $sql = "INSERT INTO entries(title,date,time_spent,learned,resources) VALUES(?,?,?,?,?)";
    }

    try{
        $results = $db->prepare($sql);
        $results->bindValue(1,$title,PDO::PARAM_STR);
        $results->bindValue(2,$date,PDO::PARAM_STR);
        $results->bindValue(3,$time_spent,PDO::PARAM_STR);
        $results->bindValue(4,$learned,PDO::PARAM_STR);
        $results->bindValue(5,$resources,PDO::PARAM_STR);
        $results->execute();

    } catch(Exception $e){
        echo "Error!: " .$e->getMessage(). "<br />\n";
        return false;
    }
    return $results->fetch();
}


//list journal entries and include link to add entry
function get_journal_entries(){
    include "inc/connection.php";

    try{
        return $db->query("SELECT id, title, date FROM entries ORDER BY date DESC");
    } catch(Exception $e) {
        echo "Error!: ".$e->getMessage()."</br>";
        return array();
    }

}


//Show journal details and include link to edit entry
function journal_details($journal_id){
    include "inc/connection.php";

    $sql = "SELECT * FROM entries WHERE id = ?";

    try{
        $results = $db->prepare($sql);
        $results->bindValue(1,$journal_id,PDO::PARAM_INT);
        $results->execute();
    } catch(Exception $e){
        echo "Error!: ".$e->getMessage(). "<br />n"; //check on this /br
        return false;
    }

    return $results->fetch();
}

//delete entries from journal
function delete_entries($journal_id){
    include "inc/connection.php";

    $sql = "DELETE * FROM entries WHERE id = ?";

    try{
        $results = $db->prepare($sql);
        $results->bindValue(1,$journal_id,PDO::PARAM_INT);
        $results->execute();
    } catch(Exception $e){
        echo "Error!: ".$e->getMessage(). "<br />n"; //check on this /br
        return false;
    }

    return true;
}



?>
