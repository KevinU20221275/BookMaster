<!-- Modal elimina registro -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Aviso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h2>¿Desea eliminar el registro?</h2>
                <p>Se eliminaran todos los datos relacionados con el empleado</p>
                <p class="text-danger">Esta accion no se puede deshacer</p>
            </div>

            <div class="modal-footer">
                <form action="" method="post">
                    <input type="hidden" name="id" id="id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>