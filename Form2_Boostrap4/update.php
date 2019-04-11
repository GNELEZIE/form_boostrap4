<?php

    require 'php/database.php';


       
    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }

    $nomError = $prenomError = $dateError = $sexeError = $imageError = $nom= $prenom= $date = $sexe = $image = "";

    if(!empty($_POST)) 
    {
        $nom              = checkInput($_POST['nom']);
        $prenom       = checkInput($_POST['prenom']);
        $date              = checkInput($_POST['date']);
        $sexe           = checkInput($_POST['sexe']); 
        $image              = checkInput($_FILES["image"]["nom"]);
        $imagePath          = 'images/'. basename($image);
        $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
        $isSuccess          = true;
       
       
        if(empty($image)) // le input file est vide, ce qui signifie que l'image n'a pas ete update
        {
            $isImageUpdated = false;
        }
        else
        {
            $isImageUpdated = true;
            $isUploadSuccess =true;
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
        }
         
        if (($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated)) 
        { 
            $db = Database::connect();
            if($isImageUpdated)
            {
                $statement = $db->prepare("UPDATE users  set nom= ?, prenom= ?, date = ?, sexe = ?, image = ? WHERE id = ?");
                $statement->execute(array($nom,$prenom,$date,$sexe,$image,$id));
            }
            else
            {
                $statement = $db->prepare("UPDATE users  set nom= ?, prenom= ?, date = ?, sexe = ? WHERE id = ?");
                $statement->execute(array($nom,$prenom,$date,$sexe,$id));
            }
            Database::disconnect();
            header("Location: membre_inscrits.php");
        }
        else if($isImageUpdated && !$isUploadSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("SELECT * FROM users where id = ?");
            $statement->execute(array($id));
            $item = $statement->fetch();
            $image          = $item['image'];
            Database::disconnect();
           
        }
    }
    else 
    {
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM users where id = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $nom          = $item['nom'];
        $prenom   = $item['prenom'];
        $date          = $item['date'];
        $sexe       = $item['sexe'];
        $image          = $item['image'];
        Database::disconnect();
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
        <title>JUSTIFICATION</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
      
    </head>
    
    <body>
       
         <div class="container admin m-32">
            <div class="row">
                <div class="col-sm-7">
                    <div class="">
	        <div class="d-flex justify-content-center">

		       <div class="card animated   rotateIn myForm">
			   <div class="card-header">
                    <div class="card-header" style="background:green ; color:#fff;">
				<h4>MODIFICATION</h4>
			</div>
                    <form class="form m-32" action="<?php echo 'update.php?id='.$id;?>" role="form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nom">Nom:</label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" value="<?php echo $nom;?>">
                            <span class="help-inline"></span>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prenom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="prenom" value="<?php echo $prenom;?>">
                            <span class="help-inline"> </span>
                        </div>
                        <div class="form-group">
                        <label for="date">Date</label>
                            <input type="date"   class="form-control" id="date" name="date" placeholder="Prix" value="<?php echo $date;?>">
                            <span class="help-inline"><?php echo $dateError;?></span>
                        </div>

                            <div class="input-group mt-3">
							<div class="input-group-prepend">
								<span class="input-group-text br-15">HOMME</span>
							</div>
							<input type="radio" value="HOMME" name="sexe" id="sexe" class="form-control"/>


							<div class="input-group-prepend">
								<span class="input-group-text br-15">FEMME</span>
							</div>
							<input type="radio" value="FEMME" name="sexe" id="sexe" class="form-control"/>
						</div><br>
                        <div class="form-group">
                            <label for="image">Image:</label>
                            <p><?php echo $image;?></p>
                            <label for="image">Sélectionner une nouvelle image:</label>
                            <input type="file" id="image" name="image"> 
                            <span class="help-inline"></span>
                        </div>
                        <br>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                            <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                       </div>
                    </form>
                   </div>
                </div>
                </div>
                </div>
                </div>
                <div class="col-sm-5 ">
                    
                           <div class="">
	        <div class="d-flex justify-content-center">

		       <div class="card animated fadeInRight">
			   <div class="card-header">
                    <div class="card-header"style="background:green ; color:#fff;">
				<h4>PHOTO DE PROFIL</h4>
                        </div>
                    <div class="thumbnail">
                        <img src="<?php echo 'images/'.$image;?>" style="width:100%" alt="...">
            
                          <div class="caption">
                            <h4><?php echo $nom;?></h4>
                            <p><?php echo $prenom;?></p>
                            
                          </div>
                    </div>     
                        
                        
                        
			
                     
                     
                   </div>
                </div>
                </div>
                
                                
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
               .admin{
                   margin-top: 32px;
               }

        
        
        </style>      
          
    </body>
</html>
