<?php
session_start();
if ($_SESSION['user_name'] == "") {
    header("Location: ../../index.php");
    exit();
}

require_once('../Models/supplier.php');
require_once('../../conf/funciones.php');

$supplier = new Supplier();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $supplier->supplier_name = isset($_POST['supplierName']) ? $_POST['supplierName'] : '';
    $supplier->email = isset($_POST['email']) ? $_POST['email'] : '';
    $supplier->phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $supplier->address = isset($_POST['address']) ? $_POST['address'] : '';
    $supplier->city = isset($_POST['city']) ? $_POST['city'] : '';

    $id = isset($_POST['id']) ? $_POST['id'] : '';

    $action = isset($_POST['action']) ? $_POST['action'] : "";

    if ($action == "ListSuppliers") {
        $result = $supplier->list_suppliers();

        $html = '';

        if (!empty($result)) {
            foreach ($result as $row) {
                $html .= '<tr>';
                $html .= '<td>' . $row['id'] . '</td>';
                $html .= '<td>' . $row['supplierName'] . '</td>';
                $html .= '<td>' . $row['email'] . '</td>';
                $html .= '<td>' . $row['address'] . '</td>';
                $html .= '<td>' . $row['city'] . '</td>';
                $html .= '<td>' . $row['phone'] . '</td>';
                $html.= '<td>' . $row['createdAt'] . '</td>';
                $html.= '<td>' . $row['updatedAt'] . '</td>';
                $html .= '<td style="width: 80px">
                    <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal" data-bs-id="' . $row['id'] . '"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-id="' . $row['id'] . '"><i class="fa fa-times"></i></a>
                    </td>';
                $html .= '</tr>';
            };
        }

        echo $html;
        exit();
    }

    if ($action == "GetSupplierById") {
        try {
            $result = $supplier->get_supplier_by_id($id);
            
            if (!empty($result)) {
                http_response_code(200);
                echo json_encode($result);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'No se encontro el proveedor']);
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
        $isSupplierRegistered = $supplier->checkSupplier();
        header('Content-Type: application/json');

        if ($isSupplierRegistered > 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'El nombre de proveedor ya esta en uso'
            ]);
            exit();
        } 
        
        try {
            $result = $supplier->create();

            if ($result) {
                http_response_code(201);
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Proveedor creado con exito'
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al agregar el Proveedor'
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

    if ($action == "Update") {
        $isSupplierRegistered = $supplier->checkSupplier($id);
        header('Content-Type: application/json');

        if ($isSupplierRegistered > 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'El nombre de proveedor ya esta en uso'
            ]);
            exit();
        } 

        try {
            $result = $supplier->update($id);

            if ($result) {
                http_response_code(200);
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Proveedor actualizado con exito'
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al actualizar el Proveedor'
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
            $result = $supplier->delete($id);
            
            if ($result) {
                http_response_code(200);
                echo json_encode([
                    'status' => 'error',
                    'message' => "Proveedor eliminado con exito"
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => "No se pudo eliminar el Proveedor"
                ]);
                echo '';
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
}
