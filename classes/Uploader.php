<?php
class Uploader {
	protected $destination;
	protected $max = 204800;
	protected $errors = [];
	protected $permitted = ["image/png",
	                        "image/jpeg",
	                        "image/gif"];

	public function __construct($path) {
		$this->destination = $path;
	}

	public function upload() {
		foreach ($_FILES["image"]["name"] as $key => $val) {
			$file["name"] = $_FILES["image"]["name"][$key];
			$file["tmp_name"] = $_FILES["image"]["tmp_name"][$key];
			$file["error"] = $_FILES["image"]["error"][$key];
			$file["size"] = $_FILES["image"]["size"][$key];
			$file["type"] = $_FILES["image"]["type"][$key];
			if ($this->checkFile($file))
				$this->moveFile($file);
		} 
	}

	protected function checkFile($file) {
		$result = true;

		if ($file["error"] == 4) {
			$this->errors[] = "Form submitted with no file specifed";
			return false;
		}

		if ($file["size"] > $this->max) {
			$result = false;
			$this->errors[] = "File exceeds the maximum size"; 
		}

		if (!in_array($file['type'], $this->permitted)) {
			$result = false;
			$this->errors[] = "Not permitted type of file"; 
		}

		return $result;
	}

	protected function moveFile($file) {	
		$name = $file["name"];
		$dir = $this->destination;
		$existing = scandir($dir);
		$part1 = pathinfo($name)["filename"];
		$part2 = pathinfo($name)["extension"];
		$i = 1;
		while (in_array($name, $existing)) {
			$name = $part1 . "_" . $i++ . "." . $part2;
		}

		$temp = $file["tmp_name"];
		$dest = $dir . "/" . $name;
		move_uploaded_file($temp, $dest);
	}

	public function getErrors() {
		return $this->errors;
	}
}