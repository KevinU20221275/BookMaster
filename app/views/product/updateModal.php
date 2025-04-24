<!-- Actualizar Prodcucto -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ModalLabel">Actualizar Producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="text" name="id" id="id" hidden>

                    <div class="mb-3">
                        <label for="bookName" class="form-label">Nombre del Libro:</label>
                        <input type="text" name="bookName" id="bookName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label">Cantidad Disponible:</label>
                        <input type="number" name="stock" id="stock" class="form-control" min="0" required>
                    </div>

                    <div class="mb-3">
                        <label for="purchase_price" class="form-label">Precio de Compra:</label>
                        <input type="number" step="0.01" name="purchase_price" id="purchase_price" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="sale_price" class="form-label">Precio de Venta:</label>
                        <input type="number" step="0.01" name="sale_price" id="sale_price" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="supplier_id">Proveedor: </label>
                        <select class="form-select form-control supplier_id" name="supplier_id" id="supplier_id" required>
                            <option value="">Seleccione un Proveedor</option>
                        </select>
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