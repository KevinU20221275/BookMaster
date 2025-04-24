<?php
session_start();
if ($_SESSION['user_role'] != "Administrator") {
    http_response_code(403);
    header("Location: ../../index.php");
    exit();
}

require_once('../Models/role.php');
require_once('../../conf/funciones.php');

$role = new Role();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role->role_name = isset($_POST['roleName']) ? $_POST['roleName'] : '';
    $role->description = isset($_POST['description']) ? ($_POST['description']) : '';

    $id = isset($_POST['id']) ? $_POST['id'] : '';

    $action = isset($_POST['action']) ? $_POST['action'] : "";

    if ($action == "ListRoles") {
        $result = $role->list_roles();

        $html = '';

        if (!empty($result)) {
            foreach ($result as $row) {
                $html .= '<tr>';
                $html .= '<td>' . $row['id'] . '</td>';
                $html .= '<td>' . $row['roleName'] . '</td>';
                $html .= '<td>' . $row['description'] . '</td>';
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

    if ($action == "GetRoleById") {
        $result = $role->get_role_by_id($id);
        header('Content-Type: application/json');
        if ($result) {
            http_response_code(200);
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo json_encode(['error' => "No se encontró el rol"]);
        }
        exit();
    }

    if ($action == "Create") {
        $isRoleRegistered = $role->checkRole($role->role_name);
        header('Content-Type: application/json');
        if ($isRoleRegistered > 0) {
            http_response_code(409);
            echo json_encode([
               'status' => 'error',
               'message' => 'El nombre de rol ya esta en uso',
                'data' => [
                    'roleName' => $role->role_name,
                    'description' => $role->description
                ]
            ]);
            exit();
        } else {

            $result = $role->create();
            if ($result) {
                http_response_code(201);
                echo json_encode([
                   'status' => 'success',
                   'message' => 'Rol agregado con exito'
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                   'status' => 'error',
                   'message' => 'Error al agregar el rol'
                ]);
            }
            exit();
        }
    }

    if ($action == "Update") {
        $isRoleRegistered = $role->checkRole($role->role_name, $id);
        header('Content-Type: application/json');
        if ($isRoleRegistered > 0) {
            http_response_code(409);
            echo json_encode([
               'status' => 'error',
               'message' => 'El nombre de rol ya esta en uso',
                'data' => [
                    'id' => $id,
                    'roleName' => $role->role_name,
                    'description' => $role->description
                ]
            ]);
            exit();
        } else {
            $result = $role->update($id);
            if ($result) {
                http_response_code(200);
                echo json_encode([
                   'status' => 'success',
                   'message' => 'Rol actualizado con exito'
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                   'status' => 'error',
                   'message' => 'Error al actualizar el rol'
                ]);
            }
            exit();
        }
    }

    if ($action == "Delete") {
        try {
            $result = $role->delete($id);
            if ($result) {
                http_response_code(200);
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Rol eliminado con éxito'
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No se pudo eliminar el rol'
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage() // o un mensaje personalizado
            ]);
        }
        exit();
    }
}
