<?php
include 'header.php';
if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
}
?>

<!--================Cart Area =================-->
<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <?php if (!empty($_SESSION['cart'])){ ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $total = 0;
                            foreach ($_SESSION['cart'] as $key => $qty){
                                $id = str_replace('id','',$key);
                                $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                $itemTotalPrice = $result['price'] * $qty;
                                $total += $result['price'] * $qty;
                        ?>
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="admin_panel/images/<?php echo escape($result['image']); ?>" width="100" height="100" alt="">
                                        </div>
                                        <div class="media-body">
                                            <p><?php echo escape($result['name']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo escape($result['price']); ?></h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input type="text" readonly value="<?php echo escape($qty); ?>" title="Quantity:" class="input-text qty">
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo escape($itemTotalPrice); ?></h5>
                                </td>
                                <td>
                                    <a href="cart_item_clear.php?pid=<?php echo $result['id'] ?>" class="btn btn-sm btn-danger">Clear item</a>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>
                                <h5>Subtotal</h5>
                            </td>
                            <td>
                                <h5><?php echo $total ?></h5>
                            </td>
                            <td>

                            </td>

                        </tr>
                        <tr class="out_button_area">
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>
                                <div class="checkout_btn_inner d-flex align-items-center">
                                    <a class="primary-btn" href="clear_all.php">Clear Cart</a>
                                    <a class="gray_btn" href="index.php">Continue Shopping</a>
                                    <a class="primary-btn" href="sale_order.php">Order Submit</a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<!--================End Cart Area =================-->
<?php
include 'footer.php';
?>
