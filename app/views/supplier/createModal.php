<!-- modal agregar -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateModalLabel">Agregar Proveedor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="supplierName" class="form-label">Nombre del Proveedor: </label>
                        <input type="text" name="supplierName" id="supplierName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefono (sin guion):</label>
                        <input type="text" name="phone" id="phone" class="form-control" pattern="[0-9]{8}" inputmode="numeric" maxlength="8" title="El formato de telefono debe ser ########" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Dirección:</label>
                        <input type="text" name="address" id="address" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label">Ciudad</label>
                        <input type="text" name="city" id="city" class="form-control" required>
                    </div>
                    
                    <span class="text-danger" id="errorMessage"></span>

                    <div class="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>