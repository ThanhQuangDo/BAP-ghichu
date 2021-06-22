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
if($_SESSION['id']){
    $id = $_SESSION['id'];
}else{
    header("location: login.php");
}

$idghichu = $_GET['id'];
echo $idghichu;
$sql = "SELECT * FROM `ghichu` WHERE `id`='".$idghichu."'";
$result = $con->query($sql);
$data = [];
if ($result->num_rows > 0) {

    //Gắn dữ liệu lấy được vào mảng $data
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$err_name = $err_file ="";
$check = true;
if(isset($_POST['submit'])){
    if(empty($_POST['title'])){
        $err_file = "Vui lòng nhập tên ghi chú";
        $check = false;
    }else{
        $title = $_POST['title'];
    }

    if(!empty($_FILES['file_ghichu']['name'])){
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
    }
    else{
        $err_file = "bạn chưa chọn file";
        $check = false;
    }
    if($check){
        $sql = "UPDATE ghichu SET 
        `title`='".$title."',
        `file_ghichu`='".$avatar."'
        WHERE `id` = '".$idghichu."'";
        if($result = $con->query($sql)){
            echo "<h1>Chỉnh sửa thành công Click vào <a href='index.php'>đây</a> để về trang danh sách</h1>";

        } else{
            echo "<h1>Có lỗi xảy ra Click vào <a href='index.php'>đây</a> để về trang danh sách</h1>";
        };
    }    
}

?>
<body>


    <div class="col text-center">
        <h1>Sửa Ghi Chú</h1>
    </div>
    <div>
        <a href="index.php" class="btn btn-primary">Trang Chủ</a>
    </div>
    <form method ="POST" action="" enctype="multipart/form-data">
    <?php foreach($data as $value) { ?>
    <div class="form-group">
        <label for="exampleInputtgc">Tên Ghi chú</label>
        <input type="text" value="<?php echo $value['title'] ?>" name="title" class="form-control" id="exampleInputtgc" aria-describedby="emailHelp" >
        <p style="background-color:red;"><?php echo $err_name ?></p>
    </div>
    <div class="form-group">
        <label for="exampleInputf">File ghi chú</label>
        <input type="file" name="file_ghichu" class="form-control-file" id="exampleInputf" aria-describedby="emailHelp">
        <p style="background-color:red;"><?php echo $err_file ?></p>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Update</button>
    <?php } ?>
    </form>
</body>
</html>