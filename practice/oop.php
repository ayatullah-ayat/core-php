<?php
class Hello {
	protected $lang; // only accessible in the class
	function __construct($lang) {
		$this->lang = $lang;
	}
	function greet() {
		var_dump($this->lang);
		if($this->lang == 'fr') return 'Bonjour';
		if($this->lang == 'es') return 'Hola';
		return 'hello';
	}
}
$hi = new Hello('es');
$hi->greet();

?>