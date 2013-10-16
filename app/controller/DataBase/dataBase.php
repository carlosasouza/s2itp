<?php
    abstract class Connection{
        public static function getConnection(){
            try
            {
                $pdo = new PDO('mysql:dbname=s2itp2;host=localhost', 'root', '');
                return $pdo;
            }
            catch (PDOException $e)
            {
                echo 'Falha na conexão:'.$e->getMessage();
            }
        }
    }
?>
