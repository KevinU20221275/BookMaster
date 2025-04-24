<?php
session_start();
if ($_SESSION['user_name'] == "") {
    header("Location: ../../index.php");
    exit();
}

require_once('../Models/customer.php');
require_once('../../conf/funciones.php');

$customer = new Customer();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer->firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $customer->lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $customer->address = isset($_POST['address']) ? $_POST['address'] : '';
    $customer->email = isset($_POST['email']) ? $_POST['email'] : '';
    $customer->phone = isset($_POST['phone']) ? $_POST['phone'] : '';

    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $action = isset($_POST['action']) ? $_POST['action'] : "";

    if ($action == "ListCustomers") {
        $result = $customer->list_customers();
        $html = '';

        if (!empty($result)) {
            foreach ($result as $row) {
                $html .= '<tr>';
                $html .= '<td>' . $row['id'] . '</td>';
                $html .= '<td>' . $row['firstName'] . '</td>';
                $html .= '<td>' . $row['lastName'] . '</td>';
                $html .= '<td>' . $row['address'] . '</td>';
                $html .= '<td>' . $row['email'] . '</td>';
                $html .= '<td>' . $row['phone'] . '</td>';
                $html .= '<td>
                    <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal" data-bs-id="' . $row['id'] . '"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-id="' . $row['id'] . '"><i class="fa fa-times"></i></a>
                  </td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr>';
            $html .= '<td colspan="7">Sin resultados</td>';
            $html .= '</tr>';
        }

        echo $html;
        exit();
    }

    if ($action == "GetCustomerById") {
        try {
            $result = $customer->get_customer_by_id($id);

            header('Content-Type: application/json');
            if ($result) {
                http_response_code(200);
                echo json_encode($result);
            } else {
                http_response_code(404);
                echo json_encode(['error' => "No se encontró el cliente"]);
            }
        } catch (Exception $e){
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage() 
            ]);
        }
        exit();
    }

    if ($action == "Create") {
        $isCustomerRegitered = $customer->checkCustomer($customer->email);

        header('Content-Type: application/json');
        if ($isCustomerRegitered > 0) {
            http_response_code(409);
            echo json_encode([
               'status' => 'error',
               'message' => 'El email del cliente ya esta en uso',
                'data' => [
                    'email' => $customer->email
                ]
            ]);
            exit();
        } 
        
        try {
            $result = $customer->create();

            if ($result) {
                http_response_code(200);
                echo json_encode([
                   'status' => 'success',
                   'message' => 'Cliente agregado con exito'
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                   'status' => 'error',
                   'message' => 'Error al agregar el cliente'
                ]);
            }
            exit();
        } catch (Exception $e){
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage() 
            ]);
        }
    }

    if ($action == "Update") {
        $isCustomerRegitered = $customer->checkCustomer($customer->email, $id);
        header('Content-Type: application/json');
        if ($isCustomerRegitered > 0) {
            http_response_code(409);
            echo json_encode([
               'status' => 'error',
               'message' => 'El email del cliente ya esta en uso'
            ]);
            exit();
        } 
        
        try {
            $result = $customer->update($id);
            if ($result) {
                http_response_code(200);
                echo json_encode([
                   'status' => 'success',
                   'message' => 'Cliente actualizado con exito'
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                   'status' => 'error',
                   'message' => 'Error al actualizar el cliente'
                ]);
            }
        } catch (Exception $e){
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage() 
            ]);
        }
        exit();
    }

    if ($action == "Delete") {
        header('Content-Type: application/json');
        try {
            $result = $customer->delete($id);

            if ($result) {
                http_response_code(200);
                echo json_encode([
                    'status' => 'success',
                    'message' => "Cliente eliminado con éxito"
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al eliminar el cliente'
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
        exit();
    }
}
