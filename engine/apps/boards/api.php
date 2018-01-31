<?php

if(isset($_POST["board_update"]) and isset($_POST["board_id"])){
    $db = db();
    $board_id = $db->real_escape_string($_POST["board_id"]);
    $board_update = $db->real_escape_string($_POST["board_update"]);
    $db->query("UPDATE boards SET board_data='$board_update' WHERE board_id='$board_id'");
    $db->close();
}

if(isset($_POST['board_delete'])){
    $db = db();
    $id = $db->real_escape_string($_POST['board_delete']);
    $db->query("DELETE FROM boards WHERE board_id='$id'");
    $db->close();
}