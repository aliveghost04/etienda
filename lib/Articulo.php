<?php 
	class Articulo {

		var $id;
		var $name;
		var $state;
		var $description;
		var $manufacture;
		var $clasification;
		var $price;
		var $quantity;
		var $pubdate;
		var $useridsale;
		var $categoryid;
		var $image;

		function __construct($name, $state, $description, $manufacture, $clasification, $price, $quantity, $pubdate, $useridsale, $categoryid, $image) {
			
			$this->name = $name;
			$this->state = $state;
			$this->description = $description;
			$this->manufacture = $manufacture;
			$this->clasification = $clasification;
			$this->price = $price;
			$this->quantity = $quantity;
			$this->pubdate = $pubdate;
			$this->useridsale = $useridsale;
			$this->categoryid = $categoryid;
			$this->image = $image;
		}

		function __set($attribute, $value) {
			$this->$attribute = $value;
		}

		function __get($attribute) {
			return $this->$attribute;
		}
	}
