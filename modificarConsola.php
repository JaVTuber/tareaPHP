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
                    <h3>Modificar Consola</h3>
                    <?php
                        include("logica/database.php");
                        $consolas = new Database();
                        if(isset($_POST) && isset($_POST["submit"])){
                            $id = $consolas->sanitize($_POST["id"]);
                            $nombre = $consolas->sanitize($_POST["nombre"]);

                            $res = $consolas->actualizarConsola($id, $nombre);
                            if($res){
                                $mensaje = "<div class='alert alert-success'>¡Consola actualizada!</div>";
                            } else {
                                $mensaje = "<div class='alert alert-danger'>No se pudo actualizar la consola</div>";
                            }
                            echo $mensaje;
                        }

                        if(!empty($_POST["id"]) && isset($_POST["delete"])){
                            $res = true;
                            $id = $consolas->sanitize($_POST["id"]);
                            if($res){
                                ?>
                                <form action="modificarConsola.php" method="POST">
                                    <input type="text" id="id" name="id" value="<?php echo $id; ?>" hidden>
                                    <div class="form-group">
                                        <div class='alert alert-danger'><label for="conDelete">ADVERTENCIA: ¿Estás seguro que quieres borrar esta consola? Esta acción no se puede deshacer</label></div>
                                        <button id="conDelete" name="conDelete" type="submit" class="btn btn-danger">Sí, eliminar</button>
                                        <button id="notDelete" name="notDelete" type="submit" class="btn btn-primary">No, no estoy seguro</button>
                                    </div>
                                </form>
                                <?php
                            } else {
                                echo "<div class='alert alert-danger'>No se pudo eliminar la consola</div>";
                            }
                        }

                        if(isset($_POST["conDelete"]) || isset($_POST["notDelete"])){
                            if(isset($_POST["conDelete"])){
                                $id = $_POST["id"];
                                $res = $consolas->eliminarConsola($id);
                                echo "<div class='alert alert-success'>Consola eliminada</div>";
                            } else if (isset($_POST["notDelete"])){
                                echo "<div class='alert alert-success'>La consola no se ha eliminado</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Ha ocurrido un error, no se ha podido eliminar la consola</div>";
                            }
                        }

                        if(isset($_GET["id"]) && !empty($_GET["id"]) && isset($_GET["mod"]) || isset($_GET["del"])){
                            $id = $consolas->sanitize($_GET["id"]);
                            $res = $consolas->buscarConsola($id);
                            //var_dump($res);
                            if($res){
                                if(isset($_GET["mod"])){
                                    ?>
                                <form action="modificarConsola.php" method="POST">
                                    <div class="form-group">
                                        <label for="id">ID Consola</label>
                                        <input id="id" name="id" type="text" required="required" readonly="" class="form-control" value="<?php echo $res->id; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombre:</label>
                                        <input id="nombre" name="nombre" type="text" class="form-control" required="required" value="<?php echo $res->nombre; ?>">
                                    </div>
                                    <div class="form-group">
                                        <button name="submit" type="submit" class="btn btn-primary">Modificar</button>
                                    </div>
                                </form>
                                    <?php
                                } else if(isset($_GET["del"])) {
                                    echo $res->nombre;
                                    ?>
                                <form action="modificarConsola.php" method="POST">
                                    <div class="form-group">
                                        <label for="id">ID Juego</label>
                                        <input id="id" name="id" type="text" required="required" readonly="" class="form-control" value="<?php echo $res->id; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombre:</label>
                                        <input id="nombre" name="nombre" type="text" readonly="" class="form-control" required="required" value="<?php echo $res->nombre; ?>">
                                    </div>
                                    <div class="form-group">
                                        <button id="delete" name="delete" type="submit" class="btn btn-danger">Eliminar</button>
                                    </div>     
                                    <?php
                                } else {
                                    echo "<div class='alert alert-danger'>Consola no encontrada</div>";
                                }
                            } else {
                                echo "<div class='alert alert-danger'>Consola no encontrada</div>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
