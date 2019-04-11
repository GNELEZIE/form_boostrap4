<?php

function insertData($db_table,$db_value,$data_value=array(),$db_inconnu,$db){
    
    
       $inser=$db->prepare("INSERT INTO" .$db_table. "(" .$db_value. ") VALUES(" .$db_inconnu. ")");
       $result=$inser->execute($data_value);
    
    return $result;
       
    
    
}


function delete($db_table,$db){
     $statement = $db->prepare("DELETE FROM ".$db_table." WHERE id = ?");
     $statement->execute(array($id));
}


?>