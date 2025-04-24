<?php
session_start();
if ($_SESSION['user_role'] != "Administrator") {
    header("Location: ../../index.php");
    exit();
}

require_once(__DIR__ . '/../../conf/conf.php');

class Employee extends Conf {
    public $id;

    public $first_name;

    public $last_name;

    public $username;

    public $email;

    public $phone;

    public $password;

    public $isEmployerEnabled;

    public $role_id;

    public function list_roles(){
        $query = "SELECT id, roleName FROM role";

        $result = $this->exec_query($query);

        if ($result){
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    public function create(){
        $query = "INSERT INTO employee (firstName, lastName, username, email, phone, password, isEmployerEnabled, roleId) VALUES (:firstName, :lastName, :username, :email, :phone, :password, :isEmployerEnabled, :roleId)";
        $params = [
            ':firstName' => $this->first_name,
            ':lastName' => $this->last_name,
            ':username' => $this->username,
            ':email' => $this->email,
            ':phone' => $this->phone,
            ':password' => $this->password,
            ':isEmployerEnabled' => $this->isEmployerEnabled,
            ':roleId' => $this->role_id
        ];

        return $this->exec_query($query, $params);
    }

    public function get_employee_by_id($id){
        $query = "SELECT id, firstName, lastName, username, email, phone, isEmployerEnabled, roleId FROM employee WHERE id = :id";
        $params = [':id' => $id];

        $result = $this->exec_query($query, $params);

        if ($result){
            return $result->fetch(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }


    public function list_employees(){
        $query = "SELECT A.id, firstName, lastName, username, isEmployerEnabled, B.roleName, email, phone, A.createdAt, A.updatedAt FROM employee AS A INNER JOIN role AS B 
        ON A.roleId = B.id";

        $result = $this->exec_query($query);

        if ($result){
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    public function update($id){
        $query = "UPDATE employee SET
            firstName = :firstName,
            lastName = :lastName, 
            username = :username,
            email = :email,
            phone = :phone,
            isEmployerEnabled = :isEmployerEnabled,
            roleId = :roleId
            WHERE id = :id";

        $params = [
            ':id' => $id,
            ':firstName' => $this->first_name,
            ':lastName' => $this->last_name,
            ':username' => $this->username,
            ':email' => $this->email,
            ':phone' => $this->phone,
            ':isEmployerEnabled' => $this->isEmployerEnabled,
            ':roleId' => $this->role_id
        ];

        return $this->exec_query($query,$params);

    }

    public function checkUser($username, $email, $id = null){
        if ($id == null){
            $query = "SELECT COUNT(*) AS total FROM employee WHERE username = :username OR email = :email";
            $params = [':username' => $username, ':email' => $email];
        } else {
            $query = "SELECT COUNT(*) AS total FROM employee WHERE (username = :username OR email = :email) AND id != :id";
            $params = [':username' => $username, ':email' => $email, ':id' => $id];
        }

        $result = $this->exec_query($query, $params);

        if ($result){
            return $result->fetch(PDO::FETCH_ASSOC)['total'];
        } else {
            return 0;
        }
    }

    public function delete($id){
        $query = "DELETE FROM employee WHERE id = :id";
        $params = [':id' => $id];

        return $this->exec_query($query,$params);
    }

}
