<?php
require 'php/database.php';
 $db = Database::connect();
 $reqCom = $db->prepare('SELECT *FROM commune');
  $reqCom->execute(array());
  $list_commune =$reqCom->fetchAll();




?>