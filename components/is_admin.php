<?php
require_once "database.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) {
    $sql = "SELECT is_admin FROM users WHERE id = {$_SESSION["id"]}";
    $is_admin = $mysqli->query($sql)->fetch_assoc()["is_admin"];
}
