<?php
session_start();
if ($_SESSION['user_name'] == "") {
    header("Location: ../../../index.php");
    exit();
}

?>

<!-- Modal para agregar ventas -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateModalLabel">Agregar Venta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="d-flex justify-content-between align-items-center">

                        <div class="mb-3 col-md-10">
                            <label for="customer_id">Cliente: </label>
                            <select class="form-select" name="customer_id" id="customer_id" required>
                                <!-- Opciones de cliente (se cargar con fetch) -->
                            </select>
                        </div>

                        <div class="mb-3">

                            <button
                                class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addClientModal">
                                <i class="fa fa-plus"></i>
                                Registrar Cliente
                            </button>
                        </div>
                    </div>

                    <table id="details-table" class="table table-striped table-responsive table-bordered mt-2 bg-light">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th style="width:30%;">Producto</th>
                                <th style="width:15%;">Cantidad</th>
                                <th>Stock</th>
                                <th>Precio</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            <!-- Detalles de los productos se agregarán aquí -->
                        </tbody>
                    </table>
                    <div class="form-group col-md-6 py-3">
                        <input type="text" name="totalInput" id="totalInput" hidden>
                        <b>Total: <br /> $</b>
                        <span id="total">0</span>
                    </div>


                    <span class="text-danger" id="errorMessage"></span>

                    <div class="d-flex justify-content-between">
                        <button type="button" id="add-row" class="btn btn-secondary">Agregar Producto <i class="lni lni-circle-plus"></i></button>
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>