<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<?php session_start();
    $err_email = $err_pass = "";
    $check = true;
    include 'connect.php';
    if(isset($_POST['submit'])){
        if(empty($_POST['email'])){
            $err_email = "Vui lòng nhập email";
            $check = false;
        }else{
            $email = $_POST['email'];
        }

        if(empty($_POST['password'])){
            $err_pass = "Vui lòng nhập password";
            $check = false;
        }else{
            $pass = $_POST['password'];
        }

        if($check){
            $sql = "SELECT * FROM users WHERE email = '$email' and pass = '$pass' ";
            $result = $con->query($sql);
            
            if($result->num_rows == 0){
                
                echo '<p style="background-color:red;">Email hoặc password không đúng, vui lòng nhập lại</p>';
                // die();
            } else {
                $data = "";
                while ($row = $result->fetch_assoc()) {
                    $data = $row;
                    // print_r($data);
                }
                // echo "<h1>Đăng nhập thành công click vào <a href='index.php'>đây</a> để vào trang chủ</h1>";
                $_SESSION['id'] = $data['id'];
                $_SESSION['username'] = $data['username'];
                // echo $_SESSION['id'];
                header("location: index.php");
            }
        }
    }
?>
<body>
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="login-form"><!--login form-->
                    <h2>Login to your account</h2>
                    <form method="POST" action=""  enctype="multipart/form-data">
                        <input type="email" name="email" placeholder="Email Address" />
                        <p style="background-color:red;"><?php echo $err_email ?></p><br/>
                        <input type="password" name="password"  placeholder="Your Password" />
                        <p style="background-color:red;"><?php echo $err_pass ?></p><br/>
                        <button  type="submit" name="submit" class="btn btn-primary">Login<a href="index.php"></a></button>
                    </form>
                </div><!--/login form-->
            </div>
        </div>
        
    </div>
    
    
</body>
<footer>
    <div class="col text-center" style="margin-top:20px;">
        <a href="register.php" class="btn btn-primary">Create account</a>
    </div>
</footer>
</html>



