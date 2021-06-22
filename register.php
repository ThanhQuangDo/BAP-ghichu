<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<?php session_start();
    include 'connect.php';
    $err_name = $err_email = $err_pass = $err_confirm = "";
    $check = true;
    if(isset($_REQUEST['submit'])){
        if(empty($_POST['name'])){
            $err_name = "Vui lòng nhập tên";
            $check = false;
        } else{
            $name = $_POST['name'];
        }

        if(empty($_POST['email'])){
            $err_email = "Vui lòng nhập email";
            $check = false;
        } else{
            $email = $_POST['email'];
        }

        if(empty($_POST['password'])){
            $err_pass = "Vui lòng nhập pass";
            $check = false;
        } else{
            $password = $_POST['password'];
        }

        if(empty($_POST['confirm'])){
            $err_confirm = "Vui lòng nhập lại pass";
            $check = false;
        } else{
            if($_POST['confirm'] != $_POST['password']){
                $err_confirm = "Pass không trùng khớp";
                $check = false;
            }
        }

        if($check){
            $sql = "SELECT * FROM users WHERE username = '$name' OR email = '$email' ";
            $result = $con->query($sql);
            if($result->num_rows > 0){
                // ở đây đang kiểm tra điều kiện, nếu có trên 1 num_rows thì sai
                echo "<h1>username hoặc email đã tồn tại</h1>";
                die();
            }else{
                $sql = "INSERT INTO users
                (username, email, pass) 
                VALUES('".$name."', '".$email."', '".$password."');";
                
                if($con->query($sql) == True){
                    
                    echo "<h1>Đăng kí tài khoản thành công click vào <a href='login.php'>đây</a> để đăng nhập</h1>";
                    // header("location: login.php");
                } else{
                    echo "Đăng kí thất bại";
                }
            }
        }

    }
?>
<body>
    <div class="container">
        <div class="rox">
            <div class="col text-center">
                <div class="signup-form">
                <!-- sign up form -->
                    <h2>New User Signup!</h2>
                    <form method = "POST" action="" enctype="multipart/form-data">
                        <input type="text" name = "name" placeholder="Your Name"/>
                        <p style="background-color:red;"><?php echo $err_name ?></p>
                        <input type="email" name = "email" placeholder="Email Address"/>
                        <p style="background-color:red;"><?php echo $err_email ?></p>
                        <input type="password" name = "password" placeholder="Password"/>
                        <p style="background-color:red;"><?php echo $err_pass ?></p>
                        <input type="password" name = "confirm" placeholder="Password Again"/>
                        <p style="background-color:red;"><?php echo $err_confirm ?></p>
                        <button type="submit" name = "submit">Signup</button>
                    </form>
                </div>
                <!-- sign up form -->
            </div>
        </div>
    </div>
</body>
</html>

</html>