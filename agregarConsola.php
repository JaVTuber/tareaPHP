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

                        $consolas = new Database();

                        if(isset($_POST) && !empty($_POST)){
                            $id = $consolas->sanitize($_POST["id"]);
                            $nombre = $consolas->sanitize($_POST["nombre"]);

                            $res = $consolas->insertarConsola($id, $nombre);
                            if($res){
                                $mensaje = "<div class='alert alert-success'>¡Consola guardada!</div>";
                            } else {
                                $mensaje = "<div class='alert alert-danger'>No se pudo guardar la consola.</div>";
                            }

                            echo $mensaje;
                        } else {
                        ?>        
                        <form action="agregarConsola.php" method="POST">
                            <div class="form-group">
                                <label for="id">ID Consola</label>
                                <input id="id" name="id" type="text" required="required" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre:</label> 
                                <input id="nombre" name="nombre" type="text" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <button name="submit" type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                        <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
