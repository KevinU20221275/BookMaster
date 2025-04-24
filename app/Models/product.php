<?php
session_start();
if ($_SESSION['user_name'] == "") {
    header("Location: ../../index.php");
    exit();
}

require_once('../../conf/conf.php');

class Product extends Conf {
    public $id;
    public $book_name;
    public $stock;
    public $purchase_price;
    public $sale_price;
    public $supplier_id;

    public function create() {
        $query = "INSERT INTO product (bookName, stock, purchasePrice, salePrice, supplierId) VALUES (:bookName, :stock, :purchasePrice, :salePrice, :supplierId)";
        $params = [
            ':bookName' => $this->book_name,
            ':stock' => $this->stock,
            ':purchasePrice' => $this->purchase_price,
            ':salePrice' => $this->sale_price,
            ':supplierId' => $this->supplier_id
        ];

        return $this->exec_query($query, $params);
    }

    public function get_product_by_id($id) {
        $query = "SELECT id, bookName, stock, purchasePrice, salePrice, supplierId FROM product WHERE id = :id";
        $params = [':id' => $id];

        $result = $this->exec_query($query, $params);

        if ($result) {
            return $result->fetch(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    public function list_products() {
        $query = "SELECT A.id, bookName, stock, purchasePrice, salePrice, B.supplierName , A.createdAt, A.updatedAt FROM product AS A INNER JOIN supplier AS B ON A.supplierId = B.id";

        $result = $this->exec_query($query);

        if ($result) {
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    public function update($id) {
        $query = "UPDATE product SET
            bookName = :bookName,
            stock = :stock,
            purchasePrice = :purchasePrice,
            salePrice = :salePrice,
            supplierId = :supplierId
            WHERE id = :id";

        $params = [
            ':id' => $id,
            ':bookName' => $this->book_name,
            ':stock' => $this->stock,
            ':purchasePrice' => $this->purchase_price,
            ':salePrice' => $this->sale_price,
            ':supplierId' => $this->supplier_id
        ];

        return $this->exec_query($query, $params);
    }

    public function delete($id) {
        $query = "DELETE FROM product WHERE id = :id";
        $params = [':id' => $id];

        return $this->exec_query($query, $params);
    }

    public function checkBook($bookName, $id = null) {
        $query = "SELECT COUNT(*) as total FROM product WHERE bookName = :bookName";
        $params = [':bookName' => $bookName];

        if ($id) {
            $query .= " AND id != :id";
            $params[':id'] = $id;
        }

        $result = $this->exec_query($query, $params);

        if ($result) {
            return $result->fetch(PDO::FETCH_ASSOC)['total'];
        } else {
            return 0;
        }
    }

    public function list_suppliers(){
        $query = "SELECT id, supplierName FROM supplier";

        $result = $this->exec_query($query);

        if ($result){
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }
}
?>
