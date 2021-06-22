<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Architects+Daughter">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<?php session_start();
    include 'connect.php';
    if($_SESSION['id']){
        $iduser = $_SESSION['id'];
    }else{
        header("location: login.php");
    }
    $err_name = $err_file ="";
    $check = true; 
    if(isset($_POST['submit'])){
        
        if(empty($_POST['title'])){
            $err_name = "Vui lòng nhập tên ghi chú";
            $check = false;
        }else{
            $title = $_POST['title'];
        }

        if(!empty($_FILES['file_ghichu'])){
            $file = strtolower($_FILES['file_ghichu']['name']);
            $explode = explode('.', $file);
            $array = array('docx');
            
            if(in_array($explode[1], $array)){
                move_uploaded_file($_FILES['file_ghichu']['tmp_name'], './ghichu/'.$_FILES['file_ghichu']['name']);
                $avatar = $_FILES['file_ghichu']['name'];
                
            }else{
                $err_file = "file bị lỗi";
                $check = false;
            }
        }else{
            $err_file = "Vui lòng chọn file";
        };

        if($check){
            $sql = "SELECT * FROM ghichu WHERE title = '$title'";
            $result = $con->query($sql);
            if($result->num_rows > 0){
                // ở đây đang kiểm tra điều kiện, nếu có trên 1 num_rows thì sai
                echo "<h1>Title đã tồn tại</h1>";
                die();
    
            } else {
    
            $sql = "INSERT INTO ghichu
                (title, file_ghichu,id_user) 
                VALUES('".$title."', '".$avatar."', '".$iduser."');";
                
                 if($con->query($sql) == True){
                    
                    echo "<h1>Thêm ghi chú thành công click vào <a href='index.php'>đây</a> để vào trang danh sách</h1>";
                    
                 } else{
                     echo "Đăng kí thất bại";
                 };
            }
    
        }
        
    }
?>
<body>
    <div class="main-container">
        <div class="col text-center">
            <h1>Thêm Ghi Chú</h1>
        </div>
        <div class="container1">
            <a href="index.php"><button class="btn btn-primary" id="button">Trang chủ</button></a><br>
        </div>
        <div class="container3">
        <form method ="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleInputtgc">Tên Ghi chú</label>
                <input type="text" name="title" class="form-control" id="exampleInputtgc" aria-describedby="emailHelp" placeholder="Tên Ghi Chú">
                <p style="background-color:red;"><?php echo $err_name ?></p>
            </div>
            <div class="form-group">
                <label for="exampleInputf">File ghi chú</label>
                <input type="file" name="file_ghichu" class="form-control-file" id="exampleInputf" aria-describedby="emailHelp">
                <p style="background-color:red;"><?php echo $err_file ?></p>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add</button>
        </form>
        </div>
    </div>
</body>
</html>
