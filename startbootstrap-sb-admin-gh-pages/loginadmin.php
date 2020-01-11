<?php 
session_start();
require '../koneksi.php';


 ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form method="POST" action="">
          <div class="form-group">
            <div class="form-label-group">
              <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required="required" autofocus="autofocus">
              <label for="inputEmail">Email address</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required="required">
              <label for="inputPassword">Password</label>
            </div>
          </div>
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me">
                Remember Password
              </label>
            </div>
          </div>
          <button class="btn btn-primary btn-block" name="submit" type="submit">Login</button>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register.html">Register an Account</a>
          <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
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
<?php 
  if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $result = mysqli_query($koneksi,"SELECT * FROM cutomers WHERE email = '$email'");
  $cek = mysqli_num_rows($result);
  if ($cek > 0) {
        $data = mysqli_fetch_array($result);
        if ($password == $data['password']) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $data['username'];
                echo "
                <script>
                Swal.fire({
                  position: 'top-center',
                  icon: 'success',
                  title: 'Your work has been saved',
                  showConfirmButton: false,
                  timer: 1500
                })
                var url = '../index.php';
                setTimeout('document.location.href=(url);', 500    );
                </script>
                ";
                exit;
            }
           echo "
            <script>
            alert('Password Salah!!!');
            document.location.href='login.php';
            </script>
            ";
    }
    echo "
    <script>
    alert('Email Salah!!!');
    document.location.href='startbootstrap/sb/admin/gh/pages/login.php';
    </script>
    ";
}
?>