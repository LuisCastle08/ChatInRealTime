<?php

session_start();
include_once "config.php";

$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {
            echo "$email - Este correo ya existe!";
        } else {
            if (isset($_FILES['image'])) {
                $img_name = $_FILES['image']['name'];
                $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];
                
                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode);

                $extensions = ["jpeg", "png", "jpg"];
                if (in_array($img_ext, $extensions) === true) {
                    $types = ["image/jpeg", "image/jpg", "image/png"];
                    if (in_array($img_type, $types) === true) {
                        $ImagenBlob = addslashes(file_get_contents($tmp_name));
                        $ran_id = rand(time(), 100000000);
                        $status = "Conectado";
                        $encrypt_pass = md5($password);
                        
                        $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                        VALUES ({$ran_id}, '{$fname}', '{$lname}', '{$email}', '{$encrypt_pass}', '{$ImagenBlob}', '{$status}')");

                        if ($insert_query) {
                            $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                            if (mysqli_num_rows($select_sql2) > 0) {
                                $result = mysqli_fetch_assoc($select_sql2);
                                $_SESSION['unique_id'] = $result['unique_id'];
                                header("location: ../users.php");
                            } else {
                                echo "Este Correo No existe!";
                            }
                        } else {
                            echo "Algo Sucedió. Inténtalo de Nuevo!";
                        }
                    } else {
                        echo "Por favor sube una imagen de tipo: - jpeg, png, jpg";
                    }
                } else {
                    echo "Por favor sube una imagen de tipo: - jpeg, png, jpg";
                }
            }
        }
    } else {
        echo "$email no es un correo válido!";
    }
} else {
    echo "Todos los campos son requeridos!";
}


?>