<?php require ("config.php");
$def = new lashopak();
if (isset($_GET['pId'])) {
    if (isset($_SESSION['user'])) {
        $memberID = $_SESSION['user']['id'];
        $prodID = $_GET['pId'];
        $nama = $_GET['nama'];
        $harga = $_GET['harga'];
        $jumlah = $_GET['jumlah'];
        $note = "";
        $total = ((int)$harga * (int)$jumlah);
        $add = $def->addCart($memberID, $prodID, $nama, $harga, $jumlah, $total, $note);
        if ($add = "Sukses") {
            header ("location:index.php");
        }
    }else{
        header("location:login.php?pId=".$_GET['pId']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TOKOLAPAK</title>
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
<div class="container">
    <div class="topmenu">
        <div class="left" id="menu">
                <h2><a href="index.php" class="brand">TOKOLAPAK</a></h2>
                <a href="index.php">Home</a>
                <div class="jatuhbawah">
                    <a class="dropbtn">Category</a>
                    <div class="drop-content">
                        <?php
                            $select = $def->getCat();
                            while ($data2 = $select->fetch(PDO::FETCH_OBJ)) {
                                echo "
                                    <a href='?kategori=$data2->id'>$data2->namaktg</a>
                                ";
                            }
                        ?>
                    </div>
                </div>
        </div>
        <div class="right">
            <?php if(isset($_SESSION['user'])){
                $countCart = $def->countCart();
            ?>
            <a href="cart.php" id="cart"><i class="fas fa-shopping-cart"></i> Cart <span class="badge"><?= $countCart ?></span></a>
                <div class="shopping-cart">
                    <div class="shopping-cart-header">
                    <i class="fa fa-shopping-cart cart-icon"></i><span class="badge"><?= $countCart ?></span>
                    <div class="shopping-cart-total">
                        <span class="lighter-text">Total:</span>
                        <?php
                         $memID = $_SESSION['user']['id'];
                         $getTotal = $def->cartTotal($memID)->fetch(PDO::FETCH_ASSOC);
                         $priceTotal = number_format($getTotal['priceSum'],2,',','.');
                        ?>
                        <span class="main-color-text total">Rp. <?= $priceTotal ?></span>
                    </div>
                    </div> <!--end shopping-cart-header -->

                    <ul class="shopping-cart-items">
                        <?php
                            if ($countCart > 0) {
                                $showCart = $def->showCart($memID);
                                $dataCart = $showCart->fetchAll();
                                foreach ($dataCart as $rowCart) {
                                    $dataPrice = number_format($rowCart['harga'],2,',','.');
                                    $productID = $rowCart['prodID'];
                                    $cartImage = $def->cartImage($productID);
                                    $dataCartImage = $cartImage->fetchAll();
                                    foreach ($dataCartImage as $dataDataCartImage) {
                        ?>
                        <li class="clearfix">
                            <img src="img/prod/<?= $dataDataCartImage['poto']; ?>"/>
                            <span class="item-name"><?= $rowCart['nama'] ?></span>
                            <span class="item-price">Rp. <?= $dataPrice ?></span><br>
                            <span class="item-quantity">Quantity: <?= $rowCart['jumlah'] ?></span>
                        </li>
                        <?php
                            }}
                        }else{ ?>
                            <div class="empty">
                                <h1 style="font-size:16px"><i class="fas fa-minus-circle fa-md"></i> Your shopping cart is empty <i class="fas fa-minus-circle fa-lg"></i></h1>
                            </div>
                    <?php }
                        ?>
                    </ul>

                    <a href="cart.php" class="checkout">Checkout <i class="fa fa-chevron-right"></i></a>
                </div>
                <div class="dropdown"><p><?= $_SESSION['user']['nama'] ?></p>
                <div class="dropdown-content">
                <?php
                $countTrans = $def->transUserOnly($memID);
                ?>
                    <a href="order.php">Order <span class="badge"><?= $countTrans ?></span></a>
                    <a href="">Settings</a>
                </div>
                </div>
                <a href="logout.php">Logout</a>
            <?php } if (empty($_SESSION['user'])) { ?>
                <a href="cart.php" id="cart"><i class="fas fa-shopping-cart"></i> Cart <span class="badge">0</span></a>
                <div class="shopping-cart">
                    <div class="shopping-cart-header">
                    <i class="fa fa-shopping-cart cart-icon"></i><span class="badge">0</span>
                    <div class="shopping-cart-total">
                        <span class="lighter-text">Total:</span>
                        <span class="main-color-text total">Rp. 0</span>
                    </div>
                    </div> <!--end shopping-cart-header -->

                    <ul class="shopping-cart-items">
                        <div class="empty">
                            <h1 style="font-size:16px">You must be logged in to view the cart</h1>
                        </div>
                    </ul>

                    <a href="cart.php" class="checkout">Checkout <i class="fa fa-chevron-right"></i></a>
                </div>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php } ?>
        </div>
    </div>
    <div class="header">
        <div class="back">
            <a href="javascript:history.back()">Back</a>
        </div>
    </div>
    <div class="cointainer">
        <div class="content3" style="padding-top:10px">
        <h1 style="text-align:center;color:rgb(66, 66, 66)">On Going Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>Transaction Code</th>
                    <th>Order Date</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getProd = $def->showTrans();
                $dataProd = $getProd->fetchAll();
                foreach ($dataProd as $rowProd) {
                    $transCode = $rowProd['transCode'];
                    $sendUser = $def->getTransReal($transCode);
                    $dataUser = $sendUser->fetchAll();
                ?>
                <tbody class="labels">
                    <tr>
                        <td>
                            <label style="display:block" for="<?= $rowProd['transCode'] ?>"><?= $rowProd['transCode'] ?></label>
                            <input type="checkbox" name="<?= $rowProd['transCode'] ?>" id="<?= $rowProd['transCode'] ?>" data-toggle="toggle">
                        </td>
                        <td>
                            <label style="display:block" for="<?= $rowProd['transCode'] ?>"><?= $rowProd['tglTrans'] ?></label>
                            <input type="checkbox" name="<?= $rowProd['transCode'] ?>" id="<?= $rowProd['transCode'] ?>" data-toggle="toggle">
                        </td>
                        <td>
                            <label style="display:block" for="<?= $rowProd['transCode'] ?>"><?php 
                            if (empty($rowProd['bukti'])) {
                                echo "- Empty -";
                            }else if (isset($rowProd['bukti']) && $rowProd['status'] == "On Process" ) {
                                echo "Payment Accepted";
                            }else if (isset($rowProd['bukti'])) {
                                echo "Needs Check";
                            }
                            ?></label>
                            <input type="checkbox" name="<?= $rowProd['transCode'] ?>" id="<?= $rowProd['transCode'] ?>" data-toggle="toggle">
                        </td>
                        <td>
                            <label style="display:block" for="<?= $rowProd['transCode'] ?>"><?= $rowProd['status'] ?></label>
                            <input type="checkbox" name="<?= $rowProd['transCode'] ?>" id="<?= $rowProd['transCode'] ?>" data-toggle="toggle">
                        </td>
                        <td>
                            <label style="display:block" for="<?= $rowProd['transCode'] ?>"><a href="orderDetails.php?id=<?= $rowProd['transCode'] ?>" class="btn btn-primary">Details</a><a href="orderDelete.php?id=<?= $rowProd['transCode'] ?>" class="btn btn-danger">Delete</a></label>
                            <input type="checkbox" name="<?= $rowProd['transCode'] ?>" id="<?= $rowProd['transCode'] ?>" data-toggle="toggle">
                        </td>
                    </tr>
                </tbody>
                <tbody class="hide">
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Note</th>
                        <th>Total</th>
                    </tr>
                <?php 
                foreach ($dataUser as $rowUser) {
                    $formatedPrice = number_format($rowUser['harga'],0,',','.');
                    $formatedTotal = number_format($rowUser['total'],0,',','.');
                ?>
                    <tr>
                        <td><?= $rowUser['nama'] ?></td>
                        <td>Rp. <?= $formatedPrice ?></td>
                        <td><?= $rowUser['jumlah'] ?></td>
                        <td><?php
                        if (empty($rowUser['note'])) {
                            echo "-";
                        }else{
                            echo $rowUser['note'];
                        }
                        ?></td>
                        <td>Rp. <?= $formatedTotal ?></td>
                    </tr>
                <?php } ?>
                    <tr>
                        <?php 
                        $getTransTotal = $def->transTotal($transCode);
                        $dataTransTotal = $getTransTotal->fetchAll();
                        foreach ($dataTransTotal as $rowTrans) {
                            $formatedTotalReal = number_format($rowTrans['priceSum'],0,',','.');
                        ?>
                        <td colspan="4">Total</td>
                        <td>Rp. <?= $formatedTotalReal ?></td>
                        <?php } ?>
                    </tr>
                </tbody>
                <?php } ?>
            </tbody>
        </table>
        </div>
    </div> 
</div>
</body>
</html>