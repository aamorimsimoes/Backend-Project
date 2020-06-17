<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: signin.php');
    exit;
} else {
    require_once('../functions.php');
    $section = !empty($_GET['s']) ? $_GET['s'] : null;
    $token = !empty($_GET['token']) ? $_GET['token'] : null;


    $sql = "DELETE FROM " . $section . " WHERE token = ?";
    $stmt = conn()->prepare($sql);
    if ($stmt->execute([$token])) {
        $n = $stmt->rowCount();
        if ($n === 1) {
            $stmt = null;
            header("Location: ../$section/");
            exit;
        }
    }
}
