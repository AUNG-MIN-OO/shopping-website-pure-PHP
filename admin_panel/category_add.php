<?php
session_start();
require '../config/config.php';
require '../config/common.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
}
if ($_SESSION['role'] != 1) {
    header('Location: login.php');
}

if ($_POST) {
    if (empty($_POST['name']) || empty($_POST['description'])){
        if (empty($_POST['name'])){
            $nameError = "Name is required";
        }
        if (empty($_POST['description'])){
            $descriptionError = "Description is required";
        }
    }else{
        $name = $_POST['name'];
        $description = $_POST['description'];

        $stmt = $pdo->prepare("INSERT INTO categories(name,description) VALUES (:name,:description)");
        $result = $stmt->execute(
            array(':name'=>$name,':description'=>$description)
        );

        if ($result) {
            echo "<script>alert('Category added');window.location.href='category.php'</script>";
        }
    }
}

?>


<?php include('header.php'); ?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="" action="category_add.php" method="post">
                            <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                            <div class="form-group">
                                <label for="">Category Name</label><p style="color:#ff0000"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
                                <input type="text" class="form-control" name="name" value="">
                            </div>
                            <div class="form-group">
                                <label for="">Description</label><p style="color:red"><?php echo empty($descriptionError) ? '' : '*'.$descriptionError; ?></p>
                                <textarea class="form-control" name="description" rows="8" cols="80"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                                <a href="category.php" class="btn btn-warning">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
<?php include('footer.php') ?>
