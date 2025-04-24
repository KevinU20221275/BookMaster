import { addProduct, deleteProduct, editProduct, getProductById, getSuppliersForSelect, listProducts } from "../../../services/products.js";
import { showAlert } from "../../assets/js/utils.js";

$(document).ready(function() {
    getData();

    $('#createModal').on('shown.bs.modal', function () {
        $('#supplier_id').select2({
            dropdownParent: $('#createModal')
        });
    });

    /* Función para cargar los datos con AJAX */
    function getData() {
        let content = document.getElementById("content");
        
        if ($.fn.DataTable.isDataTable('#inventoryTable')) {
            $('#inventoryTable').DataTable().destroy();
        }

        listProducts()
            .then(html => {
                content.innerHTML = html;

                $('#inventoryTable').DataTable({
                    pageLength: 25,
                    responsive: true,
                    columnDefs: [{
                        targets: [8],
                        orderable: false,
                        searchable: false
                    },{
                        targets: [7],
                        orderable: false,
                        searchable: false
                    },{
                        targets: [6],
                        orderable: false,
                        searchable: false
                    }]
                });


            })
            .catch(error => {
                console.error("Error fetching data:", error);
            });

        getSuppliersForSelect()
        .then(data => {
            let selects = document.querySelectorAll('#supplier_id');

            selects.forEach((select) => {
                select.innerHTML = data;
            })
        })
        .catch(error => {
            console.error('Error fetching roles:', error);
        });
    }

    // modales
    let createModal = document.getElementById('createModal')
    let updateModal = document.getElementById('updateModal')
    let deleteModal = document.getElementById('deleteModal')

    // modal agregar
    createModal.addEventListener('shown.bs.modal', event => {
        createModal.querySelector('.modal-body #bookName').focus()
    })

    createModal.addEventListener('submit', (event) => {
        event.preventDefault();

        let formData = new FormData(event.target);
        
        addProduct(formData)
            .then(data => {
                if (data.status == 'error'){
                    createModal.querySelector('.modal-body #errorMessage').innerText = data.message;
                } else if (data.status == 'success'){
                    createModal.querySelector('.modal-body #errorMessage').innerText = "";

                    var bootstrapModal = bootstrap.Modal.getInstance(createModal);
                    bootstrapModal.hide();

                    getData()
                    showAlert(data.message);
                }
            })
    })

    createModal.addEventListener('hide.bs.modal', event => {
        createModal.querySelector('.modal-body #bookName').value = ""
        createModal.querySelector('.modal-body #stock').value = ""
        createModal.querySelector('.modal-body #purchase_price').value = ""
        createModal.querySelector('.modal-body #sale_price').value = "";
        createModal.querySelector('.modal-body #supplier_id').value = "";
    })


    // logica modal actualizar
    updateModal.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-bs-id')

        let inputId = updateModal.querySelector('.modal-body #id')
        let inputBookName = updateModal.querySelector('.modal-body #bookName')
        let inputStock = updateModal.querySelector('.modal-body #stock')
        let inputPurchase_price = updateModal.querySelector('.modal-body #purchase_price')
        let inputSale_price = updateModal.querySelector('.modal-body #sale_price')
        let inputSupplier_id = updateModal.querySelector('.modal-body #supplier_id')

        getProductById(id)
            .then(data => {
                if (data.status == "error"){
                    alert(data.message)
                    return
                }

                inputId.value = data.id || '';
                inputBookName.value = data.bookName || '';
                inputStock.value = data.stock || '';
                inputPurchase_price.value = data.purchasePrice || '';
                inputSale_price.value = data.salePrice || '';

                $('.supplier_id').select2({
                    dropdownParent: $('#updateModal')
                });

                $(inputSupplier_id).val(data.supplierId).trigger('change');

            }).catch(error => {
                console.error('Error:', error);
            });
    })


    updateModal.addEventListener('submit', event => {
        event.preventDefault();

        let formData = new FormData(event.target)
        
        editProduct(formData)
            .then(data => {
                if (data.status == 'error'){
                    updateModal.querySelector(".modal-body #errorMessage").innerText = data.message;
                } else if (data.status == 'success') {
                    updateModal.querySelector(".modal-body #errorMessage").innerText = '';
                    
                    var bootstrapModal = bootstrap.Modal.getInstance(updateModal);
                    bootstrapModal.hide();

                    showAlert(data.message, 'warning');
                    getData()
                }
            }).catch(error => {
                console.error('Error:', error);
            });
    })

    updateModal.addEventListener('hide.bs.modal', event => {
        updateModal.querySelector('.modal-body #bookName').value = ""
        updateModal.querySelector('.modal-body #stock').value = ""
        updateModal.querySelector('.modal-body #purchase_price').value = ""
        updateModal.querySelector('.modal-body #sale_price').value = "";
        updateModal.querySelector('.modal-body #supplier_id').value = "";
    })

    // logica modal eliminar
    deleteModal.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id')
        deleteModal.querySelector('.modal-footer #id').value = id
    })

    deleteModal.addEventListener('submit', event => {
        event.preventDefault();

        let formData = new FormData(event.target)

        var bootstrapModal = bootstrap.Modal.getInstance(deleteModal);
        bootstrapModal.hide();

        deleteProduct(formData)
            .then(data => {
                getData();
                showAlert(data.message,'danger');
            })
    })
})