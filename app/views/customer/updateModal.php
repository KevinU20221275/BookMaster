<!-- Actualizar Cliente -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateModalLabel">Actualizar Cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="text" name="id" id="id" hidden>
                    <div class="mb-3">
                        <label for="firstName" class="form-label">Nombre: </label>
                        <input type="text" name="firstName" id="firstName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="lastName" class="form-label">Apellido: </label>
                        <input type="text" name="lastName" id="lastName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Dirección: </label>
                        <input type="text" name="address" id="address" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email: </label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono: </label>
                        <input type="text" name="phone" id="phone" class="form-control" required>
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