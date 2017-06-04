<?php 
$title = basename($_SERVER["SCRIPT_NAME"], ".php");
$home = $blog = $gallery = $contacts = "";
switch ($title) {
	case "index":
		$home = " active";
		break;
	case "blog":
		$blog = " active";
		break;
	case "gallery":
		$gallery = " active";
		break;
	case "contacts":
		$contacts = " active";
		break;
}
$title = ucfirst($title);
if ($title == "Index") $title = "Home";

$file = fopen("buket.csv", "r");
$cols = fgetcsv($file);
$col1 = $cols[0];
$col2 = $cols[1];
$bukets = [];
while (($row = fgetcsv($file)) !== false) {
	$bukets[] = array_combine($cols, $row);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Flowers Exibition - <?=$title?></title>
    <link href="https://fonts.googleapis.com/css?family=Merienda+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Baloo" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>

<header>
	<h1>Flowers Exibition</h1>
</header>

<section>
	<nav>
		<ul>
			<li>
				<div class="rect<?=$home?>"></div>
				<a href="index.php">Home</a>
			</li>
			<li>
				<div class="rect<?=$blog?>"></div>
				<a href="blog.php">Blog</a>
			</li>
			<li>
				<div class="rect<?=$gallery?>"></div>
				<a href="gallery.php">Gallery</a>
			</li>
			<li>
				<div class="rect<?=$contacts?>"></div>
				<a href="contacts.php">Contacts</a>
			</li>
		</ul>
		<div class="advert">Advert</div>
		<table>
			<?php 
				foreach ($bukets as $buket) {
					echo "<tr>";
					echo "<td>" . ucfirst($buket[$col1]). "</td>";
					echo "<td>" . "$" . $buket[$col2] . "</td>";
					echo "</tr>";
				}
			?>
		</table>
	</nav>