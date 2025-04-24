<?php
session_start();
if ($_SESSION['user_name'] == "") {
    header("Location: ../../index.php");
    exit();
}

require_once(__DIR__ . '/../../conf/conf.php');


class Sale extends Conf {
    public $id;
    public $date;
    public $employee_id;
    public $customer_id;
    public $total;

    public function create(){
        $query = "INSERT INTO sale (date, employeeId, customerId, total) VALUES (:date, :employeeId, :customerId, :total)";
        $params = [
            ':date' => $this->date,
            ':employeeId' => $this->employee_id,
            ':customerId' => $this->customer_id,
            ':total' => $this->total
        ];

        $result = $this->exec_query($query, $params);

        if ($result){
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function list_sales(){
        $query = "SELECT a.id, b.firstName as employee, c.firstName as customer, total,date FROM sale as a INNER JOIN employee as b
        on a.employeeId = b.id INNER JOIN customer as c 
        on a.customerId = c.id ORDER BY a.id DESC";

        $result = $this->exec_query($query);

        if ($result){
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    public function list_products(){
        $query = "SELECT id, bookName, salePrice FROM product";

        $result = $this->exec_query($query);

        if ($result){
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    public function list_customer(){
        $query = "SELECT id, CONCAT(firstName, ' ', lastName) AS fullName FROM customer";

        $result = $this->exec_query($query);

        if ($result){
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    public function get_product_by_id($id){
        $query = "SELECT id, bookName, salePrice, stock FROM product WHERE id = :id";
        $params = [':id' => $id];

        $result = $this->exec_query($query, $params);

        if ($result){
            return $result->fetch(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    public function update($id){
        $query = "UPDATE sale SET
            date = :date,
            employeeId = :employeeId,
            customerd = :customerId,
            total = :total
            WHERE id = :id";

        $params = [
            ':id' => $id,
            ':date' => $this->date,
            ':employeeId' => $this->employee_id,
            ':customerId' => $this->customer_id,
            ':total' => $this->total
        ];

        return $this->exec_query($query,$params);
    }

    public function delete($id){
        $query = "DELETE FROM sale WHERE id = :id";
        $params = [':id' => $id];

        return $this->exec_query($query,$params);
    }

    public function get_sale_details_id($id) {
        $query = "SELECT b.bookName, b.salePrice, a.quantity, b.salePrice * a.quantity AS subtotal FROM salesDetail AS a INNER JOIN product AS b 
        ON a.productId = b.id WHERE a.saleId = :id";

        $params = [':id' => $id];

        $result = $this->exec_query($query, $params);

        if ($result){
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    public function add_details($details) {
        $query = "INSERT INTO salesDetail (saleId, productId, quantity, unitPrice) VALUES (:saleId, :productId, :quantity, :unitPrice)";

        // Consulta para actualizar el stock del inventario
        $updateStockQuery = "UPDATE product SET stock = stock - :quantity WHERE id = :productId";

        foreach ($details as $detail) {
            $params = [
                ':saleId' => $this->id,
                ':productId' => $detail['productId'],
                ':quantity' => $detail['quantity'],
                ':unitPrice' => $detail['unitPrice']
            ];

            // Ejecutar la inserción de cada detalle
            $this->exec_query($query, $params);

            // Actualizar el stock después de la venta
            $stockParams = [
                ':productId' => $detail['productId'],
                ':quantity' => $detail['quantity']
            ];
            $this->exec_query($updateStockQuery, $stockParams);
        }

        return true;
    }


}