<?php
session_start();
if ($_SESSION['user_name'] == "") {
    header("Location: ../../index.php");
    exit();
}

require_once('../Models/product.php');
require_once('../../conf/funciones.php');

$product = new Product();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product->book_name = isset($_POST['bookName']) ? $_POST['bookName'] : '';
    $product->stock = isset($_POST['stock']) ? $_POST['stock'] : 0;
    $product->purchase_price = isset($_POST['purchase_price']) ? $_POST['purchase_price'] : 0.00;
    $product->sale_price = isset($_POST['sale_price']) ? $_POST['sale_price'] : 0.00;
    $product->supplier_id = isset($_POST['supplier_id']) ? $_POST['supplier_id'] : '';

    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action == "ListProducts") {
        $result = $product->list_products();
        $html = '';

        if (!empty($result)) {
            foreach ($result as $row) {
                $html .= '<tr>';
                $html .= '<td>' . $row['id'] . '</td>';
                $html .= '<td>' . $row['bookName'] . '</td>';
                $html .= '<td>' . $row['stock'] . '</td>';
                $html .= '<td>' . $row['purchasePrice'] . '</td>';
                $html .= '<td>' . $row['salePrice'] . '</td>';
                $html .= '<td>' . $row['supplierName'] . '</td>';
                $html .= '<td>' . $row['createdAt'] . '</td>';
                $html .= '<td>' . $row['updatedAt'] . '</td>';
                $html .= '<td style="width: 80px;">
                    <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal" data-bs-id="' . $row['id'] . '"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-id="' . $row['id'] . '"><i class="fa fa-times"></i></a>
                    </td>';
                $html .= '</tr>';
            }
        }

        echo $html;
        exit();
    }

    if ($action == "GetProductById") {
        
        header('Content-Type: application/json');
        try {
            $result = $product->get_product_by_id($id);
            
            if (!empty($result)) {
                http_response_code(200);
                echo json_encode($result);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'producto no encontrado']);
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

    if ($action == "GetSuppliers"){
        $suppliers_list = $product->list_suppliers();
        $html = '<option value="">Seleccione un Proveedor</option>';
        foreach($suppliers_list as $row){
            $html .= '<option value="'. $row['id'] .'">' . $row['supplierName'] . '</option>';
        }
        echo $html;
        exit();
    }

    if ($action == "Create") {
        $isBookRegistered = $product->checkBook($product->book_name);
        header('Content-Type: application/json');

        if ($isBookRegistered > 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'El nombre del libro ya está en uso'
            ]);
            exit();
        } 

        if ($product->purchase_price > $product->sale_price) {
            echo json_encode([
                'status' => 'error',
                'message' => 'El precio de venta debe ser mayor al de compra'
            ]);
            exit();
        } 
        
        try {
            $result = $product->create();

            if ($result) {
                http_response_code(201);
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Libro creado con éxito'
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al agregar el libro'
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
        $isBookRegistered = $product->checkBook($product->book_name, $id);
        if ($isBookRegistered > 0) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'El nombre del libro ya está en uso'
            ]);
            exit();
        } 

        if ($product->purchase_price > $product->sale_price) {
            echo json_encode([
                'status' => 'error',
                'message' => 'El precio de venta debe ser mayor al de compra'
            ]);
            exit();
        } 
        
        try {
            $result = $product->update($id);

            if ($result) {
                http_response_code(200);
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Libro actualizado con éxito'
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al actualizar el libro'
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
        $result = $product->delete($id);
        header('Content-Type: application/json');
        try {
            if ($result) {
                http_response_code(200);
                echo json_encode([
                    'status' => 'error',
                    'message' => "Libro eliminado con exito"
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => "No se pudo eliminar el libro"
                ]);
            }
        }catch (Exception $e){
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage() 
            ]);
        }
        exit();
    }
}
?>
