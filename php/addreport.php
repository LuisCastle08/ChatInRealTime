<?php
session_start();

if (isset($_SESSION['unique_id']) && isset($_POST['motivo'])) {
    $motivo = $_POST['motivo'];
    $reporter_id = $_POST['reporter_id'];
    $user_report_id = $_POST['user_report_id'];
    $created_at = date("Y-m-d H:i:s");
    include_once "config.php";
    $stmt = $conn->prepare("INSERT INTO reports (reporter_id, user_report_id, motive, created_at) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $reporter_id, $user_report_id, $motivo, $created_at);
    if ($stmt->execute()) {
        header("Location: ../users.php?sm=true&vl=0"); //sm -> ShowModal (true or false)
                                                       //vl -> VaLue (0 Bien, 1 Mal)
    } else {
        header("Location: ../users.php?sm=true&vl=1");
        /* echo "Error al insertar el reporte: " . $stmt->error; */
    }

    $stmt->close();
} else {
    header("Location: ../login.php");
    exit();
}
?>
