<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body>
        <?php include("menu/admin.html") ?>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h3>Modificar Juego</h3>
                    <?php
                        include("logica/database.php");
                        $juegos = new Database();
                        if(isset($_POST) && isset($_POST["submit"])){
                            $id = $juegos->sanitize($_POST["id"]);
                            $nombre = $juegos->sanitize($_POST["nombre"]);
                            $fechalanzamiento = $juegos->sanitize($_POST["fecha"]);
                            $descripcion = $juegos->sanitize($_POST["descripcion"]);
                            $consola = $juegos->sanitize($_POST["consola"]);

                            $res = $juegos->actualizarJuego($id, $nombre, $fechalanzamiento, $descripcion, $consola);
                            if($res){
                                $mensaje = "<div class='alert alert-success'>¡RJuego actualizado!</div>";
                            } else {
                                $mensaje = "<div class='alert alert-danger'>No se pudo actualizar el juego</div>";
                            }
                            echo $mensaje;
                        }

                        if(!empty($_POST["id"]) && isset($_POST["delete"])){
                            $res = true;
                            $id = $juegos->sanitize($_POST["id"]);
                            if($res){
                                ?>
                                <form action="modificarJuego.php" method="POST">
                                    <input type="text" id="id" name="id" value="<?php echo $id; ?>" hidden="">
                                    <div class="form-group">
                                        <div class='alert alert-danger'><label for="conDelete">ADVERTENCIA: ¿Estás seguro que quieres borrar este juego? Esta acción no se puede deshacer</label></div>
                                        <button id="conDelete" name="conDelete" type="submit" class="btn btn-danger">Sí, eliminar</button>
                                        <button id="notDelete" name="notDelete" type="submit" class="btn btn-primary">No, no estoy seguro</button>
                                    </div>
                                </form>
                                <?php
                            } else {
                                echo "<div class='alert alert-danger'>No se pudo eliminar el juego</div>";
                            }
                        }

                        if(isset($_POST["conDelete"]) || isset($_POST["notDelete"])){
                            if(isset($_POST["conDelete"])){
                                $id = $_POST["id"];
                                $res = $juegos->eliminarJuego($id);
                                echo "<div class='alert alert-success'>Juego eliminado</div>";
                            } else if (isset($_POST["notDelete"])){
                                echo "<div class='alert alert-success'>El juego no se ha eliminado</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Ha ocurrido un error, no se ha podido eliminar el juego</div>";
                            }
                        }

                        if(isset($_GET["id"]) && !empty($_GET["id"]) && isset($_GET["mod"]) || isset($_GET["del"])){
                            $id = $juegos->sanitize($_GET["id"]);
                            $res = $juegos->buscarJuego($id);
                            if($res){
                                if(isset($_GET["mod"])){
                                    ?>
                                <form action="modificarJuego.php" method="POST">
                                    <div class="form-group">
                                        <label for="id">ID Juego</label>
                                        <input id="id" name="id" type="text" required="required" readonly="" class="form-control" value="<?php echo $res->id; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombre:</label>
                                        <input id="nombre" name="nombre" type="text" class="form-control" required="required" value="<?php echo $res->nombre; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha">Fecha de lanzamiento:</label>
                                        <input id="fecha" name="fecha" type="date" class="form-control" required="required" value="<?php echo $res->fechalanzamiento; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion">Descripción:</label>
                                        <textarea id="descripcion" name="descripcion" cols="40" rows="3" class="form-control" required="required"><?php echo $res->descripcion; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="consola">Consola:</label>
                                        <div>
                                            <select id="consola" name="consola" class="custom-select" required="required">
                                                <?php include("logica/verConsolas.php") ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button name="submit" type="submit" class="btn btn-primary">Modificar</button>
                                    </div>
                                </form>
                                    <?php
                                } else if(isset($_GET["del"])) {
                                    ?>
                                <form action="modificarJuego.php" method="POST">
                                    <div class="form-group">
                                        <label for="id">ID Juego</label>
                                        <input id="id" name="id" type="text" required="required" readonly="" class="form-control" value="<?php echo $res->id; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombre:</label>
                                        <input id="nombre" name="nombre" type="text" readonly="" class="form-control" required="required" value="<?php echo $res->nombre; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha">Fecha de lanzamiento:</label>
                                        <input id="fecha" name="fecha" type="date" readonly="" class="form-control" required="required" value="<?php echo $res->fechalanzamiento; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion">Descripción:</label>
                                        <textarea id="descripcion" name="descripcion" readonly="" cols="40" rows="3" class="form-control" required="required"><?php echo $res->descripcion; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="consola">Consola:</label>
                                        <input type="text" class="form-control" value="<?php echo $res->consola; ?>" readonly="">
                                    </div>
                                    <div class="form-group">
                                        <button id="delete" name="delete" type="submit" class="btn btn-danger">Eliminar</button>
                                    </div>     
                                    <?php
                                } else {
                                    echo "<div class='alert alert-danger'>Registro no encontrado</div>";
                                }
                            } else {
                                echo "<div class='alert alert-danger'>Registro no encontrado</div>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
