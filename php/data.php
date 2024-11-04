<?php
    while($row = mysqli_fetch_assoc($query)){
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']}
                OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id} 
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result = "Sin mensajes";
        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
        
        if (isset($row2['outgoing_msg_id'])) {
            ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
        } else {
            $you = "";
        }
        
        ($row['status'] == "Desconectado") ? $offline = "offline" : $offline = "";
        ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";

        // Convertir la imagen BLOB a base64
        $img_data = base64_encode($row['img']);
        $img_type = "image/jpeg"; // Cambia esto según el tipo de imagen (jpeg, png, etc.)
        $img_src = "data:$img_type;base64,$img_data";

        $output .= '<a href="chat.php?user_id='. $row['unique_id'] .'">
                        <div class="content">
                            <img src="'. $img_src .'" alt="">
                            <div class="details">
                                <span>'. $row['fname']. " " . $row['lname'] .'</span>
                                <p>'. $you . $msg .'</p>
                            </div>
                        </div>
                        <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                    </a>';
    }
?>
