<?php include('header.php') ?>

<?php
if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!--================Single Product Area =================-->
<div class="product_image_area" style="padding-top: 0;">
  <div class="container">
    <div class="row s_product_inner">
      <div class="col-lg-6">
          <div class="single-prd-item">
              <img class="img-fluid" width="450" src="admin_panel/images/<?php echo $result['image'];?>" alt="">
          </div>
      </div>
      <div class="col-lg-5 offset-lg-1">
        <div class="s_product_text">
          <h3><?php echo escape($result['name']);?></h3>
          <h2><?php echo escape($result['price']);?></h2>
          <ul class="list">
              <?php
                $category_id = $result['category_id'];
                $catStmt = $pdo->prepare("SELECT * FROM categories WHERE id=$category_id");
                $catStmt->execute();
                $catResult = $catStmt->fetch(PDO::FETCH_ASSOC);
              ?>
            <li><a class="active" href="#"><span>Category</span> : <?php echo escape($catResult['name']);?></a></li>
            <li><a href="#"><span>Availability</span> : <?php echo escape($result['quantity']);?></a></li>
          </ul>
          <p><?php echo escape($result['description']);?></p>
            <form action="addToCart.php" method="post">
                <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                <div class="product_count">
                    <label for="qty">Quantity:</label>
                    <input type="text" name="quantity" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
                    <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                            class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                    <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                            class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                </div>
                <div class="card_area d-flex align-items-center">
                    <button class="primary-btn" style="border: none;" href="#">Add to Cart</button>
                    <a class="primary-btn" href="index.php">Back to Home</a>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div><br>
<!--================End Single Product Area =================-->

<!--================End Product Description Area =================-->
<?php include('footer.php');?>
