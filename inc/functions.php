<?php


//Pull journal entries and list on index page
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

//Pull tag entries and list on index page
function get_tag_list(){
    include ('connection.php');

    try{
        return $db->query("SELECT tag_id, tags FROM tag_list
	                         ORDER BY tag_id");
    } catch(Exception $e) {
        echo "Error!: ".$e->getMessage();
        return array();
    }

}

//Pull intersected entries and list on index page
function get_intersect_list(){
    include ('connection.php');

    try{
        return $db->query("SELECT e.id, e.title, e.date, tl.tag_id FROM entries e
                           INNER JOIN results r ON e.id = r.id
                           INNER JOIN tag_list tl ON r.tag_id = tl.tag_id
                           GROUP BY tl.tag_id");
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

//List tag details and include link to edit entry
function tag_details($tag_id){
    include ('connection.php');

    $sql = 'SELECT * FROM tag_list WHERE tag_id = ?';

    try{
        $results = $db->prepare($sql);
        $results->bindValue(1,$tag_id,PDO::PARAM_INT);
        $results->execute();
    } catch(Exception $e){
        echo "Error!: ".$e->getMessage();
        return false;
    }

    return $results->fetch();
}

//add or edit journal entries to journal entry page
function add_journal($title, $date, $time_spent, $learned, $resources = null, $journal_id = null){
    include ('connection.php');

    if($journal_id){
        $sql = 'UPDATE entries SET title = ?, date = ?, time_spent = ?, learned = ?, resources = ? WHERE id = ?';
    } else {
        $sql = 'INSERT INTO entries (title, date, time_spent, learned, resources) VALUES (?, ?, ?, ?, ?)';
    }

    try{
        $results = $db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $date, PDO::PARAM_STR);
        $results->bindValue(3, $time_spent, PDO::PARAM_STR);
        $results->bindValue(4, $learned, PDO::PARAM_STR);
        $results->bindValue(5, $resources, PDO::PARAM_STR);
        if ($journal_id) {
           $results->bindValue(6, $journal_id, PDO::PARAM_INT);
        }
        $results->execute();

    } catch(Exception $e){
        echo "Error!: " .$e->getMessage(). "<br />\n";
        return false;
    }
    return $results->fetch();
}

//add or edit tag entries to journal entry page
function add_tags($tags, $tag_id = null){
    include ('connection.php');

    if($tag_id){
        $sql = 'UPDATE tag_list SET tags = ? WHERE tag_id = ?';
    } else {
        $sql = 'INSERT INTO tag_list (tags) VALUES (?)';
    }

    try{
        $results = $db->prepare($sql);
        $results->bindValue(1, $tags, PDO::PARAM_STR);
        if ($tag_id) {
           $results->bindValue(2, $tag_id, PDO::PARAM_INT);
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

//delete tags from journal on index page
function delete_tags($tag_id){
    include ('connection.php');

    $sql = 'DELETE FROM tag_list WHERE tag_id = ?';

    try{
        $results = $db->prepare($sql);
        $results->bindValue(1,$tag_id,PDO::PARAM_INT);
        $results->execute();
    } catch(Exception $e){
        echo "Error!: ".$e->getMessage();
        return false;
    }

    return true;
}



?>
