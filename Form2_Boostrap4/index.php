<?php 
session_start();

 require 'php/database.php';
 $db = Database::connect();
include'php/function.php';
// SQL code
//     SELECT * FROM users INNER JOIN commune ON users.commune = commune.id;

//Jointure entre la table users et commune
 //  SELECT(u.id AS id.nom,u.prenom AS prenom,c.nam AS commune FROM users AS u, AS c

//          WHERE u.commune=c.id)

 // equivalence
//   SELECT u.*,c.nom AS name FROM users AS u, AS c    WHERE u.commune=c.id
  //   
//
//

  

//  $reqCom = $db->prepare('SELECT *FROM commune WHERE visibility=1');
  $reqCom = $db->prepare('SELECT *FROM commune WHERE visibility=1');


  $reqCom->execute(array());
  $list_commune =$reqCom->fetchAll();


if(isset($_POST['forminscription'])){
    
   if(!empty($_POST['nom']) and !empty($_POST['date']) and !empty($_POST['com'])){
       
      $nom = checkInput($_POST['nom']);
      $prenom = checkInput($_POST['prenom']);
      $date = checkInput($_POST['date']);
      $com = checkInput($_POST['com']);
	 $sexe = checkInput($_POST['radio']);
	 $image = checkInput($_FILES['image']['name']);
//     $imagUpload= $_FILES['image']['tmp_name'];
//      move_uploaded_file($imag$Upload,'images');
	 $imagePath          = 'images/'. basename($image);
	 $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
//     $image = checkInput($_FILES["image"]["name"]);
//    $imagePath = 'images/'. basename($image);
//        $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
        $reqnom= $db->prepare('SELECT *FROM users WHERE nom=?');
        $reqnom->execute(array($nom));
           $pseudexist = $reqnom->rowCount();
           if($pseudexist ==0){ 
      
    $db_table="users";
    $db_value="nom,prenom,date,sexe,com,image";
    $db_inconnu="?,?,?,?,?,?";
    $data_value= array($nom,$prenom,$date,$com,$sexe,$image);
               
               
//         insertData($db_table,$db_value,$db_inconnu,$data_value,$db);      
            
               
            $isUploadSuccess = true;
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) 
            {
                $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
                $isUploadSuccess = false;
            }
            if(file_exists($imagePath)) 
            {
                $imageError = "Le fichier existe deja";
                $isUploadSuccess = false;
            }
            if($_FILES["image"]["size"] > 500000) 
            {
                $imageError = "Le fichier ne doit pas depasser les 500KB";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess) 
            {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) 
                {
                    $imageError = "Il y a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                } 
            } 
        
        
            
               
         if($isUploadSuccess){ 
               

     $reqes= $db->prepare('INSERT INTO '.$db_table.'('.$db_value.') VALUES('.$db_inconnu.')');
     $result=$reqes->execute($data_value);
               
               if($result){
                   $_SESSION['success']=true;
                   
               }else{
                  $_SESSION['error']=true;
               }
           
           }
       }    
       
   }else{
        $_SESSION['error2']=true;
   }  
     
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
<title>Inscrition</title>    
       <meta name="viewport" content="width=device-width, initial-scale=1">
    
    
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
 
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
           
    
</head>
    <body>
        

        
        
        
    <script>

        
        
        
    </script>
        
        
        
        
        
        
    <div align="center">
        
        
        	<div class=" p-100">
	      <div class="d-flex justify-content-center">

		<div class="card mt-5 col-md-4 animated animated rotateIn myForm">
			<div class="card-header">
				<h4>FORMULAIRE INSCRIPTION</h4>
			</div>
			<div class="card-body">
				<form method="POST" enctype="multipart/form-data">
                    
                    <?php 
                    if(isset($_SESSION['success'])):?>
                        
                        <div class="alert alert-success">Votre compte a été crée avec success!!!!!<a href="membre_inscrits.php">Voir la liste</a></div>; 
                    <?php unset($_SESSION['success'])?>   
                    <?php endif ?>
                    
                    <?php 
                    if(isset($_SESSION['error2'])):?>
                        
                        <div class="alert alert-danger">Tous les champ doivent être remplir !!!</div>; 
                    <?php unset($_SESSION['error2'])?>   
                    <?php endif ?>
                    
                    
                    
                    
                   <?php if(isset($_SESSION['error'])):?>
                    
                   <div class="alert alert-danger">Donnée non envoyé!!!!!!!!</div>;
                    <?php unset($_SESSION['error'])?>
                    <?php endif ?>
                    

                    
       
					<div id="dynamic_container">
						<div class="input-group">
                            
							<div class="input-group-prepend">
								<span class="input-group-text br-15"><i class="fas fa-user-graduate"></i></span>
							</div>
							<input type="text"  name="nom" id="nom" placeholder="nom" class="form-control"/>
						</div>
                        
                        
                         <div class="input-group mt-3">
							<div class="input-group-prepend">
								<span class="input-group-text br-15"><i class="fas fa-user-graduate"></i></span>
							</div>
							<input type="text" name="prenom" id="prenom" placeholder=" prenom" class="form-control"/>
						</div>
                        
                        <div class="input-group mt-3">
							<div class="input-group-prepend">
								<span class="input-group-text br-15"><i class="fas fa-calendar-alt"></i></span>
							</div>
							<input type="date" name="date" id="date" placeholder=" date de naissance" class="form-control"/>
						</div>
                        <div class="input-group mt-3">
							<div class="input-group-prepend">
								<span class="input-group-text br-15">HOMME</span>
							</div>
							<input type="radio" value="HOMME" name="radio" id="radio" class="form-control"/>
<!--
						</div>
                        <div class="input-group mt-3">
-->
							<div class="input-group-prepend">
								<span class="input-group-text br-15">FEMME</span>
							</div>
							<input type="radio" value="FEMME" name="radio" id="radio" class="form-control"/>
						</div><br>
                        <div class="input-group mt-3">
							<div class="input-group-prepend">
								<span class="input-group-text br-15"><i class="fas fa-image"></i></span>
							</div>
							<input type="file" name="image" id="image" placeholder=" date de naissance" class="form-control"/><br>
<!--	pour udpdate full images  <input type="files" name="image[]" id="image" placeholder=" date de naissance" class="form-control"/><br>-->
						</div><br>

                       
                        
                        
                       <select  class="form-control"   id="com" name="com">
                        
                         <option value="">choisir une commune</option>
                           
                           <?php
    
                            foreach($list_commune as $commune):
                              
                    
                            $commune_name=$commune['name'];
                            $commune_id=$commune['id'];
                                
    
    
                            ?>
                           
                           
                           
                         <option value="<?=$commune_id;?>"><?=$commune_name;?></option>
                        
                        <?php endforeach ?> 
                        
                        </select><br><br>
                        
                        
                        
                    
                         
                       
                        
					 
                        
						
					</div>
                    
                    
                    <div class="card-footer">
                            
					 
				 
				<input  type="submit" style="font-size: 20px;"  value="S'insrire"  name="forminscription" class="btn btn-success btn-sm float-right submit_btn"/>
                   
			       </div>
                    
                    
                    
				</form>
			</div>
			
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
    
    </div>
    
