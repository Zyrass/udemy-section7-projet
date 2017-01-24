<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Burger Family</title>
        <meta name="description" content="Site dynamique sur les burgers">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Font-Awesome CDN -->
        <link href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css" rel="stylesheet" />
        <!-- CSS Bootstrap 3.3.7 -->
        <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
        <!-- CSS Perso -->
        <link rel="stylesheet" type="text/css" href="vendor/css/myStyle.css">
        <!-- Animate.css -->
        <link rel="stylesheet" type="text/css" href="vendor/css/animate.css">
        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC|Lato" rel="stylesheet">

    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
        <div class="container site">
            <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery wow bounceInLeft"></span> Burger Family <span class="glyphicon glyphicon-cutlery wow bounceInRight"></span></h1>

            <?php 
                require ('admin/database.php');

                // MENU
                echo '<nav>';
                    echo '<ul class="nav nav-pills wow bounceInDown">';

                        $bdd = Database::connect();
                        $declare = $bdd->query ( 'SELECT * FROM categories' );
                        $categories = $declare->fetchAll();

                        foreach ( $categories as $category  ) {
                            if ( $category['id'] == 1 ) {
                                echo  '<li role="presentation" class="active"><a href="#' . $category['id'] .'" data-toggle="tab">' . $category['name'] .'</a></li>';
                            } else {
                                echo  '<li role="presentation"><a href="#' . $category['id'] .'" data-toggle="tab">' . $category['name'] .'</a></li>';
                            }
                        }

                    echo '</ul>';
                echo '</nav>';

                // CONTENU
                echo '<div class="tab-content">';
                foreach ( $categories as $category) {
                     if ( $category['id'] == 1 ) {
                                echo  '<div class="tab-pane active" id="' . $category['id']  . '">';
                            } else {
                                echo  '<div class="tab-pane " id="' . $category['id']  . '">';
                            }

                     echo '<div class="row"> ';
                    
                    $declare = $bdd->prepare ('SELECT * FROM items WHERE items.category = ?');
                    $declare->execute(array($category['id']));

                    while ( $item = $declare->fetch() ) {
                        echo '<div class="col-sm-6 col-md-4 wow fadeIn">';
                            echo '<div class="thumbnail">';
                                echo '<img src="assets/images/' . $item['image'] . '" alt="...">';
                                    echo '<div class="price wow tada">' . number_format( (float) $item['price'], 2, ".", " ") . ' €</div>';
                                        echo '<div class="caption">';
                                            echo '<h4>' . utf8_encode($item['name']) . '</h4>';
                                                
                                                echo '<div class="row">';
                                                    echo '<div class="col-xs-1">';
                                                        echo '<span class="glyphicon glyphicon-info-sign wow tada"></span>';
                                                    echo '</div>';
                                                    echo '<div class="col-xs-11">';
                                                        echo '<p class="text-center">' . utf8_encode($item['description']) . '</p>';
                                                    echo '</div>';
                                                echo '</div>';
                                    
                                                echo '<a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                    }
                        echo '</div>';
                    echo '</div>';
                }
                Database::disconnect();
                echo '</div>';
            ?>


        <!-- JQuery -->
        <script type="text/javascript" src="vendor/js/jquery-3.1.1.min.js"></script>
        <!-- Script bootstrap 3.3.7 -->
        <script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <!-- Script wow -->
        <script src="vendor/js/wow.min.js"></script>
        <script>
            new WOW().init();
        </script>
        <!-- Script perso -->
        <script type="text/javascript" src="vendor/js/myScript.js"></script>
    </body>
</html>
