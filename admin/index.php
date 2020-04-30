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
    <!-- <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet"> -->
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
                            <li class="nav-item">
                                <a class="nav-link active" href="index.php" aria-expanded="false"><i class="fa fa-fw fa-home"></i>Dashboard</a>
                            </li>
                            <li class="nav-item">
                            <?php
                            $countTrans = $def->countTrans();
                            ?>
                                <a class="nav-link" href="order.php" aria-expanded="false"><i class="fas fa-fw fa-hourglass-half"></i>Order<span class="badge badge-danger"><?= $countTrans ?></span></a>
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
                            <li class="nav-item ">
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
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Dashboard</h2>
                                <p class="pageheader-text">dashboard</p>
                                <!-- <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">E-Commerce Dashboard Template</li>
                                        </ol>
                                    </nav>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="ecommerce-widget">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="card border-3 border-top border-info">
                                    <div class="card-body">
                                        <h5 class="text-muted">Admin</h5>
                                        <div class="metric-value d-inline-block">
                                            <?php $countAdmin = $def->countAdmin(); ?>
                                            <h1 class="mb-1"><?= $countAdmin ?></h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                            <!-- <span class="icon-circle-small icon-box-xs text-success bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1">5.86%</span> -->
                                            <i class="fas fa-fw fa-lock fa-4x text-muted" style="top:50%;position:absolute;transform:translate(0,-50%);left:50%"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="card border-3 border-top border-top-primary">
                                    <div class="card-body">
                                        <h5 class="text-muted">Users</h5>
                                        <div class="metric-value d-inline-block">
                                        <?php
                                        $countUser = $def->countUser();
                                        ?>
                                            <h1 class="mb-1"><?= $countUser ?></h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                            <!-- <span class="icon-circle-small icon-box-xs text-success bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1">5.86%</span> -->
                                            <i class="fas fa-user fa-4x text-muted" style="top:50%;position:absolute;transform:translate(0,-50%);left:50%"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="card border-3 border-top border-brand">
                                    <div class="card-body">
                                        <h5 class="text-muted">Product</h5>
                                        <div class="metric-value d-inline-block">
                                        <?php
                                        $countProd = $def->countProd();
                                        ?>
                                            <h1 class="mb-1"><?= $countProd ?></h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                            <!-- <span class="icon-circle-small icon-box-xs text-success bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1">5.86%</span> -->
                                            <i class="fab fa-fw fa-product-hunt fa-4x text-muted" style="top:50%;position:absolute;transform:translate(0,-50%);left:50%"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="card border-3 border-top border-secondary">
                                    <div class="card-body">
                                        <h5 class="text-muted">Order</h5>
                                        <div class="metric-value d-inline-block">
                                        <?php
                                        $countTrans = $def->countTrans();
                                        ?>
                                            <h1 class="mb-1"><?= $countTrans ?></h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                            <!-- <span class="icon-circle-small icon-box-xs text-success bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1">5.86%</span> -->
                                            <i class="fas fa-fw fa-hourglass-half fa-4x text-muted" style="top:50%;position:absolute;transform:translate(0,-50%);left:50%"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">User List</h5>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $showUser = $def->showUser();
                                        $dataUser = $showUser->fetchAll();
                                        foreach ($dataUser as $rowUser) {
                                        ?>
                                            <tr>
                                                <th scope="row"><?= $rowUser['id'] ?></th>
                                                <td><?= $rowUser['username'] ?></td>
                                                <td><?= $rowUser['nama'] ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Product List</h5>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $showProd = $def->getProd();
                                        $dataProd = $showProd->fetchAll();
                                        foreach ($dataProd as $rowProd) {
                                            $priceProd = number_format($rowProd['hargabrg'],0,',','.');
                                        ?>
                                            <tr>
                                                <th scope="row"><?= $rowProd['id'] ?></th>
                                                <td><?= $rowProd['namaprod'] ?></td>
                                                <td>Rp. <?= $priceProd ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
</body>
</html>