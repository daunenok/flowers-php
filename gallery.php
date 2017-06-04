<?php require_once "header.php"; ?>

<?php 
if (isset($_POST["upload"])) {
	require_once "classes/Uploader.php";
	$dir = $_SERVER["DOCUMENT_ROOT"] . "/uploads";
	$worker = new Uploader($dir);
	$worker->upload();
	$errs = $worker->getErrors();
}
?>

<div class="wrap">
<div class="gallery">
	<div class="errors">
		<?php 
		if ($errs) {
			echo "<ul>";
			foreach ($errs as $err) {
				echo "<li>$err</li>";
			}
			echo "</ul>";
		}
		?>
	</div>

	<form action="" enctype="multipart/form-data" method="post">
		<label>
			Upload image:
			<input type="file" name="image[]" multiple>
		</label>
		<input type="submit" name="upload" value="Upload">
	</form>

<?php 
$dir = $_SERVER["DOCUMENT_ROOT"] . "/uploads";
$images = scandir($dir);
echo "<div class='images'>";
foreach ($images as $image) {
	if ($image != "." && $image != "..") {
		echo "<figure>";
		echo "<img src='uploads/$image'>";
		echo "<br><a href='uploads/$image' download>Download image</a>";
		echo "</figure>";
	}
}
echo "</div>";
?>

</div>
</div>

<?php require_once "footer.php"; ?>