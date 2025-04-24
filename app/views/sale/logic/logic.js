import { addSale, deleteSale, getSaleDetails, listSales, listCustomerForSelect, listProductsForSelect } from "../../../services/sale.js";
import { addCustomer } from "../../../services/customer.js";
import { showAlert } from "../../assets/js/utils.js";

$(document).ready(function () {
    getData();

    $('#createModal').on('shown.bs.modal', function () {
        $('#customer_id').select2({
            dropdownParent: $('#createModal')
        });
    });

    /* Función para cargar los datos con AJAX */
    function getData() {
        let content = document.getElementById("content");

        if ($.fn.DataTable.isDataTable("#saleTable")) {
        $("#saleTable").DataTable().destroy();
        }

        listSales()
            .then((html) => {
                content.innerHTML = html;

                $("#saleTable").DataTable({
                pageLength: 25,
                responsive: true,
                order: [],
                columnDefs: [
                    {
                    targets: [5],
                    orderable: false,
                    searchable: false,
                    },
                ],
                });
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    }

    // modales
    let createModal = document.getElementById("createModal");
    let detailModal = document.getElementById("saleDetailsModal");
    let deleteModal = document.getElementById("deleteModal");

    createModal.addEventListener("submit", (event) => {
        event.preventDefault();

        let formData = new FormData(event.target);

        if (isNaN(formData.get("customer_id")) || formData.get("customer_id") == "" || formData.get("customer_id") <= 0){
            createModal.querySelector(".modal-body #errorMessage").innerText = "Debe ingresar el cliente";
            return;
        }

        if (!hasProducts()) {
            createModal.querySelector(".modal-body #errorMessage").innerText = "Debe agregar productos almenos un producto";
            return;
        }

        if (!validateDuplicateProducts()) {
            createModal.querySelector(".modal-body #errorMessage").innerText = "Se tienen productos duplicados";
            return;
        }

        const validation = validSaleDetails();
        
        if (!validation.isValid){
            createModal.querySelector(".modal-body #errorMessage").innerText = validation.message;
            return;
        }

        if (!checkQuantities()){
            createModal.querySelector(".modal-body #errorMessage").innerText = "La cantidad ingresada excede el stock disponible";
            return;
        }

        addSale(formData)
            .then((data) => {
                if (data.status == "error") {
                    createModal.querySelector(".modal-body #errorMessage").innerText = data.message;
                } else if (data.status == "success") {
                    createModal.querySelector(".modal-body #errorMessage").innerText = "";
                    createModal.querySelector("#details-table #table-body").innerHTML = "";
                    createModal.querySelector("#total").innerText = "$0.00";

                    var bootstrapModal = bootstrap.Modal.getInstance(createModal);
                    bootstrapModal.hide();

                    getData();
                    showAlert(data.message);
                }
            });
    });

    createModal.addEventListener("hide.bs.modal", (event) => {
        createModal.querySelector(".modal-body #customer_id").value = "";
        createModal.querySelector(".modal-body #errorMessage").innerText = "";
    });

    // logica modal detalles
    detailModal.addEventListener("shown.bs.modal", (event) => {
        let button = event.relatedTarget;
        let id = button.getAttribute("data-bs-id");

        getSaleDetails(id)
            .then((data) => {
                document.querySelector("#saleDetailsTable").innerHTML = data;
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    });

    // logica modal eliminar
    deleteModal.addEventListener("shown.bs.modal", (event) => {
        let button = event.relatedTarget;
        let id = button.getAttribute("data-bs-id");
        deleteModal.querySelector(".modal-footer #id").value = id;
    });

    deleteModal.addEventListener("submit", (event) => {
        event.preventDefault();

        let formData = new FormData(event.target);

        deleteSale(formData)
            .then((data) => {
                var bootstrapModal = bootstrap.Modal.getInstance(deleteModal);
                bootstrapModal.hide();
                getData();
                showAlert(data, "danger");
            });
    });


    // traer los clientes para el select
    getCustomers();
    
    function getCustomers() {
        listCustomerForSelect()
            .then(data => {
                let selects = document.querySelector('#customer_id');
                
                selects.innerHTML = data
            })
            .catch(error => {
                console.error('Error fetching customers:', error);
            })
    }

    function getProducts(select) {

        listProductsForSelect()
            .then(data => {
                if (select) {
                    select.innerHTML = data;
                    $('.product-select').select2({
                        dropdownParent: $("#createModal")
                    })
                } else {
                    // Si no se pasa un select, llena todos los selects
                    let selects = document.querySelectorAll('.product-select');
                    selects.forEach(select => {
                        select.innerHTML = data
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
    }


    // modal para agregar clientes desde la vista de ventas
    let addClientModal = document.getElementById("addClientModal");

    addClientModal.addEventListener('submit', (event) => {
        event.preventDefault();

        let formData = new FormData(event.target);

        addCustomer(formData)
            .then(data => {
                if (data.status == 'error') {
                    addClientModal.querySelector('.modal-body #errorMessage').innerText = data.message;
                } else if (data.status == 'success') {
                    addClientModal.querySelector('.modal-body #errorMessage').innerText = "";

                    var bootstrapModal = bootstrap.Modal.getInstance(addClientModal);
                    bootstrapModal.hide();

                    getCustomers();
                    showAlert(data.message);
                }
            });
    });

    // Agrega filas en la tabla de productos
    $('#add-row').click(function() {
        var index = $('#details-table tbody tr').length; // Obtiene la longitud de las filas
        var fila = `<tr>
            <td style="width:30%;">
                <select name="SaleDetails[${index}][ProductID]" class="form-control product-select" required>
                    <option value="">Seleccione un Producto</option>
                </select>
            </td>
            <td style="width:15%;"><input type="number" name="SaleDetails[${index}][Quantity]" class="form-control text-center" value="1" required /></td>
            <td class="text-center">
                <span class="productStock">0</span>
            </td>
            <td class="text-center">$ 
                <span class="productPrice">0</span>
                <input type="hidden" name="SaleDetails[${index}][UnitPrice]" class="form-control text-center" />
            </td>
            <td class="text-center">$ <span class="totalDetail">0</span></td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-success"><i class="fa fa-solid fa-check"></i></button>
                <button type="button" class="btn btn-sm btn-danger remove-row"><i class="fa fa-times"></i></button>
            </td>
        </tr>`;
        $('#details-table tbody').append(fila);

        const newSelect = $('#details-table tbody tr:last-child .product-select')[0];

        getProducts(newSelect);
    });

    // Eliminar fila de la tabla
    $('#details-table').on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
        calculateTotalSale()
    });

    // searchProductInfo junto con la fila
    $('#details-table').on('change', '.product-select', function() {
        var selectedProduct = $(this).val();
        searchProductInfo(selectedProduct, $(this).closest('tr'));
    });

    // trae el precio y el stock del producto y actualiza la fila
    function searchProductInfo(productID, $row) {
        if (productID) {
            $.ajax({
                url: '../../Controllers/saleController.php', // hace la peticion al metodo SearchProductById del controlador sale
                method: 'POST',
                data: {
                    product_id: productID,
                    action: "GetProductById"

                }, // aqui envia el id del producto al metodo 
                success: function(data) { // data es la informacion del producto que recibimos del metodo en el controlador de sale
                    data = JSON.parse(data)
                    if (data) {
                        // se actualizan los datos de la fila con los datos que vienen de la (data)
                        $row.find('.productPrice').text(data.salePrice);
                        $row.find('input[name$="[ProductName]"]').val(data.bookName); // input oculo guarda el nombre del producto para el envio del email
                        $row.find('.productStock').text(data.stock);
                        $row.find('input[name$="[UnitPrice]"]').val(data.salePrice); // input oculto en la vista se usa para el email
                        var cantidad = parseFloat($row.find('input[name$="[Quantity]"]').val()) || 0;
                        var total = data.salePrice * cantidad
                        $row.find('.totalDetail').text(total.toFixed(2));
                        calculateTotalSale();
                    } else {
                        console.error('Producto no encontrado');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener la información del producto:', error);
                }
            });
        }
    }
    
    // llena la fila cuando se selecciona un producto
    $('#details-table').on('change', 'input[name$="[Quantity]"]', function() {
        var $row = $(this).closest('tr');
        var cantidad = parseFloat($row.find('input[name$="[Quantity]"]').val()) || 0;
        var total = parseFloat($row.find('.productPrice').text() * cantidad)
        var stock = parseFloat($row.find('.productStock').text()) || 0;
        $row.find('.totalDetail').text(total.toFixed(2));
        checkQuantity($row, cantidad, stock);
        calculateTotalSale();
    });

    // suma los totales de los detalles para mostrar el total de la venta
    function calculateTotalSale() {
        var totalVenta = 0;
        $('#details-table tbody tr').each(function() {
            var total = parseFloat($(this).find('.totalDetail').text()) || 0;
            totalVenta += total;
        });
        $('#total').text(totalVenta.toFixed(2));
        $('#totalInput').val(totalVenta.toFixed(2));
    }
    


    // VALIDACIONES

    // valida que la cantidad solicitada no supere el Stock
    function checkQuantity($row, cantidad, stock) {
        if (cantidad > stock || cantidad <= 0) {
            // si la cantidad es mayor al stock o la cantidad es menos o igual 0
            $row.find('input[name$="[Quantity]"]').addClass("is-invalid"); // agrega una clase al input que lo marca en rojo y retornamos false
            return false;
        } else {
            $row.find('input[name$="[Quantity]"]').removeClass("is-invalid");
            return true;
        }
    }

    function checkQuantities() {
        var valid = true; // esta variable la utilizamos para controlar lo que devuelva la funcion checkQuantity()

        $("#details-table tbody tr").each(function () {
            // iteramos cada fila
            var $row = $(this);
            var cantidad = parseFloat($row.find('input[name$="[Quantity]"]').val()) || 0; // obtenemos el valos de cantidad
            var stock = parseFloat($row.find(".productStock").text()) || 0; // obtenemos el valor del Stock
            if (!checkQuantity($row, cantidad, stock)) {
                // si retorna false la cantidad es mayor al stock
                valid = false; // canbiamos la variable a false
            }
        });

        return valid;
    }

    // valida que no hay productos repetidos
    function validateDuplicateProducts() {
        var products = []; // aquí guardamos los id de los productos
        var hasDuplicates = false;

        if ($("#details-table tbody tr").length === 0) {
            // si no existen filas no hay duplicados
            return true;
        }

        $("#details-table tbody tr").each(function () {
            // iteramos cada fila de la tabla
            var $row = $(this);
            var productID = $row.find(".product-select").val(); // recuperamos el id del producto (selectList de productos)

            if (products.includes(productID)) {
                // si la lista ya incluye este id significa que el producto está repetido
                $row.addClass("bg-danger"); // agrega una clase a la fila que la pinta en rojo
                hasDuplicates = true; // cambiamos la variable a true
            } else {
                $row.removeClass("bg-danger"); // remueve la clase del fondo rojo de la fila
                products.push(productID); // agrega el id a la lista
            }
        });

        // devolvemos true si no hay duplicados y false si los hay
        return !hasDuplicates;
    }

    // remueve la clase cuando se cambia el producto repetido
    $('#details-table').on('change', '.product-select', function() {
        var $row = $(this).closest('tr');
        $row.removeClass('bg-danger');
    });

    // valida que se agrege al menos 1 producto
    function hasProducts() {
        return $("#details-table tbody tr").length > 0; // si la longitud es mayor a cero retorna true (hay al menos un producto) si no false (no hay productos)
    }

    // funcion para extraer los detalles de venta
    function validSaleDetails() {
        let isValid = true;
        let message = "";

        $('#details-table tbody tr').each(function(index) {
            let row = $(this);
            let productID = row.find('.product-select').val();
            let quantity = row.find('input[name$="[Quantity]"]').val();
            let unitPrice = row.find('input[name$="[UnitPrice]"]').val();

            if (!productID || isNaN(productID) || isNaN(quantity) || isNaN(unitPrice) || quantity <= 0 || unitPrice < 0){
                isValid = false;
                message = `Fila ${index + 1}: Datos inválidos.`;
                return false;
            }
        });

        return { isValid, message };
    }
});
