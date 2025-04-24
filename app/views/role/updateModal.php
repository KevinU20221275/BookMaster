<!-- Actualizar rol -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateModalLabel">Actualizar Rol</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="text" name="id" id="id" hidden>
                    <div class="mb-3">
                        <label for="roleName" class="form-label">Nombre del Rol: </label>
                        <input type="text" name="roleName" id="roleName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descripcion: </label>
                        <input type="text" name="description" id="description" class="form-control" required>
                    </div>

                    <span class="text-danger" id="errorMessage"></span>
                    <div class="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Actualizar</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>