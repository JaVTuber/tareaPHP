<?php
    $res2 = $juegos->mostrarConsolas();
    if($res){
        while($row = mysqli_fetch_object($res2)){
            if($row->id == $res->consola){
                ?>
                <option value="<?php echo $row->id; ?>" selected=""><?php echo $row->nombre; ?></option>
                <?php
            } else {
                ?>
                <option value="<?php echo $row->id; ?>"><?php echo $row->nombre; ?></option>
                <?php
            }
        }
    } else {
        //Do nothing.
    }
?>