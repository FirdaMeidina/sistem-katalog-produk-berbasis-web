<?php
session_start();
include '../koneksi/koneksi.php';

if (isset($_POST['login'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username=? AND password=?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
        $_SESSION['role'] = $data['role'];

        header('Location: dashboard.php');
        exit();
    } else {
        echo "<script>alert('Login gagal. Cek username dan password.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body style="background-color: #f9f9f9; display: flex; justify-content: center; align-items: center; height: 100dvh;">
    <div class="container">
        <div class="card shadow-sm p-4 mx-auto" style="max-width: 400px;">
            <h3 class="text-center text-danger">Login Admin</h3>
            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="user" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="pass" class="form-control" required>
                </div>
                <button type="submit" name="login" class="btn btn-danger btn-block">Login</button>
            </form>
        </div>
    </div>
</body>

</html>