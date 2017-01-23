<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Burger Family - Administration</title>
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
               <h1><strong>Liste des items </strong>
                    <a href="insert.php" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Ajouter</a>
                    <a href="../index.php" class="btn btn-primary"><span class="glyphicon glyphicon-arraw-left"></span> Retournez sur le site</a>
                </h1>
           
               <table class="table table-striped table-bordered">
                   <thead>
                       <tr>
                           <th>Nom</th>
                           <th>Description</th>
                           <th>Prix</th>
                           <th>Catégorie</th>
                           <th>Actions</th>
                       </tr>
                   </thead>
                   <tbody>
                    <?php                            
                       require ('database.php');                       
                       $bdd = Database::connect();

                       $statement = $bdd->query('SELECT items.id, items.name, items.description, items.price, categories.name AS category
                                               FROM items LEFT JOIN categories
                                               ON items.category = categories.id
                                               ORDER BY items.id DESC');

                       while($item = $statement->fetch()){

                           echo '<tr>';
                               echo '<td>' . utf8_encode ($item['name']) . '</td>';
                               echo '<td>' . utf8_encode ($item['description']) . '</td>';
                               echo '<td>' . number_format ((float)$item['price'], 2, '.', '') . '€</td>';
                               echo '<td>' . utf8_encode ($item['category']) . '</td>';
                               echo '<td width=300>';
                               echo '<a href="view.php?id=' . $item['id'] . '" class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
                               echo ' ';
                               echo '<a href="update.php?id=' . $item['id'] . '" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
                               echo ' ';
                               echo '<a href="delete.php?id=' . $item['id'] . '" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
                               echo '</td>';
                           echo '</tr>';  
                       }

                       Database::disconnect();
                    ?>
                   </tbody>
               </table>
           </div> <!-- Fin row -->
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