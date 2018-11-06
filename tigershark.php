<?php
/**
 * Run a test of the oneTimePad class.
 *
 * The oneTimePad class is defined in the ./one-time-pad.php file and has a series of methods that are designed to
 * show you how the One Time Pad encryption cipher works.  One Time Pad is also known variously as either the Vernam
 * Cipher or the Perfect Cipher, owing to its mathematically unbreakable encryption (if implemented correctly).
 *
 * @author Accalina
 * @license UNLICENSE
 * @version 1.0
 */

session_start();


use unrivaled\OneTimePad\OneTimePadModulo26\OneTimePadModulo26;

require __DIR__ . '/src/OneTimePadModulo26.php';

$tabme = '<br><br>';

$cipher = new OneTimePadModulo26;

// For demonstration purposes, let's just use these text files as the source of our message and cipher keys.


// $plainText = preg_replace('/[^A-Z]/', '', strtoupper($_POST['mytext']));

$con = new mysqli("localhost","root","","db_otp");
$username = $_POST['username'];
$password = hash('sha512',$_POST['password']);
$cipher   = $_POST['cipher'];


$result = $con->query("select * from otp where (username = '$username') and (password = '$password') and (cipher = '$cipher')");
// echo "select * from otp where (username = '$username') and (password = '$password') and (cipher = '$cipher')";
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $myplain = $row['plain'];
        $_SESSION['rand'] = (rand(0,strlen($row['plain'])-1));
        $_SESSION['checkchar'] = $row['plain'][$_SESSION['rand']];
        echo "masukkan kerakter ke ". ($_SESSION['rand'] + 1)." Dari Challange!";
        // echo "<form action='hammerhead.php' method='post'>Karakter: <input name='chr' type='text'><input type='submit'></form>";
    }
}else{
    header("Status: 404 Not Found");
    echo "Login Failed";
}

if(isset($myplain)){
    $plainText = preg_replace('/[^A-Z]/', '', strtoupper($myplain));
    $cipherKey = preg_replace('/[^A-Z]/', '', strtoupper(file_get_contents('./text/cipherkey.txt')));
}

// Encrypt and then immediately decrypt the plain text message to test the one time pad.
// if (
//     (false === $cipherText = $cipher->encrypt($cipherKey, $plainText)) ||
//     (false === $decodedPlainText = $cipher->decrypt($cipherKey, $cipherText))
// ) {
//     echo('For perfect encryption in the one time pad, the key length must be equal to, or greater than, the message length.');
// }
//
// file_put_contents('./text/ciphertext.txt', $cipher->tty($cipherText));

// Displays a "vigenere table," also known as a "tabula recta."
// echo $cipher->get_vigenere_table();

// Displays the plain text message, the one time pad cipher key and the resulting safe to transmit cipher text.

if(isset($myplain)){
    $messageLength = strlen($plainText);
    $cipherKeyUsed = substr($cipherKey, 0, $messageLength);
}

// echo 'Plain:  ' . $cipher->tty($plainText) . " (message)\n" . $tabme ;
// echo 'Key:    ' . $cipher->tty($cipherKeyUsed) . " (secret)\n". $tabme;
// echo '        ' . $cipher->tty(str_repeat('-', $messageLength)) . "\n". $tabme;
// echo 'Cipher: ' . $cipher->tty($cipherText) . " (cipher)\n". $tabme;


