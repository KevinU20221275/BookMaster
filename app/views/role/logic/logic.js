import { addRole, deleteRole, editRole, getRoleById, listRoles } from "../../../services/roles.js";
import { showAlert } from "../../assets/js/utils.js";

$(document).ready(function() {
    getData();

    /* Función para cargar los datos con AJAX */
    function getData() {
        let content = document.getElementById("content");

        if ($.fn.DataTable.isDataTable('#rolesTable')) {
            $('#rolesTable').DataTable().destroy();
        }

        listRoles().then((html) => {
            content.innerHTML = html

            $('#rolesTable').DataTable({
                pageLength: 25,
                responsive: true,
                columnDefs: [{
                    targets: [3],
                    orderable: false,
                    searchable: false
                }]
            });
        }).catch((error) => console.log(error))
    }

    // modales
    let createModal = document.getElementById('createModal')
    let updateModal = document.getElementById('updateModal')
    let deleteModal = document.getElementById('deleteModal')

    // modal agregar
    createModal.addEventListener('shown.bs.modal', event => {
        createModal.querySelector('.modal-body #roleName').focus()
    })

    createModal.addEventListener('submit', (event) => {
        event.preventDefault();

        let formData = new FormData(event.target);

        addRole(formData).then((data) => {
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
        createModal.querySelector('.modal-body #roleName').value = ""
        createModal.querySelector('.modal-body #description').value = ""
    })


    // logica modal actualizar
    updateModal.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-bs-id')

        let inputId = updateModal.querySelector('.modal-body #id')
        let inputRoleName = updateModal.querySelector('.modal-body #roleName')
        let inputDescription = updateModal.querySelector('.modal-body #description')

        getRoleById(id).then((data) => {
            inputId.value = data.id || '';
            inputRoleName.value = data.roleName || '';
            inputDescription.value = data.description || '';
        }).catch(error => {
            console.error('Error:', error);
        });

    })


    updateModal.addEventListener('submit', event => {
        event.preventDefault();

        let formData = new FormData(event.target)
        
        editRole(formData)
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

    // logica modal eliminar
    deleteModal.addEventListener('shown.bs.modal', event => {
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id')
        deleteModal.querySelector('.modal-footer #id').value = id
    })

    deleteModal.addEventListener('submit', event => {
        event.preventDefault();

        let formData = new FormData(event.target)

        deleteRole(formData).then(data => {
            var bootstrapModal = bootstrap.Modal.getInstance(deleteModal);
            bootstrapModal.hide();
            if (data.status !== "error"){
                getData();
            }
            showAlert(data.message, 'danger');
        }).catch((error) => console.log(error))
    })
})