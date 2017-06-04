<?php 
$captions = ["flowers1.jpg" => "Wonderful wildflowers!",
             "flowers2.jpg" => "Beautiful roses!",
             "flowers3.jpg" => "Colorful asters!",
             "flowers4.jpg" => "Multicolored tulips!",
             "flowers5.jpg" => "Gentle carnations!",
             "flowers6.jpg" => "A wonderful combination of carnations and daisies!"];	
$count = count($captions);

$files = new FilesystemIterator('./images');
$imgs = new RegexIterator($files,"/\.jpg$/i");
$filenames = [];
foreach ($imgs as $img) {
	$filenames[] = $img->getFilename();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	$img = "flowers" . rand(1, $count) . ".jpg";
} else {
	$img = $_POST["select"];
}
?>

<?php require_once "header.php"; ?>

<article>
	<h2>Flowers exibition with PHP</h2>
	<figure>
		<div class="type-image">
			<?php
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					echo "Featured Image";
				} else {
					echo "Random Image";
				}
			?>
		</div>
		<img src="images/<?=$img?>" class="right">
		<figcaption><?=$captions[$img]?></figcaption>

		<form action="" method="post">
		<fieldset>
			<legend>Select an image</legend>
			<select name="select">
				<?php 
				foreach ($filenames as $filename) {
					echo "<option>" . $filename . "</option>";
				}
				?>
			</select>
			<input type="submit" name="submit" value="Send selection">
		</fieldset>
		</form>
	</figure>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras lorem sapien, vehicula in mi in, ultrices sagittis nibh. Vivamus eu diam vel mauris blandit laoreet ac in lorem. Aliquam interdum ullamcorper lectus venenatis imperdiet. Nam sit amet velit vel nisi elementum malesuada. Fusce tempus, diam ac euismod mattis, ipsum tortor mollis ante, non sagittis turpis libero fermentum erat. Nullam eget nunc posuere, rhoncus eros sed, pulvinar turpis. Etiam suscipit ex eget sem mattis, vitae mattis neque molestie. Etiam risus ex, mollis quis eros ut, scelerisque dignissim sem. Fusce ut lacinia magna, vitae dignissim tortor. Mauris lectus urna, convallis eget condimentum volutpat, egestas et sapien. In ipsum purus, condimentum convallis molestie ut, luctus ut magna. Quisque vitae vehicula erat, vel euismod odio. Vestibulum purus metus, bibendum in ante eu, malesuada volutpat lectus. Duis gravida magna vel tortor tempor, sit amet finibus neque dignissim. Maecenas non mattis mauris.</p>
	<p>Nullam quis nibh eu neque euismod iaculis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In hac habitasse platea dictumst. Morbi quis ante malesuada, maximus nunc id, dignissim eros. Maecenas viverra ac augue at volutpat. Donec pellentesque, sapien in ultrices fringilla, mauris ligula dapibus lacus, at consequat diam arcu vel ante. Donec blandit, dui nec volutpat porta, elit tellus suscipit nunc, sit amet rutrum quam ipsum mollis arcu.</p>
</article>

<?php require_once "footer.php"; ?>
