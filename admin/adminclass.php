<?php
class changeString{
	
	public $list = array("<" => "&lt;", ">" => "&gt;");
	public $value = "";
	
	//置換
	public function replace($string){
	
		$this->value = str_replace(array_keys($this->list), array_values($this->list), $string);
		
		return $this->value;
	}

	//戻す
	public function restore($string){
		$this->value = str_replace(array_values($this->list), array_keys($this->list), $string);

		return $this->value;
	}
}

?>