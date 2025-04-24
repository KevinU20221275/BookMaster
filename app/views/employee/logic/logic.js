import { addEmployee, deleteEmployee, editEmployee, getEmployeeById, getRolesForSelect, listEmployees } from "../../../services/employee.js";
import { showAlert } from "../../assets/js/utils.js";
$(document).ready(function() {
    getData();

    $('#createModal').on('shown.bs.modal', function () {
        $('#role_id').select2({
            dropdownParent: $('#createModal'),
            placeholder: "Seleccione un rol"
        });
    });

    /* Función para cargar los datos de la tabla con AJAX */
    function getData() {
        let content = document.getElementById("content");

        if ($.fn.DataTable.isDataTable('#usersTable')) {
            $('#usersTable').DataTable().destroy();
        }

        listEmployees()
            .then(html => {
                content.innerHTML = html;

                $('#usersTable').DataTable({
                    pageLength: 25,
                    responsive: true,
                    columnDefs: [{
                        targets: [9],
                        orderable: false,
                        searchable: false
                    }]
                });
            })
            .catch(error => {
                console.error("Error fetching data:", error);
            });

        getRolesForSelect()
        .then((html) => {

            let selects = document.querySelectorAll('#role_id');

            selects.forEach((select) => {
                select.innerHTML = html;
            })
        })
    }


    // logica de los modales
    let createModal = document.getElementById("createModal");
    let updateModal = document.getElementById("updateModal");
    let deleteModal = document.getElementById("deleteModal");

    deleteModal.addEventListener("shown.bs.modal", (event) => {
        let button = event.relatedTarget;
        let id = button.getAttribute("data-bs-id");
        deleteModal.querySelector(".modal-footer #id").value = id;
    });

    deleteModal.addEventListener("submit", (event) => {
        event.preventDefault();

        let formData = new FormData(event.target);

        deleteEmployee(formData)
            .then((data) => {
                var bootstrapModal = bootstrap.Modal.getInstance(deleteModal);
                bootstrapModal.hide();
                getData();
                showAlert(data.message, 'danger');
            });
    });

    createModal.addEventListener("shown.bs.modal", (event) => {
        createModal.querySelector(".modal-body #firstName").focus();
    });

    createModal.addEventListener("submit", (event) => {
        event.preventDefault();

        let formData = new FormData(event.target);

        if (formData.get("password") != formData.get("rePassword")) {
            createModal.querySelector(".modal-body #errorMessage").innerText = "Las contraseñas no coinciden";
            return;
        }

        addEmployee(formData)
            .then((data) => {
                if (data.status == 'error') {
                    createModal.querySelector(".modal-body #errorMessage").innerText = data.message;
                } else if (data.status == 'success') {
                    var bootstrapModal = bootstrap.Modal.getInstance(createModal);
                    bootstrapModal.hide();

                    getData();
                    showAlert(data.message);
                }
            });
    });

    createModal.addEventListener("hide.bs.modal", (event) => {
        createModal.querySelector(".modal-body #firstName").value = "";
        createModal.querySelector(".modal-body #lastName").value = "";
        createModal.querySelector(
            ".modal-body #userName"
        ).value = "";
        createModal.querySelector(".modal-body #password").value = "";
        createModal.querySelector(".modal-body #email").value = "";
        createModal.querySelector(".modal-body #phone").value = "";
        createModal.querySelector(".modal-body #rePassword").value = "";
        createModal.querySelector(".modal-body #isEmployerEnabled").value = "";
        createModal.querySelector(".modal-body #role_id").value = "";
        createModal.querySelector(".modal-body #errorMessage").innerText = "";
    });


    updateModal.addEventListener("hide.bs.modal", (event) => {
        updateModal.querySelector(".modal-body #errorMessage").innerText = "";
    })


    updateModal.addEventListener("shown.bs.modal", (event) => {
        let button = event.relatedTarget;
        let id = button.getAttribute("data-bs-id");

        let inputId = updateModal.querySelector(".modal-body #id");
        let inputFirstName = updateModal.querySelector(".modal-body #firstName");
        let inputLastName = updateModal.querySelector(".modal-body #lastName");
        let inputUserName = updateModal.querySelector(".modal-body #userName");
        let inputEmail = updateModal.querySelector(".modal-body #email");
        let inputIsEmployerEnabled = updateModal.querySelector(".modal-body #isEmployerEnabled");
        let inputPhone = updateModal.querySelector(".modal-body #phone");
        let inputRole = updateModal.querySelector(".modal-body #role_id");

        getEmployeeById(id)
            .then((data) => {
                if (data?.status == "error"){
                    alert(data.message)
                    return
                }

                console.log(data)

                inputId.value = data.id || "";
                inputFirstName.value = data.firstName || "";
                inputLastName.value = data.lastName || "";
                inputUserName.value = data.username || "";
                inputEmail.value = data.email || "";
                inputPhone.value = data.phone || "";
                inputIsEmployerEnabled.value = data.isEmployerEnabled ? 'true' : 'false' || "";

                $('.role_id').select2({
                    dropdownParent: $('#updateModal')
                });

                $(inputRole).val(data.roleId).trigger('change');
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    });

    updateModal.addEventListener("submit", (event) => {
        event.preventDefault();

        let formData = new FormData(event.target);

        editEmployee(formData)
            .then((data) => {
                if (data.status == 'error'){
                    updateModal.querySelector(".modal-body #errorMessage").innerText = data.message;
                } else if (data.status == 'success'){
                    var bootstrapModal = bootstrap.Modal.getInstance(updateModal);
                    bootstrapModal.hide();

                    getData();
                    showAlert(data.message, 'warning');
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    });
})