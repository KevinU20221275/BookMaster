<?php
session_start();
if ($_SESSION['user_role'] != "Administrator") {
    header("Location: ../../index.php");
    exit();
}

require_once('../Models/employee.php');
require_once('../../conf/funciones.php');

$employee = new Employee();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee->first_name = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $employee->last_name = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $employee->username = isset($_POST['userName']) ? ($_POST['userName']) : '';
    $employee->email = isset($_POST['email']) ? $_POST['email'] : '';
    $employee->phone = isset($_POST['phone']) ? intval($_POST['phone']) : '';
    $employee->password = isset($_POST['password']) ?  md5($_POST['password']) : '';
    $employee->isEmployerEnabled = isset($_POST['isEmployerEnabled']) && $_POST['isEmployerEnabled'] === 'true' ? 1 : 0;
    $employee->role_id = isset($_POST['role_id']) ? $_POST['role_id'] : '';

    $id = isset($_POST['id']) ? $_POST['id'] : '';

    $action = isset($_POST['action']) ? $_POST['action'] : "";

    if ($action == "GetRoles") {
        $roles_list = $employee->list_roles();
        $html = '<option value="">Seleccione un rol</option>';
        
        foreach ($roles_list as $row) {
            $html .= '<option value="'.$row['id'].'">'. $row['roleName'] .'</option>';
        }
        echo $html;
    }

    if ($action == "ListEmployees") {
        $result = $employee->list_employees();

        $html = '';

        if (!empty($result)) {
            foreach ($result as $row) {
                $html .= '<tr>';
                $html .= '<td>' . $row['id'] . '</td>';
                $html .= '<td>' . $row['firstName'] . '</td>';
                $html .= '<td>' . $row['lastName'] . '</td>';
                $html .= '<td>' . $row['username'] . '</td>';
                $html .= '<td>' . ($row['isEmployerEnabled'] ? 'Habilitado' : 'Inhabilitado') . '</td>';
                $html .= '<td>' . $row['roleName'] . '</td>';
                $html .= '<td>' . $row['email'] . '</td>';
                $html .= '<td>' . $row['phone'] . '</td>';
                $html .= '<td>' . $row['createdAt'] . '</td>';
                $html .= '<td>' . $row['updatedAt'] . '</td>';
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

    if ($action == "GetEmployeeById") {
        header('Content-Type: application/json');

        try {
            $result = $employee->get_employee_by_id($id);
            if ($result) {
                http_response_code(200);
                echo json_encode($result);
            } else {
                http_response_code(404);
                echo json_encode(['error' => "No se encontró el empleado"]);
            }
        } catch(Exception $e){
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage() 
            ]);
        }
        exit();
    }

    if ($action == "Create") {
        header('Content-Type: application/json');

        $isUserRegitered = $employee->checkUser($employee->username, $employee->email);
        if ($isUserRegitered > 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'El nombre de usuario o correo electronico ya esta en uso'
            ]);
            exit;
        } 
        
        try {
            $result = $employee->create();
            if ($result) {
                http_response_code(201);
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Usuario agregado con exito'
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al agregar el usuario'
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
        
        $isUserRegitered = $employee->checkUser($employee->username, $employee->email, $id);
        
        header('Content-Type: application/json');
        if ($isUserRegitered > 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'El nombre de usuario o correo electronico ya esta en uso'
            ]);
            exit();
        } 

        try {
            $result = $employee->update($id);

            if ($result) {
                http_response_code(200);
                echo json_encode([
                    'status' =>'success',
                    'message' => 'Usuario actualizado con exito'
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al actualizar el usuario'
                ]);
            }
        } catch(Exception $e){
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
            $result = $employee->delete($id);
            if ($result) {
                http_response_code(200);
                echo json_encode([
                    'status' => 'success',
                    'message' => "Empleado eliminado con éxito"
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => "No se pudo eliminar el empleado"
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
}
