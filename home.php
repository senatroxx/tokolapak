<script>
$(document).ready(function () {
$(".description").each(function () {
        if ($(this).text().length > 150) {
            $(this).text($(this).text().substr(0, 150) + '...');
        }
	}); 

})
</script>
<div class="inline content2">
<?php require ('config.php');
$search = $_GET['search'];
$def = new lashopak();
if (isset($_GET['search'])) {
	echo "asd";
	$param = "vietnam";
	$addSearch = $def->searchProd($param);
	$dataSearch = $addSearch->fetchAll();
	foreach ($dataSearch as $row) {
	?>
	<div class='block'>
		<div class='product'>
			<img src='img/prod/<?= $row["poto"]; ?>'>
				<div class='buttons'>
				<a class='buy' href='index.php?pId=<?=$row['id']?>&nama=<?= $row['namaprod'] ?>&harga=<?= $row['hargabrg'] ?>&jumlah=1' name="addToCart">Add to cart</a>
				<a class='preview' href='product.php?id=<?= $row['id'] ?>'>View item</a>
			</div>

		</div>

		<div class='info'>
			<h4><?= $row['namaprod']; ?></h4>
			<span class='description'>
				<?= $row['deskprod']; ?>
			</span>
			<span class='price'>Rp. <?= $harga ?></span>
			<a class='buy_now' href='#'>Buy Now</a>

		</div>

		<div class='details'>
			<span class='time'>12 hours ago</span>
		</div>
	</div>
<?php }}else{ 
$getProd = $def->getProd();
$data = $getProd->fetchAll();
foreach ($data as $row) {
	$harga = number_format($row["hargabrg"],0,',','.');
?>
	<div class='block'>
		<div class='product'>
			<img src='img/prod/<?= $row["poto"]; ?>'>
				<div class='buttons'>
				<a class='buy' href='index.php?pId=<?=$row['id']?>&nama=<?= $row['namaprod'] ?>&harga=<?= $row['hargabrg'] ?>&jumlah=1' name="addToCart">Add to cart</a>
				<a class='preview' href='product.php?id=<?= $row['id'] ?>'>View item</a>
			</div>

		</div>

		<div class='info'>
			<h4><?= $row['namaprod']; ?></h4>
			<span class='description'>
				<?= $row['deskprod']; ?>
			</span>
			<span class='price'>Rp. <?= $harga ?></span>
			<a class='buy_now' href='#'>Buy skrg</a>

		</div>

		<div class='details'>
			<span class='time'>12 hours ago</span>
		</div>
	</div>
<?php }} ?>
</div>
<script>
document.getElementById("submitButton").onclick = function() {
    document.getElementById("submitForm").submit();
}
</script>