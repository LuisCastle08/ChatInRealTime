<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $output = "";
        $sql = "SELECT * FROM messages 
                LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) 
                ORDER BY msg_id";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                // Convertir la imagen BLOB a base64
                $img_data = base64_encode($row['img']);
                $img_type = "image/jpeg"; // Cambia esto según el tipo de imagen (jpeg, png, etc.)
                $img_src = "data:$img_type;base64,$img_data";

                if($row['outgoing_msg_id'] === $outgoing_id){
                    // Mensaje saliente
                    $output .= '<div class="chat outgoing">
                                    <div class="details">
                                        <p>'. $row['msg'] .'</p>
                                    </div>
                                </div>';
                }else{
                    // Mensaje entrante con imagen de perfil desde BLOB
                    $output .= '<div class="chat incoming">
                                    <img src="'. $img_src .'" alt="">
                                    <div class="details">
                                        <p>'. $row['msg'] .'</p>
                                    </div>
                                </div>';
                }
            }
        }else{
            $output .= '<div class="text">Sin mensajes. Una vez que envíes un mensaje, aquí se mostrará.</div>';
        }
        echo $output;
    }else{
        header("location: ../login.php");
    }
?>
