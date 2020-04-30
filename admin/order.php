<?php require ('../config.php');
if (empty($_SESSION['admin'])) {
    header("location:login.php");
}
$def = new lashopak();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin TOKOLAPAK</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <!-- <link rel="stylesheet" href="assets/vendor/charts/chartist-bundle/chartist.css"> -->
    <!-- <link rel="stylesheet" href="assets/vendor/charts/morris-bundle/morris.css"> -->
    <!-- <link rel="stylesheet" href="assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css"> -->
    <!-- <link rel="stylesheet" href="assets/vendor/charts/c3charts/c3.css"> -->
    <!-- <link rel="stylesheet" href="assets/vendor/fonts/flag-icon-css/flag-icon.min.css"> -->
</head>
<body>
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-light fixed-top">
                <a class="navbar-brand" href="index.html">TOKOLAPAK</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item dropdown nav-user">
                            <!-- <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/avatar-1.jpg" alt="" class="user-avatar-md rounded-circle"></a> -->
                            <a class="nav-link nav-user-img" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user" style="margin-right:10px"></i> <?= $_SESSION['admin']['nama']; ?></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <!-- <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">John Abraham </h5>
                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div> -->
                                <!-- <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a> -->
                                <!-- <a class="dropdown-item" href="setting.php?id=<?= $_SESSION['admin']['id']; ?>"><i class="fas fa-cog mr-2"></i>Setting</a> -->
                                <a class="dropdown-item" href="../logout.php"><i class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="index.php">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="index.php" aria-expanded="false"><i class="fa fa-fw fa-home"></i>Dashboard</a>
                            </li>
                            <li class="nav-item ">
                            <?php
                            $countTrans = $def->countTrans();
                            ?>
                                <a class="nav-link active" href="order.php" aria-expanded="false"><i class="fas fa-fw fa-hourglass-half"></i>Order<span class="badge badge-danger"><?= $countTrans ?></span></a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fab fa-fw fa-product-hunt"></i>Product</a>
                                <div id="submenu-1" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="addprod.php">Add Product</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="prodlist.php">Product List</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="category.php" aria-expanded="false"><i class="fas fa-fw fa-folder"></i>Category</a>
                            </li>
                            <li class="nav-item logout">
                                <a class="nav-link" href="../logout.php" aria-expanded="false"><i class="fas fa-sign-out-alt"></i></i></i>Log Out</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <div class="row">
                        <div class="col"> 
                            <div class="card">
                                <!-- <h5 class="card-header">Basic Table</h5> -->
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th width="180px">Transaction Code</th>
                                                <th>Buyer Name</th>
                                                <th>Address</th>
                                                <th>Order Date</th>
                                                <th>Payment</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $getProd = $def->showTrans();
                                        $dataProd = $getProd->fetchAll();
                                        foreach ($dataProd as $rowProd) {
                                            $memID = $rowProd['memberID'];
                                            $sendUser = $def->getTransUser($memID);
                                            $dataUser = $sendUser->fetchAll();
                                            foreach ($dataUser as $rowUser) {
                                        ?>
                                        <tbody>
                                            <tr class="clickable" data-toggle="collapse" data-target="#<?= $rowProd['transCode'] ?>" aria-expanded="false" aria-controls="<?= $rowProd['transCode'] ?>">
                                                <td><i class="fa fa-plus-circle" style="color:#2ecc71" aria-hidden="true"></i> <?= $rowProd['transCode'] ?></td>
                                                <td><?= $rowUser['nama'] ?></td>
                                                <td class="address"><?= $rowUser['address'] ?></td>  
                                                <td><?= $rowProd['tglTrans'] ?></td>
                                                <td><?php 
                                                if (empty($rowProd['bukti'])) {
                                                    echo "- Empty -";
                                                }else if (isset($rowProd['bukti']) && $rowProd['status'] == "On Process" ) {
                                                    echo "Payment Accepted";
                                                }else if (isset($rowProd['bukti'])) {
                                                    echo "Needs Check";
                                                }
                                                ?>
                                                </td><td><?= $rowProd['status'] ?></td>
                                                <td><a href="detailTrans.php?id=<?= $rowProd['transCode'] ?>" class="btn btn-primary btn-sm">Detail</a></td>
                                            </tr>
                                        </tbody>
                                        <tbody id="<?= $rowProd['transCode'] ?>" class="collapse ml-2">
                                            <tr>
                                                <th style="text-align:center"><i class="fas fa-level-up-alt fa-rotate-90 center"></i></th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th colspan="3">Note</th>
                                            </tr>
                                        <?php 
                                        $transCode = $rowProd['transCode'];
                                        $sendCode = $def->getTransReal($transCode);
                                        $dataCode = $sendCode->fetchAll();
                                        foreach ($dataCode as $rowCode) {
                                            $formatedPrice = number_format($rowCode['harga'],0,',','.');
                                        ?>
                                            <tr>
                                                <td></td>
                                                <td><?= $rowCode['nama'] ?></td>
                                                <td>Rp. <?= $formatedPrice ?></td>
                                                <td><?= $rowCode['jumlah'] ?></td>  
                                                <td colspan="3" class="note"><?php
                                                if (empty($rowCode['note'])) {
                                                    echo "-";
                                                }else{
                                                    echo $rowCode['note'];
                                                }
                                                ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <?php }} ?>
                                    </table>

                                </div>
                            </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <!-- <script src="assets/vendor/charts/chartist-bundle/chartist.min.js"></script> -->
    <!-- sparkline js -->
    <!-- <script src="assets/vendor/charts/sparkline/jquery.sparkline.js"></script> -->
    <!-- morris js -->
    <!-- <script src="assets/vendor/charts/morris-bundle/raphael.min.js"></script> -->
    <!-- <script src="assets/vendor/charts/morris-bundle/morris.js"></script> -->
    <!-- chart c3 js -->
    <!-- <script src="assets/vendor/charts/c3charts/c3.min.js"></script> -->
    <!-- <script src="assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script> -->
    <!-- <script src="assets/vendor/charts/c3charts/C3chartjs.js"></script> -->
    <script src="assets/libs/js/dashboard-ecommerce.js"></script>
    <script>
    $(document).ready(function () {
    $(".note").each(function () {
            if ($(this).text().length > 50) {
                $(this).text($(this).text().substr(0, 50) + '...');
            }
        }); 
    })
    $(".address").each(function () {
            if ($(this).text().length > 50) {
                $(this).text($(this).text().substr(0, 50) + '...');
            }
        }); 
    })
    </script>
</body>
</html>