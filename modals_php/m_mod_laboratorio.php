<?php
require '../class/cl_laboratorio.php';
$c_laboratorio = new cl_laboratorio();
$c_laboratorio->setIdLaboratorio(filter_input(INPUT_POST, 'id_laboratorio'));
$c_laboratorio->obtener_datos();
?>
<form class="form-horizontal" method="post"
      action="procesos/mod_laboratorio.php">
    <div class="color-line"></div>
    <div class="modal-header text-center">
        <h4 class="modal-title">Agregar Laboratorio Producto</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label class="col-lg-2 control-label">Nombre: </label>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="input_nombre" id="input_nombre" value="<?php echo $c_laboratorio->getNombre()?>" required/>
            </div>
        </div>
    </div>
    <input type="hidden" name="input_codigo" value="<?php echo $c_laboratorio->getIdLaboratorio()?>">
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
            Cerrar
        </button>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</form>