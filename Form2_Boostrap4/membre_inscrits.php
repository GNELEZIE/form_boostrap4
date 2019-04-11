<?php
include'php/database.php';
 $db = Database::connect();

?>
<!DOCTYPE html>

<html>
<head>
<title>membres</title>    
       <meta name="viewport" content="width=device-width, initial-scale=1">
    
    
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
 
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
           
    
</head>
    <body>
       <div class="container">
           
           <div class="card">
  <div class="card-header"  style="background:purple; color:#fff; font-size:32px;">
    La liste des inscrits sur notre site
  </div>
  <div class="card-body">
    <blockquote class="blockquote mb-0">
 <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">№ </th>
      <th scope="col">Nom</th> 
      <th scope="col">prenom</th>
      <th scope="col">date de naissance</th>
      <th scope="col">commune</th>
      <th scope="col">Sexe</th>
      <th scope="col">Voir profil</th>
    </tr>
  </thead>
  <tbody>
      <?php
      $db_table="users";
      $membre=$db->query('SELECT * FROM '.$db_table);
      
      foreach($membre as $membre):
      
      ?>
      
      
    <tr>
      <th scope="row"><?php echo $membre['id'];?></th>
      <td><?php echo $membre['nom'];?></td>
      <td><?php echo $membre['prenom'];?></td>
      <td><?php echo $membre['date'];?></td>
         <td><?php echo $membre['sexe'];?></td>
      <td><?php echo $membre['com'];?></td>
     
<td><a class="btn btn-primary" href="profil.php?id=<?php echo $membre['id'];?>"><span><i class="far fa-eye"></i></span></a></td>
        
<td><a class="btn btn-success"  href="update.php?id=<?php echo $membre['id'];?>"> <i class="fas fa-pencil-alt"></i></a></td>  
        
    <td><a class="btn btn-danger"  href="delete.php?id=<?php echo $membre['id'];?>"><span><i class="fas fa-trash-alt"></i></span></a></td>      
    </tr>
    <?php endforeach ?>
  </tbody>
</table>  
           <footer class="blockquote-footer"><a href="index.php">Retour</a> <cite title="Source Title"></cite></footer>
    </blockquote>
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