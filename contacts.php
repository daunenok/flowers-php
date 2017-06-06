<?php 
$expected = ["name", "email", "comments", "subscribe", "interests", "hear", "characteristics", "accept"];
$required = ["name", "comments", "interests", "hear", "characteristics", "accept"];
$interestsMin = 2;
$characteristicsMin = 2;
$missing = [];
$interests = [];
$characteristics = [];
$accept = "";
$comments = "";
$name = "";
$email = "";

if (isset($_POST["submit"])) {
	$suspect = false;
	foreach ($_POST as $key => $value) {
		if (in_array($key, $expected)) {
			if(!is_array($value)) $value = trim($value);
			if (empty($value) && in_array($key, $required)) {
				$missing[] = $key;
			} else {
				$$key = $value;
			}
			if ($key == "name" || $key == "email" || $key == "comments")
				$suspect = $suspect || suspected($value); 
		}
	}
	if (!empty($email)) {
		$validEmail = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
		if (!$validEmail) $error["email"] = true;
	}
	if (count($interests) < $interestsMin) {
		$error["interests"] = true;
	}
	if (count($characteristics) < $characteristicsMin) {
		$error["characteristics"] = true;
	}
	if (empty($accept)) {
		$missing[] = "accept";
	}

	if (!$suspect && !$missing && !$error) {
		$to = "qqq@qqq.ru";
		$subject = "Feedback from Flowers Exibition";
		$subject = htmlentities($subject);
		$headers = "From: Flowers Exibition<flowers@qqq.ru>";
		$headers .= "\r\nContent-Type: text/plain; charset=utf-8";
		if ($validEmail) $headers .= "\r\nReply-To: $validEmail";
		$headers = htmlentities($headers);

		$body = "";
		foreach ($expected as $key) {
			$mess1 = ucfirst($key);
			if (empty($$key)) {
				$mess2 = "Not defined";
			} else {
				$mess2 = $$key;
			}
			if (is_array($mess2)) {
				$mess = implode(", ", $mess2);
			} else {
				$mess = $mess2;
			}
			$body .= "$mess1: $mess\r\n\r\n";
		}
		$body = htmlentities($body);

		if (@mail($to, $subject, $body, $headers)) {
			header("Location: thanks.php");
		} else {
			$error["mail"] = true;
		}
	}
}

function suspected($str) {
	$pattern = "/Content-Type:|Bcc:|Cc:/i";
	if (preg_match($pattern, $str)) 
		return true;
	else
		return false;
}
?>

<?php require_once "header.php"; ?>

<div class="wrap">
<div class="contacts">
	<h2>Contact Us</h2>
	<p>Nullam a ligula varius, sollicitudin velit quis, mattis nunc. Nam consequat bibendum libero vel venenatis. Cras rhoncus nisi condimentum elit convallis, in vulputate erat interdum. Phasellus dignissim egestas sagittis.</p>

	<form method="post">
		<?php if (isset($suspect) || isset($error["mail"])) { ?>
		<p>Sorry, your mail could not be sent.</p>
		<?php } ?>

		<label for="name">
			Name:
			<?php if(isset($missing) && in_array("name", $missing)) { ?>
			<span>Please enter your name</span>
			<?php } ?>
		</label>
		<input type="text" name="name" id="name" value="<?=$name?>">

		<label for="email">
			Email:
			<?php if(isset($error["email"])) { ?>
			<span>Invalid email</span>
			<?php } ?>
		</label>
		<input type="email" name="email" id="email" value="<?=$email?>">

		<label for="comments">
			Comments:
			<?php if(in_array("comments", $missing)) { ?>
			<span>Please enter your comments</span>
			<?php } ?>
		</label>

		<textarea name="comments" id="comments" rows="5"><?=$comments?></textarea>

		<div class="input-title">Subscribe to newsletters?</div>
		<label class="label-inline">
			<input type="radio" name="subscribe" value="Yes"
			<?php if($_POST && $_POST["subscribe"]=="Yes") echo " checked"; ?>
			> Yes
		</label>
		<label class="label-inline">
			<input type="radio" name="subscribe" value="No"
			<?php if(!$_POST || $_POST["subscribe"]=="No") echo " checked"; ?>
			> No
		</label>

		<br><br>
		<div class="input-title">
			Interests in Flowers
			<?php 
			if(in_array("interests", $missing) || isset($error["interests"])) { 
				echo "<span>Please check $interestsMin or more interests</span>";
			} 
			?>
		</div>
		<label class="label-check">
			<input type="checkbox" name="interests[]" value="Gardening"
			<?php if($_POST && in_array("Gardening", $interests)) echo " checked"; ?>
			>Gardening 
		</label>
		<label class="label-check">
			<input type="checkbox" name="interests[]" value="Environmental impact"
			<?php if($_POST && in_array("Environmental impact", $interests)) echo " checked"; ?>
			>Environmental impact
		</label>
		<label class="label-check">
			<input type="checkbox" name="interests[]" value="Plants to my climate"
			<?php if($_POST && in_array("Plants to my climate", $interests)) echo " checked"; ?>
			>Plants to my climate 
		</label>
		<label class="label-check">
			<input type="checkbox" name="interests[]" value="Perfume"
			<?php if($_POST && in_array("Perfume", $interests)) echo " checked"; ?>
			>Perfume
		</label>
		<label class="label-check">
			<input type="checkbox" name="interests[]" value="Heat-tolerant flowers"
			<?php if($_POST && in_array("Heat-tolerant flowers", $interests)) echo " checked"; ?>
			>Heat-tolerant flowers 
		</label>
		<label class="label-check">
			<input type="checkbox" name="interests[]" value="Flowers for verandas"
			<?php if($_POST && in_array("Flowers for verandas", $interests)) echo " checked"; ?>
			>Flowers for verandas
		</label>

		<br><br>
		<label for="hear">
			How you did hear of Flowers Exibition?
			<?php if(in_array("hear", $missing)) { ?>
			<span>Please select the source</span>
			<?php } ?>
		</label>
		<select name="hear" id="hear">
			<option value="" 
			<?php if (!$_POST || $_POST["hear"] == "") echo " selected"; ?>
			>No select
			</option>
			<option value="From internet"
			<?php if ($_POST && $_POST["hear"] == "From internet") echo " selected"; ?>
			>From internet
			</option>
			<option value="From magazine or journal"
			<?php if ($_POST && $_POST["hear"] == "From magazine or journal") echo " selected"; ?>
			>From magazine or journal
			</option>
			<option value="From friends"
			<?php if ($_POST && $_POST["hear"] == "From friends") echo " selected"; ?>
			>From friends
			</option>
		</select>

		<br><br>
		<label for="characteristics">
			What characteristics do you associate with flowers?
			<?php 
			if(in_array("characteristics", $missing) || isset($error["characteristics"])) { 
				echo "<span>Please check $characteristicsMin or more characteristics</span>";
			} 
			?>
		</label>
		<select name="characteristics[]" id="characteristics" multiple>
			<option value="cheerful"
			<?php if ($_POST && in_array("cheerful", $characteristics)) echo " selected"; ?>
			>cheerful</option>
			<option value="delicate"
			<?php if ($_POST && in_array("delicate", $characteristics)) echo " selected"; ?>
			>delicate</option>
			<option value="delightful"
			<?php if ($_POST && in_array("delightful", $characteristics)) echo " selected"; ?>
			>delightful</option>
			<option value="scented"
			<?php if ($_POST && in_array("scented", $characteristics)) echo " selected"; ?>
			>scented</option>
			<option value="stunning"
			<?php if ($_POST && in_array("stunning", $characteristics)) echo " selected"; ?>
			>stunning</option>
			<option value="vibrant"
			<?php if ($_POST && in_array("vibrant", $characteristics)) echo " selected"; ?>
			>vibrant</option>
		</select>

		<br><br>
		<label>
			<input type="checkbox" name="accept">
			I accept the terms of using this website
			<?php if(in_array("accept", $missing)) { ?>
			<span>You should accept the terms to sent message</span>
			<?php } ?>
		</label>

		<input type="submit" name="submit" value="Send message">
	</form>
</div>
</div>

<?php require_once "footer.php"; ?>