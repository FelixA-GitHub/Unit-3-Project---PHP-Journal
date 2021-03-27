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

//Pull end_result entries and list on index page
function get_end_result_list(){
    include ('connection.php');

    try{
        return $db->query("SELECT id, tag_id FROM end_result
	                         ORDER BY id");
    } catch(Exception $e) {
        echo "Error!: ".$e->getMessage();
        return array();
    }

}

// get all tags for an entry
function get_tags_for_entry($id) {
    include("connection.php");
    try {
      $results = $db->prepare(
          "SELECT * FROM tag_list
          JOIN end_result ON tag_list.tag_id = end_result.tag_id
          JOIN entries ON end_result.id = entries.id
          WHERE entries.id = ?
          GROUP BY tag_list.tags"
      );
      $results->bindParam(1,$id,PDO::PARAM_INT);
      $results->execute();
    } catch (Exception $e) {
      echo "bad query";
      echo $e->getMessage();
    }
    $tags = $results->fetchAll(PDO::FETCH_ASSOC);
    return $tags;
  }

//Pull intersected entries and list on index page
function get_intersect_list(){
    include ('connection.php');

    try{
       return $db->query("SELECT er.id, tl.tags FROM end_result er
                          INNER JOIN tag_list tl ON tl.tag_id = er.tag_id
                          INNER JOIN entries e ON e.id = er.id
                          GROUP BY er.tag_id");
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
function tag_details($tag_dets){
    include ('connection.php');

    $sql = 'SELECT * FROM tag_list WHERE tag_id = ?';

    try{
        $results = $db->prepare($sql);
        $results->bindValue(1,$tag_dets,PDO::PARAM_INT);
        $results->execute();
    } catch(Exception $e){
        echo "Error!: ".$e->getMessage();
        return false;
    }

    return $results->fetch();
}

//List end_result details and include link to edit entry
function end_result_details($end_result){
    include ('connection.php');

    $sql = 'SELECT * FROM end_result WHERE id = ?';

    try{
        $results = $db->prepare($sql);
        $results->bindValue(1,$end_result,PDO::PARAM_INT);
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
function add_tags($tags, $tag_dets = null){
    include ('connection.php');

    if($tag_id){
        $sql = 'UPDATE tag_list SET tags = ? WHERE tag_id = ?';
    } else {
        $sql = 'INSERT INTO tag_list (tags) VALUES (?)';
    }

    try{
        $results = $db->prepare($sql);
        $results->bindValue(1, $tags, PDO::PARAM_STR);
        if ($tag_dets) {
           $results->bindValue(2, $tag_dets, PDO::PARAM_INT);
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
function delete_tags($tag_dets){
    include ('connection.php');

    $sql = 'DELETE FROM tag_list WHERE tag_id = ?';

    try{
        $results = $db->prepare($sql);
        $results->bindValue(1,$tag_dets,PDO::PARAM_INT);
        $results->execute();
    } catch(Exception $e){
        echo "Error!: ".$e->getMessage();
        return false;
    }

    return true;
}



?>
