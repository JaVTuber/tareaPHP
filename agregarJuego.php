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
                    <h3>Nuevo Juego</h3>
                    <?php
                        include("logica/database.php");

                        $juegos = new Database();

                        if(isset($_POST) && !empty($_POST)){
                            $id = $juegos->sanitize($_POST["id"]);
                            $nombre = $juegos->sanitize($_POST["nombre"]);
                            $fechalanzamiento = $juegos->sanitize($_POST["fecha"]);
                            $descripcion = $juegos->sanitize($_POST["descripcion"]);
                            $consola = $juegos->sanitize($_POST["consola"]);

                            $res = $juegos->insertarJuego($id, $nombre, $fechalanzamiento, $descripcion, $consola);
                            if($res){
                                $mensaje = "<div class='alert alert-success'>¡Juego guardado!</div>";
                            } else {
                                $mensaje = "<div class='alert alert-danger'>No se pudo guardar el juego.</div>";
                            }

                            echo $mensaje;
                        }
                    ?>
                    <form action="agregarJuego.php" method="POST">
                        <div class="form-group">
                            <label for="id">ID Juego</label>
                            <input id="id" name="id" type="text" required="required" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre:</label> 
                            <input id="nombre" name="nombre" type="text" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha de lanzamiento:</label>
                            <input id="fecha" name="fecha" type="date" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea id="descripcion" name="descripcion" cols="40" rows="3" class="form-control" required="required"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="consola">Consola:</label>
                            <div>
                                <select id="consola" name="consola" class="custom-select" required="required">
                                    <?php
                                        $res2 = $juegos->mostrarConsolas();
                                        if(!$res2){
                                            //Do nothing.
                                        } else {
                                            while($row = mysqli_fetch_object($res2)){
                                                ?>
                                                <option value="<?php echo $row->id;?>"><?php echo $row->nombre;?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <button name="submit" type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
