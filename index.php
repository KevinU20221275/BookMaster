<?php
$error = "";
require_once('conf/funciones.php');
require_once(__DIR__ . '/app/Models/login.php');

$user = new Login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->username = isset($_POST['user_name']) ? $_POST['user_name'] : "";
    $user->password = isset($_POST['password']) ? $_POST['password'] : "";

    if (hasEmptyField([$user->username, $user->password])) {
        $error = "Debe llenar todos los campos";
    } else {
        $userData = $user->get_user();

        if (empty($userData)) {
          $error = "Usuario o Contraseña incorrectos";
        } else {
            if ($userData['isEmployerEnabled'] == 0) {
              $error = "Usuario inhabilitado";
            } else {
              session_start();
              $_SESSION['user_id'] = $userData['id'];
              $_SESSION['user_name'] = $userData['firstName'];
              $_SESSION['user'] = $userData['username'];
              $_SESSION['user_role'] = $userData['roleName'];
              $_SESSION['user_email'] = $userData['email'];
              $_SESSION['user_phone'] = $userData['phone'];

              header("Location: app/index.php");
              exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Book Master | Login</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"
    />
    <link rel="icon" href="app/views/assets/img/favicon.ico" type="image/x-icon"/>

    <!-- Fonts and icons -->
    <script src="app/views/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["app/views/assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="app/views/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="app/views/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="app/views/assets/css/kaiadmin.min.css" />

</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">

        <!-- Sign In Start -->
        <div class="container">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <form action="index.php" method="post" style="max-width: 600px;" class="card rounded">
                    <div class="p-4 pb-1 my-4 mb-2 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                          <h3 class="text-primary"><i class="fa fa-solid fa-swatchbook me-2"></i>Book Master</h3>
                        </div>
                        <div class="form-group mb-3">
                            <label for="username">Nombre de Usuario</label>
                            <input
                              type="text"
                              class="form-control"
                              placeholder="Usuario"
                              aria-label="Username"
                              aria-describedby="basic-addon1"
                              name="user_name"
                            />
                          </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input
                              type="password"
                              class="form-control"
                              id="password"
                              placeholder="Contraseña"
                              name="password"
                            />
                          </div>
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Ingresar</button>
                        <p class="text-center text-danger mt-0"><?= $error ?></p>
                    </div>
                </form>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>