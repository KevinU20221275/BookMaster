<?php
session_start();
if ($_SESSION['user_name'] == "") {
    header("Location: ../../index.php");
    exit();
}

require_once('../Models/sale.php');
require_once('../../conf/funciones.php');

$sale = new Sale();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sale->employee_id = $_SESSION['user_id'];
    $sale->customer_id = isset($_POST['customer_id']) ? ($_POST['customer_id']) : '';
    $sale->date = date('Y-m-d H:i:s');
    $sale->total = isset($_POST['totalInput']) ? $_POST['totalInput'] : "";

    $id = isset($_POST['id']) ? $_POST['id'] : '';

    $action = isset($_POST['action']) ? $_POST['action'] : "";

    if ($action == "ListSales") {
        $result = $sale->list_sales();

        $html = '';

        if (!empty($result)) {
            foreach ($result as $row) {
                $html .= '<tr>';
                $html .= '<td>' . $row['id'] . '</td>';
                $html .= '<td>' . $row['employee'] . '</td>';
                $html .= '<td>' . $row['customer'] . '</td>';
                $html .= '<td>' . $row['total'] . '</td>';
                $html .= '<td>' . $row['date'] . '</td>';
                $html .= '<td>
                    <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#saleDetailsModal" data-bs-id="' . $row['id'] . '"><i class="fa fa-info"></i></a>
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

    if ($action == "GetSaleDetails"){
        $html = "";
        $sale_result = $sale->get_sale_details_id($id);

        if (!empty($sale_result)) {
            foreach ($sale_result as $row) {
                $html .= '<tr>';
                $html .= '<td>' . $row['bookName'] . '</td>';
                $html .= '<td>' . $row['salePrice'] . '</td>';
                $html .= '<td>' . $row['quantity'] . '</td>';
                $html .= '<td>' . $row['subtotal'] . '</td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr>';
            $html .= '<td colspan="7">Sin resultados</td>';
            $html .= '</tr>';
        }
        echo $html;
    }

    if ($action == "GetProducts") {
        $product_list = $sale->list_products();
        $html = '<option value="">Seleccione un producto</option>';
        foreach($product_list as $row){
            $html .= '<option value="'. $row['id'] .'">' . $row['bookName'] . '</option>';
        }
        echo $html;
    }

    if ($action == "GetProductById"){
        $product_id = isset($_POST['product_id'])? $_POST['product_id'] : '';
        $product_result = $sale->get_product_by_id($product_id);
        echo json_encode($product_result);
    }

    if ($action == "GetCustomers"){
        $client_list = $sale->list_customer();
        $html = '<option value="">Seleccione un cliente</option>';
        foreach($client_list as $row){
            $html .= '<option value="'. $row['id'] .'">' . $row['fullName'] . '</option>';
        }
        echo $html;
    }

    if ($action == "Create") {
        header('Content-Type: application/json');

        if (!ctype_digit($sale->customer_id) || $sale->customer_id == 0){
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'El cliente es inválido'
            ]);
            exit;
        }

        $isValid = true;
        $saleDetails = [];

        $array = $_POST['SaleDetails'];

        foreach ($array as $item){
            if (!ctype_digit($item['ProductID']) || !ctype_digit($item['Quantity']) || !is_numeric($item['UnitPrice'])){
                $isValid = false;
                break;
            }

            $saleDetails[] = [
                'productId' => $item['ProductID'],
                'quantity' => $item['Quantity'],
                'unitPrice' => $item['UnitPrice']
            ];
        }

        if (!$isValid || empty($saleDetails)){
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Los detalles de la venta son inválidos o están vacíos'
            ]);
            exit;
        }

        $saleId = $sale->create();

        if ($saleId){
            $sale->id = $saleId;

            if($sale->add_details($saleDetails)){
                http_response_code(201);
                echo json_encode([
                   'status' =>'success',
                   'message' => 'Venta registrada con éxito'
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                   'status' => 'error',
                   'message' => 'Error al registrar los detalles de la venta'
                ]);
            }
        } else {
            http_response_code(500);
            echo json_encode([
               'status' => 'error',
               'message' => 'Error al registrar la venta'
            ]);
        }
    }

    if ($action == "Delete"){
        $result = $sale->delete($id);

        if ($result){
            echo 'Venta eliminada con éxito';
        } else {
            echo 'Error al eliminar la venta';
        }
        exit();
    }
}
