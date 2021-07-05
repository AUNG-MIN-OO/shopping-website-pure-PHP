<?php include('header.php') ?>

<?php

if (session_status()==PHP_SESSION_NONE){
    session_start();
}



if (!empty($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
}else{
    $pageno = 1;
}

$numOfrecs = 6;
$offset = ($pageno - 1) * $numOfrecs;

if (empty($_POST['search']) && empty($_COOKIE['search'])) {
    $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC");
    $stmt->execute();
    $rawResult = $stmt->fetchAll();

    $total_pages = ceil(count($rawResult) / $numOfrecs);

    $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT $offset,$numOfrecs");
    $stmt->execute();
    $result = $stmt->fetchAll();
}else{
    $searchKey = $_POST['search'] ? $_POST['search'] : $_COOKIE['search'];
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC");
    $stmt->execute();
    $rawResult = $stmt->fetchAll();

    $total_pages = ceil(count($rawResult) / $numOfrecs);

    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
    $stmt->execute();
    $result = $stmt->fetchAll();
}

?>
<!-- End Filter Bar -->
<!-- Start Best Seller -->
<!-- Start Filter Bar -->

<div class="container">
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-5">
            <div class="sidebar-categories">
                <div class="head">Browse Categories</div>
                <ul class="main-categories">
                    <li class="main-nav-list">
                        <?php
                        $catStmt = $pdo->prepare("SELECT * FROM categories");
                        $catStmt->execute();
                        $catResult = $catStmt->fetchAll();

                        foreach ($catResult as $cat){
                        ?>
                            <a href="#" data-toggle="collapse">
                                <span class="lnr lnr-arrow-right"></span>
                                <?php echo escape($cat['name']); ?>
                            </a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-7">

<div class="filter-bar d-flex flex-wrap align-items-center">
    <div class="pagination">
        <a href="?pageno=1" class="active">First</a>
        <a href="<?php if($pageno <= 1) {echo '#';}else{ echo "?pageno=".($pageno-1);}?>" <?php if($pageno <= 1){ echo 'disabled';} ?> class="prev-arrow">
            <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
        </a>
        <a href="#" class="active"><?php echo $pageno; ?></a>
        <a href="<?php if($pageno >= $total_pages) {echo '#';}else{ echo "?pageno=".($pageno+1);}?>" class="next-arrow" <?php if($pageno >= $total_pages){ echo 'disabled';} ?>>
            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
        </a>
        <a href="?pageno=<?php echo $total_pages?>" class="active">Last</a>
    </div>
</div>
<section class="lattest-product-area pb-40 category-list">
    <div class="row">
        <?php
            if ($result){
                foreach ($result as $post){
        ?>
        <!-- single product -->
        <div class="col-lg-4 col-md-6">
            <div class="single-product">
                <img class="img-fluid" src="admin_panel/images/<?php echo $post['image']; ?>" style="height: 250px;" alt="">
                <div class="product-details">
                    <h6><?php echo escape($post['description'])?></h6>
                    <div class="price">
                        <h6><?php echo escape($post['price'])?></h6>
                        <h6 class="l-through">20000</h6>
                    </div>
                    <div class="prd-bottom">
                        <a href="" class="social-info">
                            <span class="ti-bag"></span>
                            <p class="hover-text">add to bag</p>
                        </a>
                        <a href="" class="social-info">
                            <span class="lnr lnr-move"></span>
                            <p class="hover-text">view more</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
                }
            }
        ?>
    </div>
</section>
<!-- End Best Seller -->
<?php include('footer.php');?>
