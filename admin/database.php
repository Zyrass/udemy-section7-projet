<?php

    class Database {
        
        private static $dbHost = "localhost";
        private static $dbName = "burger_code";
        private static $dbUser = "root";
        private static $dbPassword = "";

        private static $connection = null;
               
        /**
         * Methode Static pour la se connecter à la base de donnée
         **/
        public static function connect() {
            try {
                self::$connection = new PDO("mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName , self::$dbUser , self::$dbPassword);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
            } catch (PDOException $e) {
                die("Erreur :" . $e->getMessage());
            }
            return self::$connection;
        }
        
        /**
         * Methode Static pour la se déconnecter de la base de donnée
         **/
        public static function disconnect(){
            self::$connection = null;
        }        
    }

?>