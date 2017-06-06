<?php 
$url = "https://www.eurekalert.org/rss/agriculture.xml";
$rss = simplexml_load_file($url, "SimpleXMLIterator");
$rss5 = new LimitIterator($rss->channel->item, 0, 3);
?>

<?php require_once "header.php"; ?>

<div class="wrap">
<div class="articles">

<?php 
$path = $_SERVER["DOCUMENT_ROOT"] . "/phpsites/flowers/articles/article1.txt";
$file = file($path);
echo "<h2>" . $file[0] . "</h2>";
echo "<div class='article-date'>" . $file[1] . "</div>";
echo "<p>" . $file[2] . "</p>";
?>

<h2 class="h2rss">The Latest from EurekAlert! - Agriculture</h2>
<div class="rss">
	<?php
	foreach ($rss5 as $item) {
		echo "<a href='$item->link' target='_blank'>$item->title</a>";
		echo "<p>$item->description</p>";
	}
	?>	
</div>

</div>
</div>

<?php require_once "footer.php"; ?>