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
    if(isset($_SESSION['id'])){
        $id = $_SESSION['id'];
    }else{
        header("location: login.php");
    }
    $sql = "SELECT * FROM `ghichu` WHERE `id_user`='".$id."' ";
    $result = $con->query($sql);
    $data = [];
    if ($result->num_rows > 0) {
        //Gắn dữ liệu lấy được vào mảng $data
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    // $link = './ghichu/' .$data[$id]['file_ghichu'];
    // echo "<br><br><a href='$link'>abcd</a>";
    
?>
<body>
<script src="script.js">
</script>
<div class="main-container">
    <div class="container1"><h1 style="text-align:center">Quản lí ghi chú</h1></div>
    <div class="container2">
        <a href="create.php"><button class="btn btn-primary" id="button">Thêm ghi chú</button></a><br>
    </div>
    
    <div class="container3">
        <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Ghi chú</th>
            <th scope="col">File ghi chú</th>
            <th scope="col">Chỉnh sửa</th>
            <th scope="col">Xóa</th>
            </tr>
        </thead>
        <?php
            foreach($data as $value){
        ?>
        <tbody>
            <tr>
            <td><?php echo $value['id'] ?></td>
            <td><?php echo $value['title'] ?></td>
            <?php 
            $link = './ghichu/' .$value['file_ghichu'];
            ?>
            <td><?php echo "<a href='$link'>download</a>"  ?></td>
            <td><a href="edit.php?id=<?=$value['id']?>" class="btn btn-danger">Edit</a></td>
            <td><a href="delete.php?id=<?=$value['id']?>" class="btn btn-danger">Xóa</a></td>
            </tr>
        </tbody>
        <?php
            }
        ?>
        <tfoot>
            <tr>
                <td colspan="8">
                    
                    <a href="logout.php"><button class="btn btn-danger" style="margin-top:20px" id="button">Đăng xuất</button></a>
                </td>
            </tr>
        </tfoot>
        </table>
    </div>
</div>
</body>
</html>
