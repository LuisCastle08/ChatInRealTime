<?php 
  session_start();
  include_once "php/config.php";
  include_once "header.php";

  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }
  if (isset($_GET['sm']) && $_GET['sm'] == 'true') {
    if (isset($_GET['vl']) && $_GET['vl'] == '0') {
      echo '
        <script>
          alert("Se genero un reporte");
        </script>
      ';
    }else{
      echo '
        <script>
          alert("Error al Generar Reporte");
        </script>
      ';
    }
  }
?>
<body>
  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <?php 
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
            if(mysqli_num_rows($sql) > 0){
              $row = mysqli_fetch_assoc($sql);
            }
          ?>
          <img src="php/images/<?php echo $row['img']; ?>" alt="">
          <div class="details">
            <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
        <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">CERRAR SESIÓN</a>
      </header>
      <div class="search">
        <span class="text">Selecciona un usuario para chatear</span>
        <input type="text" placeholder="Busca un Usuario...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
      </div>
    </section>
  </div>

  <script src="javascript/users.js"></script>


</body>
</html>
