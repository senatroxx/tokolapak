<?php require ('../config.php');
if (empty($_SESSION['admin'])) {
    header("location:login.php");
}
$def = new lashopak();
if (isset($_POST['upload'])) {
    $poto = $_FILES['poto'];
    $nama = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);
    $stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_STRING);
    $add = $def->addProduct($poto, $nama, $desc, $category, $price, $stock);
}

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
                                <a class="nav-link" href="order.php" aria-expanded="false"><i class="fas fa-fw fa-hourglass-half"></i>Order</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link active" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fab fa-fw fa-product-hunt"></i>Product</a>
                                <div id="submenu-1" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="addprod.php">Add Product</a>
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
                    <a href="javascript:history.back()" class="btn btn-warning mb-3">Back</a>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <img class="img-fluid mb-3" src="assets/images/no-image.png" alt="" id="img-prev">
                                        <div class="form-group">
                                            <input type="file" class="form-control-file" id="img-src" name="poto"  onchange="prevImg()" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="productName1">Product Name</label>
                                            <input class="form-control" type="text" placeholder="Enter Name" id="productName1" name="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="descText">Product Description</label>
                                            <textarea name="desc" id="descText" rows="10" placeholder="Description" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="selectCategory">Category</label>
                                            <select name="category" id="selectCategory" name="category" class="form-control">
                                                <option value="">--Select Category--</option>
                                                <?php
                                                    $selectCat = $def->showCategory();
                                                    while ($data = $selectCat->fetch(PDO::FETCH_OBJ)) {
                                                        echo "
                                                        <option value='$data->id'>$data->namaktg</option>
                                                        ";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="priceText">Price</label>
                                            <input type="number" name="price" id="priceText" class="form-control" placeholder="Product Price">
                                        </div>
                                        <div class="form-group">
                                            <label for="stockText">Stock</label>
                                            <input type="numer" name="stock" id="stockText" class="form-control" placeholder="Product Stock">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-right mt-5">
                                    <input type="submit" value="Upload Product" name="upload" class="from-control btn btn-primary">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Image Preview -->
    <script type="text/javascript">
    	function prevImg() {
            document.getElementById('img-prev').style.display = "block";
            document.getElementById('img-prev').style.width = "100%";
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById('img-src').files[0]);

            oFReader.onload=function(oFREvent){
                document.getElementById('img-prev').src = oFREvent.target.result;
            };
        };
    </script>
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