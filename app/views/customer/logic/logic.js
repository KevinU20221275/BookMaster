import { addCustomer, deleteCustomer, editCustomer, getCustomerById, listCustomers } from "../../../services/customer.js";
import { showAlert } from "../../assets/js/utils.js";

$(document).ready(function() {
    getData();

    /* Función para cargar los datos con AJAX */
    function getData() {
        let content = document.getElementById("content");
        
        if ($.fn.DataTable.isDataTable('#clientsTable')) {
            $('#clientsTable').DataTable().destroy();
        }

        listCustomers()
            .then(html => {
                content.innerHTML = html;

                $('#clientsTable').DataTable({
                    pageLength: 25,
                    responsive: true,
                    columnDefs: [{
                        targets: [5], // Cambia este índice según tu tabla
                        orderable: false,
                        searchable: false
                    }]
                });
            })
            .catch(error => {
                console.error("Error fetching data:", error);
            });
    }

    // modales
    let createModal = document.getElementById('createModal');
    let updateModal = document.getElementById('updateModal');
    let deleteModal = document.getElementById('deleteModal');

    // modal agregar
    createModal.addEventListener('shown.bs.modal', event => {
        createModal.querySelector('.modal-body #firstName').focus();
    });

    createModal.addEventListener('submit', (event) => {
        event.preventDefault();

        let formData = new FormData(event.target);

        addCustomer(formData)
            .then(data => {
                if (data.status == 'error') {
                    createModal.querySelector('.modal-body #errorMessage').innerText = data.message;
                } else if (data.status == 'success') {
                    createModal.querySelector('.modal-body #errorMessage').innerText = "";

                    var bootstrapModal = bootstrap.Modal.getInstance(createModal);
                    bootstrapModal.hide();

                    getData();
                    showAlert(data.message);
                }
            });
    });

    createModal.addEventListener('hide.bs.modal', event => {
        createModal.querySelector('.modal-body #firstName').value = "";
        createModal.querySelector('.modal-body #lastName').value = "";
        createModal.querySelector('.modal-body #address').value = "";
        createModal.querySelector('.modal-body #email').value = "";
        createModal.querySelector('.modal-body #phone').value = "";
    });

    // lógica modal actualizar
    updateModal.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-bs-id');

        let inputId = updateModal.querySelector('.modal-body #id');
        let inputFirstName = updateModal.querySelector('.modal-body #firstName');
        let inputLastName = updateModal.querySelector('.modal-body #lastName');
        let inputAddress = updateModal.querySelector('.modal-body #address');
        let inputEmail = updateModal.querySelector('.modal-body #email');
        let inputPhone = updateModal.querySelector('.modal-body #phone');

        getCustomerById(id)
            .then(data => {
                if (data?.status == "error"){
                    alert(data.message)
                    return
                }

                inputId.value = data.id || '';
                inputFirstName.value = data.firstName || '';
                inputLastName.value = data.lastName || '';
                inputAddress.value = data.address || '';
                inputEmail.value = data.email || '';
                inputPhone.value = data.phone || '';
            }).catch(error => {
                console.error('Error:', error);
            });
    });

    updateModal.addEventListener('submit', event => {
        event.preventDefault();

        let formData = new FormData(event.target);

        editCustomer(formData)
            .then(data => {
                if (data.status == 'error') {
                    updateModal.querySelector(".modal-body #errorMessage").innerText = data.message;
                } else if (data.status == 'success') {
                    updateModal.querySelector(".modal-body #errorMessage").innerText = '';

                    var bootstrapModal = bootstrap.Modal.getInstance(updateModal);
                    bootstrapModal.hide();

                    showAlert(data.message, 'warning');
                    getData();
                }
            }).catch(error => {
                console.error('Error:', error);
            });
    });

    // lógica modal eliminar
    deleteModal.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-bs-id');
        deleteModal.querySelector('.modal-footer #id').value = id;
    });

    deleteModal.addEventListener('submit', event => {
        event.preventDefault();

        let formData = new FormData(event.target);

        console.log("Eliminar")

        deleteCustomer(formData)
            .then(data => {
                var bootstrapModal = bootstrap.Modal.getInstance(deleteModal);
                bootstrapModal.hide();
                if (data.status == "error"){
                    getData();
                }
                console.log(data)
                showAlert(data.message, 'danger');
            });
    });
});