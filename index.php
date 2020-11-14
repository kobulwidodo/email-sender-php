<?php
require 'mainconfig.php';

// Menggunakan multiple Send, kirim email ke beberapa tujuan dengan 1x proses
    if (isset($_POST['kirim'])) {

        require 'PHPMailer/PHPMailerAutoload.php';
        $email_pengirim = "princepediateam@gmail.com";
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
        $get_data = mysqli_query($db, "SELECT * FROM list_email");
        while ($data = mysqli_fetch_assoc($get_data)) {
            $mail->AddAddress($data['email']);
        }

        if(!$mail->Send()) {
            echo "Eror: ".$mail->ErrorInfo;
            exit;
        }else {
            echo "<div class='alert alert-success'><strong>Berhasil!</strong> Email telah berhasil dikirim.</div>";
        }
    }
    ?>
<!DOCTYPE html>
<html>
<head>
    <!-- Load file CSS Bootstrap offline -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h2>Email Sender</h2>
    <p>Email Tujuan di Database</p>
<br>
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <!-- <label for="">Email Tujuan</label>
        <div class="form-group">
            <input class="form-control" name="email_tujuan" placeholder="tes@example.com">
        </div> -->
        <label for="">Subjek</label>
        <div class="form-group">
            <input class="form-control" name="subjek" placeholder="Subjek">
        </div>
        <label for="">Judul Kegiatan</label>
        <div class="form-group">
            <input class="form-control" name="judul_kegiatan" placeholder="Judul Kegiatan"></input>
        </div>
        <label for="">Tanggal</label>
        <div class="form-group">
            <input class="form-control" name="tanggal" placeholder="Senin, 09 November 2002"></input>
        </div>
        <label for="">Jam</label>
        <div class="form-group">
            <input class="form-control" name="jam" placeholder="17.30 - 19.30 WIB"></input>
        </div>
        <label for="">Tempat</label>
        <div class="form-group">
            <input class="form-control" name="tempat" placeholder="TBA"></input>
        </div>
        <label for="">Link</label>
        <div class="form-group">
            <input class="form-control" name="link" aria-describedby="linksmall" placeholder="https://zoom.us/"></input>
            <small id="linksmall" class="form-text text-muted">Kosongkan apabila belum tersedia</small>
        </div>

        <button type="submit" name="kirim" class="btn btn-primary">Kirim</button>

    </form>
</div>
</body>
</html>