<?php
require 'mainconfig.php';

//Menggunakan while looping dan mengirim email 1 per 1 kepada setiap tujuan, email tetap memakai dari database email

//$isi=$_POST["isi"];
$judul_kegiatan = $_POST['judul_kegiatan'];
$tanggal = $_POST['tanggal'];
$jam = $_POST['jam'];
$tempat = $_POST['tempat'];
$link = $_POST['link'];
$message = file_get_contents('template.html');
$message = str_replace('%judul%', $judul_kegiatan, $message);
$message = str_replace('%tanggal%', $tanggal, $message);
$message = str_replace('%jam%', $jam, $message);
$message = str_replace('%tempat%', $tempat, $message);
if ($link != null) {
    $message = str_replace('%link%', $link, $message);
} else {
    $message = str_replace('%link%', 'Link Cooming Soon', $message);
}
$subjek=$_POST['subjek'];
$email_tujuan=$_POST['email_tujuan'];

$get_data = mysqli_query($db, "SELECT * FROM list_email");
while ($data = mysqli_fetch_assoc($get_data)) {
    require 'PHPMailer/PHPMailerAutoload.php';
    $email_pengirim = "princepediateam@gmail.com";
    $mail = new PHPMailer();
    $mail->IsHTML(true);    // set email format to HTML
    $mail->IsSMTP();   // we are going to use SMTP
    $mail->SMTPAuth   = true; // enabled SMTP authentication
    $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
    $mail->Host       = "smtp.gmail.com";      // setting GMail as our SMTP server
    $mail->Port       = 465;                   // SMTP port to connect to GMail
    $mail->Username   = $email_pengirim;  // alamat email kamu
    $mail->Password   = "princeqb14";            // password GMail
    $mail->SetFrom($email_pengirim, 'noreply-KBMTI');  //Siapa yg mengirim email
    $mail->Subject    = $subjek;
    //$mail->Body       = $isi;
    $mail->MsgHTML($message);
    $mail->AddAddress($data['email']);
    if(!$mail->Send()) {
        echo "Eror: ".$mail->ErrorInfo;
        exit;
    }else {
        echo "<div class='alert alert-success'><strong>Berhasil!</strong> Email telah berhasil dikirim.</div>";
    }
}

?>