<?php
	class Engine
	{
		public $newbdd;

		public function __construct()
		{
			$this->newbdd = new BDD();
		}

		public static function getState($id)
		{
			$newStaticBdd = new BDD();
			$State = $newStaticBdd->select("name", "states", "WHERE id LIKE '".$id."'");
			$getState = $newStaticBdd->fetch_array($State);

			return $getState['name'];
		}

		public static function getCategorie($id)
		{
			$newStaticBdd = new BDD();
			$Categories = $newStaticBdd->select("name", "categories", "WHERE id LIKE '".$id."'");
			$getCategories = $newStaticBdd->fetch_array($Categories);

			return $getCategories['name'];
		}

		public static function getCharts($to, $value)
		{
			$json = file_get_contents("http://api.bitcoincharts.com/v1/weighted_prices.json");	
			$parsed_json = json_decode($json);

			$date_jour = $parsed_json->{$to}->{'24h'};
			$btc = "${date_jour}";

			$chart =  $btc * $value;

			echo number_format($chart, 2); 
		}
	}
?>