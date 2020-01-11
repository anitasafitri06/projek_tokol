<?php 
require '../koneksi.php';

  if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $result = mysqli_query($koneksi,"SELECT * FROM cutomers WHERE email = '$email'");
    $cek = mysqli_num_rows($result);
    $pasbaru = substr(uniqid(rand(), true), 5, 5);;
    if ($cek > 0) {
      $data = mysqli_fetch_array($result);
      mysqli_query($koneksi,"UPDATE cutomers SET password = $pasbaru");  
      require '../PHPMailer-5.2.13/PHPMailerAutoload.php';
      $mail = new PHPMailer;

      //$mail->SMTPDebug = 3;                               // Enable verbose debug output

      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'anitasafitri6@gmail.com';                 // SMTP username
      $mail->Password = 'anitanew';                           // SMTP password
      $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 465;                                    // TCP port to connect to

      // $mail->From = 'AdminDeveloper@gmail.com';
      $mail->FromName = 'Admin Developer';
      $mail->addAddress($email, 'User');     // Add a recipient
      // $mail->addAddress('ellen@example.com');               // Name is optional
      $mail->addReplyTo('anitasafitri6@gmail.com', 'Admin');
      $mail->addCC('anitasafitri6@gmail.com');
      $mail->addBCC('anitasafitri6@gmail.com');

      $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
      $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
      $mail->isHTML(true);                                  // Set email format to HTML

      $mail->Subject = 'DMSN-Cloth Official';
      $mail->Body    = '<center><p>Password Berhasil Diganti</p><br><h1 class="alert alert-danger">'.$pasbaru.'</h1></center>';
      $mail->AltBody = 'bisa This is the body in plain text for non-HTML mail clients';

      if(!$mail->send()) {
          echo 'Message could not be sent.';
          echo 'Mailer Error: ' . $mail->ErrorInfo;
      } else {
          echo '<h1 class="alert alert-success text-center">Password berhasil dikirim silahkan cek diemail anda</h1><br>
             <div class="text-center"><a class="btn btn-primary" href="http://www.gmail.com">cek email</a></div>';
      }
    }else{
      echo "<script>
        alert('data tidak ada');
        document.location.href='forgot-password.php';
        </script>";
    }
  }else{
    echo "<script>
      alert('Silahkan Isi email yang ingin direset');
    </script>";
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin - Forgot Password</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Reset Password</div>
      <div class="card-body">
        <div class="text-center mb-4">
          <h4>Forgot your password?</h4>
          <p>Enter your email address and we will send you instructions on how to reset your password.</p>
        </div>
        <form method="POST" action="">
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" id="inputEmail" class="form-control" placeholder="Enter email address" required="required" autofocus="autofocus" name="email">
              <label for="inputEmail">Enter email address</label>
            </div>
          </div>
          <button class="btn btn-primary btn-block" type="submit" name="reset">Reset Password</button>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register.html">Register an Account</a>
          <a class="d-block small" href="login.html">Login Page</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
