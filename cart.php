<?php require ("config.php");
$def = new lashopak();
$getDB = $def->getDB();
if (isset($_POST['submitTrans'])) {
    function acak($panjang)
    {
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456890';
        $string	  = '';

        for ($i=0; $i < $panjang; $i++) { 
            $pos = rand(0, strlen($karakter)-1);
            $string .= $karakter{$pos};
        };
        return $string;
    };
    $random = acak(11);

    $cartID = $_POST['cartID'];
    $memID = $_POST['memberID'];
    $prodID = $_POST['prodID'];
    $transCode = $random;
    $tglTrans = date("Y-m-d H:i:s");
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];
    $total = $_POST['total'];
    $note = $_POST['note'];

    $query = "INSERT INTO transaksi(memberID, prodID, transCode, tglTrans, nama, harga, jumlah, total, note) VALUES 
    (:memID, :prodID, :transCode, :tglTrans, :nama, :harga, :jumlah, :total, :note)";
    $stmt = $getDB->prepare($query);
    $index = 0;
    foreach ($memID as $dataID) {
        $stmt->bindParam(':memID', $dataID);
        $stmt->bindParam(':prodID', $prodID[$index]);
        $stmt->bindParam(':transCode', $transCode);
        $stmt->bindParam(':tglTrans', $tglTrans);
        $stmt->bindParam(':nama', $nama[$index]);
        $stmt->bindParam(':harga', $harga[$index]);
        $stmt->bindParam(':jumlah', $jumlah[$index]);
        $stmt->bindParam(':total', $total[$index]);
        $stmt->bindParam(':note', $note[$index]);
        if ($stmt->execute()) {
            $delQuery = "DELETE FROM cart WHERE memberID=:memID";
            $stmt2 = $getDB->prepare($delQuery);
            $stmt2->execute(array(':memID' => $dataID));
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
    <title>TOKOLAPAK</title>
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/modal.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/modal.min.js"></script>
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
                                <h1 style="font-size:16px">Your shopping cart is empty</i></h1>
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
    <div class="content3">
        <?php
            if (isset($_SESSION['user'])) {
                if ($countCart > 0) {
        ?>
        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            </table>
        </div>
        <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
            <tbody>
            <?php
                foreach ($dataCart as $rowCartReal) {  
                    $frmtHarga = number_format($rowCartReal['harga'],2,',','.');
                    $frmtTotal = number_format($rowCartReal['total'],2,',','.');
            ?>
                <tr>
                    <td class="a-un"><a href="product.php?pId=<?= $rowCartReal['prodID'] ?>"><?= $rowCartReal['nama'] ?></a></td>
                    <td><?= $rowCartReal['jumlah'] ?></td>
                    <td>Rp. <?= $frmtHarga ?></td>
                    <td>Rp. <?= $frmtTotal ?></td>
                    <td><?= $rowCartReal['note'] ?></td>
                    <td><a href="deleteCart.php?id=<?= $rowCartReal['cartID'] ?>">Delete</a></td>
                </tr> 
            <?php } ?>
                <tr>
                    <td colspan="3" align="right">Total</td>
                    <td align="right">Rp. <?php echo $priceTotal ?></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="6" class="back2"><p id="tombol" name="submitTrans">Buy (<?= $countCart ?>)</p></td>
                </tr>
            </tbody>
            </table>
        </div>
        <?php
                                // Else Countcart
                                    }else{ ?>
                                    <div class="empty">
                                        <div class="back" style="padding-top:0;margin-bottom:30px">
                                        <a href="javascript:history.back()">Back</a>
                                        </div>
                                        <h1>Your shopping cart is empty </h1>
                                    </div>
                            <?php     }
                                }else{ ?>
                                    <div class="empty">
                                    <div class="back" style="padding-top:0;margin-bottom:30px">
                                        <a href="javascript:history.back()">Back</a>
                                    </div>
                                    <h1> You must be logged in to view the cart </h1>
                                    </div>
                            <?php } ?>
    </div>
</div>
<!-- MODAL -->
<div id="bg"></div>
<div id="modal-kotak">
    <form action="" method="post">
        <div id="atas">
        <?php
            $showData = $def->showCart($memID);
            while ($dataCartReal = $showData->fetch(PDO::FETCH_OBJ)) {
                echo "
                    <input type='hidden' name='cartID[]' value='$dataCartReal->cartID'>
                    <input type='hidden' name='prodID[]' value='$dataCartReal->prodID'>
                    <input type='hidden' name='memberID[]' value='$dataCartReal->memberID'>
                    <input type='hidden' name='nama[]' value='$dataCartReal->nama'>
                    <input type='hidden' name='harga[]' value='$dataCartReal->harga'>
                    <input type='hidden' name='jumlah[]' value='$dataCartReal->jumlah'>
                    <input type='hidden' name='total[]' value='$dataCartReal->total'>
                    <input type='hidden' name='note[]' value='$dataCartReal->note'>      
                ";
            }
        ?> 
            If you want to continue purchasing, click the <u>button</u> below and please upload proof of payment on the order page
        </div>
        <div id="bawah">
            <input id="tombol-tutup" type="submit" value="Continue Transaction" name="submitTrans"></input>
        </div>
    </form> 
</div>	
<!-- .MODAL -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#tombol').click(function(){
            $('#modal-kotak , #bg').fadeIn("slow");
        });
        $('#tombol-tutup').click(function(){
            $('#modal-kotak , #bg').fadeOut("slow");
        });
    });
</script>
</body>
</html>