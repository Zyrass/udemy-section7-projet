<?php
    require ('database.php');

    if  ( !empty( $_GET ['id'] ) ) {
        $id = checkInput( $_GET ['id'] );
    }

    $nameError = $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category = $image = "";

    if ( !empty ( $_POST ) ) {
        $name = checkInput ( $_POST ['name'] );
        $description = checkInput ( $_POST ['description'] );
        $price = checkInput ( $_POST ['price'] );
        $category = checkInput ( $_POST ['category'] );
        // Images
        $image = checkInput ( $_FILES ['image'] ['name'] );
        $imagePath = '../assets/images/' . basename ( $image );
        $imageExtension = pathinfo ( $imagePath, PATHINFO_EXTENSION );
        
        $isSuccess      = true;
        
        // Traitement du nom
        if(empty($name)) {
            $nameError = "<div class='alert alert-danger' style='margin-top: 10px'> Le nom est obligatoire. </div>";
            $isSuccess = false;
        }
        // Traitement de la description
        if(empty($description)) {
            $descriptionError = "<div class='alert alert-danger' style='margin-top: 10px'> La description est très importante. </div>";
            $isSuccess = false;
        }
        // Traitement du prix
        if(empty($price)) {
            $priceError = "<div class='alert alert-danger' style='margin-top: 10px'> Le prix est important ! </div>";
            $isSuccess = false;
        }
        // Traitement de la category
        if(empty($category)) {
            $categoryError = "<div class='alert alert-danger'> Vous êtes dans l'obligation de sélectionner une catégorie </div>";
            $isSuccess = false;
        }
        // Traitement de l'image
        if(empty($image)) {
            $isImageUpdated = false;
        } else {
            $isImageUpdated = true;
            $isUploadSuccess = true;
            
            if($imageExtension != "jpg" && $imageExtension != "jpeg" && $imageExtension != "png" && $imageExtension != "gif") {
                $imageError = "<div class='alert alert-danger' style='margin-top: 10px'> Les fichiers autorisés sont : .jpg, .jpeg, .png, .gif </div>";
                $isUploadSuccess = false;
            }
            
            if(file_exists($imagePath)) {
                $imageError = "<div class='alert alert-danger' style='margin-top: 10px'> Le fichier existe déjà </div>";
                $isUploadSuccess = false;
            }
            
            if($_FILES['image']['size'] > 500000) {
                $imageError = "<div class='alert alert-danger' style='margin-top: 10px'> Le fichier ne doit pas dépasser les 500 kilo octets </div>";
                $isUploadSuccess = false;
            }
            
            if($isUploadSuccess) {
                if(!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                    $imageError = "<div class='alert alert-danger' style='margin-top: 10px'> Il y a eu une erreur lors de l'upload de l'image </div>";
                    $isUploadSuccess = false;
                }
            }
        }
         
        if( ($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated) )  {
            
            $bdd = Database::connect(); 
            if ( $isImageUpdated ) {
                $declare = $bdd->prepare("UPDATE items SET name = ?, description = ?, price = ?, category = ?, image = ? WHERE id = ?");
                $declare->execute(array($name, $description, $price, $category, $image, $id));
            } else {
                $declare = $bdd->prepare("UPDATE items SET name = ?, description = ?, price = ?, category = ?  WHERE id = ?");
                $declare->execute(array($name, $description, $price, $category, $id));
            }
            Database::disconnect();
            
        } else if ( $isImageUpdated && !$isUploadSuccess )  {
            $bdd = Database::connect();
            $declare = $bdd->prepare('SELECT image FROM items WHERE id = ?');
            $declare->execute(array($id));
            $item = $declare->fetch();
            $image = $item['image'];
            Database::disconnect();
            header('Location: index.php');
        }

    } else {
        $bdd = Database::connect();
        $declare = $bdd->prepare('SELECT * FROM items WHERE id= ?');
        $declare->execute(array($id));
        $item = $declare->fetch();

        $name = utf8_encode ( $item['name'] );
        $description = utf8_encode ( $item['description'] );
        $price = number_format( ( float ) $item['price'], 2, ".", "");
        $category = $item['category'];
        $image = $item['image'];

        Database::disconnect();
        
    }

    function checkInput($data) {
        
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        
        return $data;        
    }
     
?>

<!DOCTYPE html>
    <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
    <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
    <!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Site dynamique sur les burgers">

        <title>Burger Family - Mise à jour</title>

        <!-- Font-Awesome CDN -->
            <link href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css" rel="stylesheet" />
        <!-- CSS Bootstrap 3.3.7 -->
            <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
        <!-- CSS Perso -->
            <link rel="stylesheet" type="text/css" href="../vendor/css/myStyle.css">
            <link rel="stylesheet" type="text/css" href="../vendor/css/myStyleAdmin.css">
        <!-- Animate.css -->
            <link rel="stylesheet" type="text/css" href="../vendor/css/animate.css">
        <!-- Google Font -->
            <link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC|Lato" rel="stylesheet">
    </head>
    <body>
    <!--[if lt IE 7]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery wow bounceInLeft"></span> Burger Family <span class="glyphicon glyphicon-cutlery wow bounceInRight"></span></h1>
    <div class="container admin">
        <h1 class="text-center"><strong>Modification du produit</strong></h1>
        <hr>
        <form class="form" action="<?php echo 'update.php?id=' . $id; ?>" method="POST" role="form" enctype="multipart/form-data"> 
            <div class="row">
                <div class="col-sm-5 well">
                    <div class="form-group">
                        <label for="name" >Nom du produit : </label>
                        <input type="text" name="name" placeholder="Saisir le nom du produit ici..." id="name" class="form-control" value="<?php echo utf8_encode($name); ?>">
                        <span class="help-inline"><?php echo $nameError;  ?></span>
                    </div>

                    <div class="form-group">
                        <label for="price" >Prix du produit : </label>
                        <input type="number" step="0.01" name="price" placeholder="Saisir le prix du produit ici... sans le sigle €" id="price" class="form-control" value="<?php echo  $price; ?>">
                        <span class="help-inline"><?php echo $priceError; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="category" >Nom de la catégorie du produit : </label>
                        <select class="form-control" id="category" name="category">
                            <?php
                                $bdd = Database::connect();
                                
                                foreach ( $bdd->query ( 'SELECT * FROM categories' ) as $row) {
                                    if ( $row['id'] == $category ) {
                                        echo '<option selected="selected" value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                    } else {
                                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                    }
                                }
                    
                                Database::disconnect();
                            ?>
                        </select>
                        <span class="help-inline"><?php echo $categoryError; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="description" >Description du produit : </label>
                        <textarea rows="6" cols="20" name="description" id="description" placeholder="La description du produit ici..." class="form-control" value="<?php echo utf8_encode($description);  ?>"></textarea>
                        <span class="help-inline"><?php echo $descriptionError; ?></span>
                </div>

               <div class="form-group">
                    <label for="">Image actuel :</label>
                    <p><?php echo $image; ?></p>
               </div>     

                <div class="form-group">
                    <label for="image">Sélectionner une image :</label>
                    <input type="file" id="image" name="image" class="form-control">
                    <span class="help-inline"><?php echo $imageError; ?></span>
                </div>  
             </div> <!-- Fin col-sm-6 gauche -->
             <div class="col-sm-6 col-sm-offset-1">
                <div class="thumbnail">
                    <img src="<?php echo '../assets/images/' . $image; ?>" alt="...">
                    <div class="price wow tada"><?php echo number_format( (float) $price, 2, ".", ""); ?>€</div>
                    <div class="caption">
                        <h4><?php echo utf8_encode($name); ?></h4>
                        <div class="row">
                            <div class="col-xs-1">
                                <span class="glyphicon glyphicon-info-sign wow tada"></span>
                            </div>
                            <div class="col-xs-11">
                                <p class="text-center"> <?php echo utf8_encode($description); ?> </p>
                            </div>
                        </div>
                        <a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>
                    </div>
                </div>
            </div> <!-- Fin col-sm-6 droite -->
            </div>
            <div class="row">
                <div class="form-actions">
                    <div class="col-sm-6">
                                <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-pencil"></span> - Valider les modifications.</button>
                    </div>
                    <div class="col-sm-6">
                        <a href="index.php" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-arrow-left"></span> Retour sur l'index des produits.</a>
                    </div>
                </div>
            </div> <!-- Fin row -->
        </form>
    </div> <!-- Fin container admin -->

    <!-- JQuery -->
        <script type="text/javascript" src="../vendor/js/jquery-3.1.1.min.js"></script>
    <!-- Script bootstrap 3.3.7 -->
        <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Script wow -->
        <script src="../vendor/js/wow.min.js"></script>
        <script>
            new WOW().init();
        </script>
    <!-- Script perso -->
        <script type="text/javascript" src="../vendor/js/myScript.js"></script>
    </body>
</html>