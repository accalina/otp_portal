<?php
session_start();
$chr = $_POST['chr'];
if ($chr == $_SESSION['checkchar']){
    session_destroy();
    // header('location: http://google.com');
    echo "<script>window.location.href='http://google.com'<script>";
}else{
    echo "<script>window.location.href='index.html'<script>";
}
?>