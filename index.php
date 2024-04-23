<?php 
  session_start();
  if(isset($_SESSION['unique_id'])){
    header("location: users.php");
  }
?>

<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="form signup">
      <header>CHAT EN TIEMPO REAL</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="name-details">
          <div class="field input">
            <label>NOMBRE:</label>
            <input type="text" name="fname" placeholder="Nombre" required>
          </div>
          <div class="field input">
            <label>APELLIDO</label>
            <input type="text" name="lname" placeholder="Apellido" required>
          </div>
        </div>
        <div class="field input">
          <label>CORREO ELECTRONICO:</label>
          <input type="text" name="email" placeholder="Ingresa tu correo-electronico" required>
        </div>
        <div class="field input">
          <label>CONTRASEÑA:</label>
          <input type="password" name="password" placeholder="Ingresa una contraseña" required>
          <i class="fas fa-eye"></i>
        </div>
        <div class="field image">
          <label>FOTO DE PERFIL</label>
          <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Ingresa al Chat">
        </div>
      </form>
      <div class="link">Ya estas registrado? <a href="login.php">Inicia Sesión Ahora!</a></div>
    </section>
  </div>

  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/signup.js"></script>

</body>
</html>
