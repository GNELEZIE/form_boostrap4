<?php
    require 'php/database.php';

function delete($db_table,$db){
    
}



 
    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }
   $db_table="users";
    if(!empty($_POST)) 
    {
        $id = checkInput($_POST['id']);
        $db = Database::connect();
        
        
        $statement = $db->prepare("DELETE FROM ".$db_table." WHERE id = ?");
        $statement->execute(array($id));
        
        
        Database::disconnect();
        header("Location: membre_inscrits.php"); 
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>suprimer</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    
    <body>
        <div class="container admin">
            <div class="row">
                <h1><strong>Supprimer une personne</strong></h1>
                <br>
                <form class="form" action="delete.php" role="form" method="post">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <p class="alert alert-danger">Etes vous sur de vouloir supprimer ?</p>
                    <div class="form-actions">
                      <button type="submit" class="btn btn-warning">Oui</button>
                      <a class="btn btn-default" href="membre_inscrits.php">Non</a>
                    </div>
                </form>
            </div>
        </div> 
          <style>
        
        html,body{
			height: 100%;
			margin: 0;
			background: rgb(2,0,36);
            background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(149,199,20,0.5) 0%, rgba(0,212,255,0.3) 96%);
		
		}
                
        
        
        </style> 
        
    </body>
</html>

