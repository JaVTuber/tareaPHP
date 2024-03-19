<?php
    class Database{
        private $con;
        private $dbhost = "localhost";
        private $dbuser = "root";
        private $dbpass = "";
        private $dbname = "proyecto_juegos";

        function __construct()
        {
            $this->conectar();
        }

        public function conectar(){
            $this->con = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
            if(mysqli_connect_error()){
                die("Conexión a la base de datos fallida." . mysqli_connect_errno() . mysqli_connect_error());
            }
        }

        public function sanitize($var){
            $retornar = mysqli_real_escape_string($this->con, $var);
            return $retornar;
        }

        public function insertarJuego($id, $nombre, $fechaLanzamiento, $descripcion, $consola){
            $sql = "INSERT INTO `juegos` (`id`, `nombre`, `fechalanzamiento`, `descripcion`, `consola`) VALUES ('$id', '$nombre', '$fechaLanzamiento', '$descripcion', '$consola')";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }

        public function insertarConsola($id, $nombre){
            $sql = "INSERT INTO `consolas` (`id`, `nombre`) VALUES ('$id', '$nombre')";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }

        public function mostrarJuegos(){
            $sql = "SELECT * FROM `juegos`";
            $res = mysqli_query($this->con, $sql);
            return $res;
        }

        public function mostrarConsolas(){
            $sql = "SELECT * FROM `consolas`";
            $res = mysqli_query($this->con, $sql);
            return $res;
        }

        public function actualizarJuego($id, $nombre, $fechaLanzamiento, $descripcion, $consola){
            $sql = "UPDATE `juegos` SET `nombre` = '$nombre', `fechalanzamiento` = '$fechaLanzamiento', `descripcion` = '$descripcion', `consola` = '$consola' WHERE `juegos`.`id` = '$id'";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }

        public function actualizarConsola($id, $nombre){
            $sql = "UPDATE `consolas` SET `nombre` = '$nombre' WHERE `consolas`.`id` = '$id'";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }

        public function buscarJuego($id){
            $sql = "SELECT * FROM `juegos` WHERE `id` = '$id'";
            $res = mysqli_query($this->con, $sql);
            $return = mysqli_fetch_object($res);
            return $return;
        }

        public function buscarConsola($id){
            $sql = "SELECT * FROM `consolas` WHERE `id` = '$id'";
            $res = mysqli_query($this->con, $sql);
            $return = mysqli_fetch_object($res);
            return $return;
        }

        public function eliminarJuego($id){
            $sql = "DELETE FROM `juegos` WHERE `id` = '$id'";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }

        public function eliminarConsola($id){
            $sql = "DELETE FROM `consolas` WHERE `id` = '$id'";
            $res = mysqli_query($this->con, $sql);
            if($res){
                return true;
            } else {
                return false;
            }
        }
    }
?>