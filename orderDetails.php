<?php require ("config.php");
$def = new lashopak();
$transCode = $_GET['id'];
$getTrans = $def->getTransReal($transCode);
$dataTrans = $getTrans->fetchAll();
$getDB = $def->getDB();
if (isset($_POST['uploadBukti'])) {
    $poto = $_FILES['potoBukti'];
    $add = $def->addPayment($poto,$transCode);
}
if (isset($_POST['confirmTrans'])) {
    $memID = $_POST['memberID'];
    $prodID = $_POST['prodID'];
    $transCode = $_POST['transCode'];
    $tglTrans = $_POST['tglTrans'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];
    $total = $_POST['total'];
    $note = $_POST['note'];
    $bukti = $_POST['bukti'];

    $query = "INSERT INTO pembelian(memberID, prodID, transCode, tglOrder, nama, harga, jumlah, total, note, bukti) VALUES 
    (:memID, :prodID, :transCode, :tglTrans, :nama, :harga, :jumlah, :total, :note, :bukti)";
    $stmt = $getDB->prepare($query);
    $index = 0;
    foreach ($memID as $dataID) {
        $stmt->bindParam(':memID', $dataID);
        $stmt->bindParam(':prodID', $prodID[$index]);
        $stmt->bindParam(':transCode', $transCode[$index]);
        $stmt->bindParam(':tglTrans', $tglTrans[$index]);
        $stmt->bindParam(':nama', $nama[$index]);
        $stmt->bindParam(':harga', $harga[$index]);
        $stmt->bindParam(':jumlah', $jumlah[$index]);
        $stmt->bindParam(':total', $total[$index]);
        $stmt->bindParam(':note', $note[$index]);
        $stmt->bindParam(':bukti', $bukti[$index]);
        if ($stmt->execute()) {
            $delQuery = "DELETE FROM transaksi WHERE transCode=:transCode";
            $stmt2 = $getDB->prepare($delQuery);
            if ($stmt2->execute(array(':transCode' => $_GET['id']))) {
                header("location:order.php");
            }
        }

        $index++;
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LASHOPAK</title>
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/zoomify.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/zoomify.min.js"></script>
</head>
<body>
<div class="container">
    <div class="topmenu">
        <div class="left" id="menu">
                <h2><a href="index.php" class="brand">LASHOPAK</a></h2>
                <a href="index.php?page=home">Home</a>
                <a href="index.php?page=about">About</a>
                <a href="index.php?page=category">Contact</a>
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
    <div class="container">
        <div class="header">
            <div class="back">
                <a href="javascript:history.back()">Back</a>
            </div>
        </div>
        <div class="content3">
            <h3 style="float:left">Transaction Code: <?= $transCode ?></h3>
            <form action="" method="post">
            <?php
            $getTransForm = $def->getTransReal($transCode);
            while ($formTrans = $getTransForm->fetch(PDO::FETCH_OBJ)) { 
                echo "
                <input type='hidden' name='memberID[]' value='$formTrans->memberID'>
                <input type='hidden' name='prodID[]' value='$formTrans->prodID'>
                <input type='hidden' name='transCode[]' value='$formTrans->transCode'>
                <input type='hidden' name='tglTrans[]' value='$formTrans->tglTrans'>
                <input type='hidden' name='nama[]' value='$formTrans->nama'>
                <input type='hidden' name='harga[]' value='$formTrans->harga'>
                <input type='hidden' name='jumlah[]' value='$formTrans->jumlah'>
                <input type='hidden' name='total[]' value='$formTrans->total'>
                <input type='hidden' name='note[]' value='$formTrans->note'>
                <input type='hidden' name='bukti[]' value='$formTrans->bukti'>";
             } ?>
                <button type="submit" name="confirmTrans" class="btn btn-primary" style="float:right;margin-bottom:20px">Confirm Order</button>
            </form>
            <table class="table">
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Note</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                <?php
                foreach ($dataTrans as $rowTrans) {
                    $formatedPrice = number_format($rowTrans['harga'],0,',','.');
                    $formatedTotal = number_format($rowTrans['total'],0,',','.');
                ?>
                <tr>
                    <td><?= $rowTrans['nama'] ?></td>
                    <td>Rp. <?= $formatedPrice ?></td>
                    <td><?= $rowTrans['jumlah'] ?></td>
                    <td><?php
                    if (empty($rowTrans['note'])) {
                        echo "-";
                    }else{
                        echo $rowTrans['note'];
                    }
                    ?></td>
                    <td>Rp. <?= $formatedTotal ?></td>
                    <td><a href="deleteOrders.php?TC=<?= $_GET['id'] ?>&id=<?= $rowTrans['prodID'] ?>" class="btn btn-danger">Delete</a></td>
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
                    <td>-</td>
                    <?php } ?>
                </tr>
            </table>
            <div class="underContent">
                <div class="bukti">
                    <?php
                    $getTransOnly = $def->transOnce($transCode);
                    $dataTransOnly = $getTransOnly->fetchAll();
                    foreach ($dataTransOnly as $rowTransOnly) {
                    ?>
                    <p>Proof Status: <?php 
                    if (empty($rowTransOnly['bukti'])) {
                        echo "- Empty - ";
                    }else{
                        echo "Need Check by Admin";
                    }
                    ?></p>
                    <?php } ?>
                    <?php
                    $getTransOnly = $def->transOnce($transCode);
                    $dataTransOnly = $getTransOnly->fetchAll();
                    foreach ($dataTransOnly as $rowTransOnly) {
                    ?>
                    <p>Order Status: <?= $rowTransOnly['status'] ?></p>
                    <?php } ?>
                </div>
                <div class="status">
                    <div class="uploadBukti">
                    <h4 style="margin-bottom:20px">Upload Payment Proof</h4>
                        <form action="" method="post" enctype="multipart/form-data">
                        <?php foreach ($dataTransOnly as $rowTransOnly) { ?>
                        <img src="<?php 
                        if (empty($rowTransOnly['bukti'])) {
                            echo "img/no-image.png";
                        }else{
                            echo "img/bukti/".$rowTransOnly['bukti'];
                        }
                        ?>" alt="" id="img-prev">
                        <?php } ?>
                          <label class='__lk-fileInput'>
                            <span data-default='Choose file'>Choose file</span>
                            <input type="file" name="potoBukti" id="img-src" onchange="prevImg()">
                        </label><br>
                        <button type="submit" name="uploadBukti" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>Copyright &copy; 2019 Lashopak. All Rights Reserverd.</p>
    </div>
</div>
<script type="text/javascript">
function prevImg() {
    document.getElementById('img-prev').style.display = "block";
    document.getElementById('img-prev').style.width = "200px";
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById('img-src').files[0]);

    oFReader.onload=function(oFREvent){
        document.getElementById('img-prev').src = oFREvent.target.result;
    };
};

$(function(){  
  $('input').change(function(){
    var label = $(this).parent().find('span'); 
    if(typeof(this.files) !='undefined'){ // fucking IE      
      if(this.files.length == 0){
        label.removeClass('withFile').text(label.data('default'));
      }
      else{
        var file = this.files[0]; 
        var name = file.name;
        var size = (file.size / 1048576).toFixed(3); //size in mb 
        label.addClass('withFile').text(name + ' (' + size + 'mb)');
      }
    }
    else{
      var name = this.value.split("\\");
	      label.addClass('withFile').text(name[name.length-1]);
    }
    return false;
  });  
});

$('img').zoomify();
</script>
</body>
</html>