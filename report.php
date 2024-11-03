<?php
session_start();
include_once "header.php";
if (isset($_SESSION['unique_id']) && isset($_GET['id_user_report'])) {
    $reporter = $_SESSION['unique_id'];
    $var = $_GET['id_user_report'];
    include_once "php/config.php";
    
    $stmt = $conn->prepare("SELECT fname,lname FROM users WHERE unique_id = ?");
    $stmt->bind_param("i", $var);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
/*         echo $var;
        echo $row['fname'];           // Nombre del usuario
        echo $_SESSION['unique_id'];   */ // ID de sesión del usuario
    }
    $stmt->close();
} else {
    header("Location: ../login.php");
    exit();
}

?>
<body>
<div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
            <h2>Reportar usuario</h2>
        </div>
        <a href="users.php" class="logout">REGRESAR</a>
      </header>
      <br>
      <p>¿Cuál es el motivo por el que deseas reportar al usuario <strong><?php echo ($row['fname'].' '.$row['lname']); ?></strong>?</p>
        <form action="php/addreport.php" method="post">
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="motivo" style="height: 100px" required></textarea>
                <label for="floatingTextarea2">Explica tu motivo...</label>
                <input type="hidden" value="<?php echo($reporter); ?>" name="reporter_id" id="reporter_id">
                <input type="hidden" value="<?php echo($var); ?>" name="user_report_id" id="user_report_id">
            </div>
            <button type="submit" class="btn-report">Enviar Reporte</button>
        </form>
    </section>
  </div>
</body>
</html>
