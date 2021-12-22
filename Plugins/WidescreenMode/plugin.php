<?php
// WidescreenMode/plugin.php
// Allows users to set widescreen mode.

class WidescreenMode extends Plugin {

var $id = "WidescreenMode";
var $name = "Widescreen Mode";
var $version = "1.0";
var $description = "Allows users to set widescreen mode";
var $author = "GigaHacer";

function init()
{
	parent::init();

    global $config;
	if (!$this->eso->db->numRows("SHOW COLUMNS FROM {$config["tablePrefix"]}members LIKE 'widescreen'")) {
		$this->eso->db->query("ALTER TABLE {$config["tablePrefix"]}members ADD COLUMN widescreen tinyint(1) NOT NULL default '0'");
	}

	// Language definitions.
	$this->eso->addLanguage("widescreenMode", "Widescreen Mode");

	// If we're on the settings view, add the skin settings!
	if ($this->eso->action == "settings") {
		$this->eso->controller->addHook("init", array($this, "addWidescreenSettings"));
	}

    $this->eso->addHook("init", array($this, "setWidescreen"));

}

function setWidescreen()
{
    if (!empty($this->eso->user["widescreen"])) $this->eso->addCSS("plugins/WidescreenMode/widescreen.css");
}

function addWidescreenSettings(&$settings)
{
	global $language;

	$settings->addToForm("settingsOther", array(
		"id" => "widescreen",
        "html" => "<label for='widescreenMode' class='checkbox'>{$language["widescreenMode"]}</label> <input id='widescreen' type='checkbox' class='checkbox' name='widescreen' value='1' " .  (!empty($this->eso->user["widescreen"]) ? "checked='checked' " : "") . "/>",
		"databaseField" => "widescreen",
		"checkbox" => true
	), 250);
}

}
?>
