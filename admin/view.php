<?php
    require ('database.php'); // Récupération du fichier permettant de se connecter à la base de donnée

    /** Vérification si il y a un ID dans notre super globale GET **/
    if(!empty($_GET['id'])) {
        $id = checkInput($_GET['id']);
    }
    
    $bdd = Database::connect(); // On se connecte à la base de donnée

    /** On décmare notre requête **/
    $declare = $bdd->prepare('SELECT items.id, items.name, items.description, items.price, items.image, categories.name AS category
                                FROM items LEFT JOIN categories
                                ON items.category = categories.id
                                WHERE items.id = ?');
    
    $declare->execute(array($id)); // On exécute notre requête préparé
    $item = $declare->fetch(); // On récupère une seule ligne
    Database::disconnect(); // Déconnexion de la base de donnée

    /** 
    * Fonction pour se protéger d'éventuel hacker 
    * --------------------------------------------------
    * trim() ---------------> Permet de supprimer les espaces avant et après les informations saisis.
    * stripcslashes() ------> Permet de retourner une chaine après avoir supprimé tous les antislashs.
    * htmlspecialchars() ---> Permet de convertir des caractères spéciaux pour éviter toutes injection de code malveillant.
    **/
    function checkInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        
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
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Burger Family - Visualisation</title>
        <meta name="description" content="Site dynamique sur les burgers">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
           <div class="row">
                <div class="alert alert-info">
                    <h1 class="text-center"><strong><?php echo utf8_encode($item['name']); ?></strong></h1>
                    <hr>
                    <h2 class="text-center"></strong>Visualisation du produit :</small></h2>
                </div>
               <div class="col-sm-7">
                    <div class="well">
                        <h3 class="text-center"><small>Information relative sur ce produit</small></h3>
                        <hr>
                        <form>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-7 text-right">
                                        <label>Identification :</label>
                                    </div>
                                    <div class="col-sm-5 text-left">
                                        <?php echo '<span class="text-info"> ' . utf8_encode($item['id']) . '</span>'; ?>
                                    </div> <!-- Fin identification -->
                                </div>

                                <div class="row">
                                    <div class="col-sm-7 text-right">
                                        <label>Nom :</label>
                                    </div>
                                    <div class="col-sm-5 text-left">
                                        <?php echo '<span class="text-info"> ' . utf8_encode($item['name']) . '</span>'; ?>
                                    </div> <!-- Fin Nom du produit -->
                                </div>

                                <div class="row">
                                    <div class="col-sm-7 text-right">
                                        <label>Prix :</label>
                                    </div>
                                    <div class="col-sm-5 text-left">
                                        <?php echo '<span class="text-info"> ' . number_format((float)$item['price'], 2, '.', '') . '€ </span>'; ?>
                                    </div> <!-- Fin du Prix du produit -->
                                </div>

                                <div class="row">
                                    <div class="col-sm-7 text-right">
                                        <label>Catégorie :</label>
                                    </div>
                                    <div class="col-sm-5 text-left">
                                        <?php echo '<span class="text-info"> ' . $item['category'] . '</span>'; ?>
                                    </div> <!-- Fin du Nom de la catégorie du produit -->
                                </div>

                                <div class="row">
                                    <div class="col-sm-7 text-right">
                                        <label>Nom de l'image :</label>
                                    </div>
                                    <div class="col-sm-5 text-left">
                                        <?php echo '<span class="text-info"> ' . $item['image'] . '</span>'; ?>
                                    </div> <!-- Fin Nom de l'image du produit -->
                                </div>

                                <div class="row">
                                    <div class="col-sm-7 text-right">
                                        <label>Emplacement :</label>
                                    </div>
                                    <div class="col-sm-5 text-left">
                                        <p>assets/images/<span class="text-info">ici</span></p>
                                    </div> <!-- Fin de l'emplacement de l'image du produit -->
                                </div>
                            </div>
                        </form>
                    </div> <!-- Fin 1ère div.well -->
                    <div class="well">
                        <h3 class="text-center"><small>Information sur la description de ce produit</small></h3>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <blockquote cite="">
                                    <?php echo '<span class="text-info"> ' . utf8_encode($item['description']) . '</span>'; ?>
                                </blockquote>
                            </div> <!-- Fin de la Description du produit -->
                        </div>
                    </div>
               </div> <!-- Fin col-sm-6 de gauche -->
               <div class="col-sm-5 wow fadeIn site">
                    <div class="thumbnail">
                        <img src="../assets/images/<?php echo $item['image']; ?>" alt="...">
                        <div class="price wow tada"><?php echo number_format((float)$item['price'], 2, ".", ""); ?> €</div>
                        <div class="caption">
                            <h4><?php echo utf8_encode($item['name']); ?></h4>
                            <div class="row">
                                <div class="col-xs-1">
                                    <span class="glyphicon glyphicon-info-sign wow tada"></span>
                                </div>
                                <div class="col-xs-11">
                                    <p class="text-center"><?php echo utf8_encode($item['description']); ?>
                                </div>
                            </div>
                            <a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>
                        </div>
                    </div>
                </div> <!-- Fin col-sm-6 de droite -->
           </div> <!-- Fin row -->
           <div class="row">
               <div class="col-sm-6">
                    <a href="index.php" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-arrow-left"></span> Cliquez ici pour retourner sur l'index des produits</a> 
               </div>
               <div class="col-sm-6">
                    <a href="<?php echo 'update.php?id=' . $id; ?>" class="btn btn-info btn-block"><span class="glyphicon glyphicon-pencil"></span> Accès rapide à la zone de modification</a>
               </div>
           </div>
        
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