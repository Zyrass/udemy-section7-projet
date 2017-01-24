<?php
    require ('database.php');

    if ( !empty( $_GET['id'] ) ) {
        $id = checkInput( $_GET['id'] );
    }

    if ( !empty($_POST)){
        $id = checkInput( $_POST['id'] );

        $bdd = Database::connect();
        $declare = $bdd->prepare('DELETE FROM items WHERE id=?');
        $declare->execute(array($id));

        Database::disconnect();
        header( "Location: index.php");
        exit;
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

        <title>Burger Family - Insertion</title>

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
        <h1 class="text-center"><strong>Supprimer un produit</strong></h1>
        <hr>
        <form class="form" action="delete.php" method="POST" role="form">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <p class="alert alert-warning text-center lead">Attention, êtes-vous bien sûr de vouloir supprimer ce produit ?</p>
            <hr>
            <div class="row">
                <div class="form-actions">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-warning btn-block"> Oui</button>
                    </div>
                    <div class="col-sm-6">
                        <a href="index.php" class="btn btn-default btn-block"> Non</a>
                    </div>
                </div>    
            </div>
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