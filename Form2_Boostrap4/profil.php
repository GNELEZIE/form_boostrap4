<?php 

 require 'php/database.php';
 $db = Database::connect();
if(isset($_GET['id']) and $_GET['id']>0){
    
    $getid = intval($_GET['id']);
    $req = $db->prepare('SELECT * FROM users WHERE id= ?');
    $req->execute(array($getid));
    $userinfo = $req->fetch();
   
}





?>


<!DOCTYPE html>

<html>
<head>
<title>Profil</title>    
       <meta name="viewport" content="width=device-width, initial-scale=1">
    
    
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
 
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
           
    
</head>
   <body>
       <div class="container p-100">
       <br><br><br><br>
           <div class="card animated fadeInRight"  style="width: 50em; border:2px solid green;">
        <div class="row">  
           
     
         <div class="col-md-7">
  <div class="card-header">
  Mon profil
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><?php  echo $userinfo['nom'] ;?></li>
    <li class="list-group-item"><?php echo $userinfo['prenom'] ;?></li>
    <li class="list-group-item"><?php echo $userinfo['date'] ;?></li>
    <li class="list-group-item"><?php echo $userinfo['com'] ;?></li>
    </ul>
     </div>
<div class="col-md-5">
    <ul>
    <li class="list-group-item"><img src="<?php echo 'images/'.$userinfo['image'];?>"         style="width:100%"   alt="..."></li>
  </ul>
 </div>
         <button type="button" class=""><a href="membre_inscrits.php">Retour</a></button>
</div>
       
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
