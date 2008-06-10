<?php
include_once "classes/Archive.php";

class Image extends Archive {

	var $image_id;
	function setFromRequest() {
		parent::setFromRequest();
		if (isset($_REQUEST["image"])) { $this->image_id = $_REQUEST["image"]; }
	}
	
	function getImageFile() {
		return ("images/".$this->image_id.".jpg");
	}
	
	function getThumbnailFile() {
		return ("images/tn_".$this->image_id.".jpg");
	}
	
	function getLink() {
		return ("<a href=\"image.php?image=".$this->image_id."\">".
			"<img src=\"".$this->getThumbnailFile()."\" width=\"100\" height=\"100\" border=\"0\" title=\"".$this->getDescription()."\" alt=\"".$this->getDescription()."\" /></a>");
	}

	function getTitleLink() {
		return ("<a href=\"image.php?image=".$this->image_id."\">".$this->getTitle()."</a>");
	}
}
?>
