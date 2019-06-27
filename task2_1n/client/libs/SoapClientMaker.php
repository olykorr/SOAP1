<?php
ini_set("soap.wsdl_cache_enable", "0");
include_once "./config.php";

class SoapClientMaker
{
	private $model;
	private $view;

	public function __construct()
	{
		$this->model['CARS']= array();
		$this->client = new SoapClient(WSDL_CLASS);
	}

	public function getCarById($id)
	{
		$carsById=array();

		$arrParams=json_encode($id);
		$cars=$this->client->getCarById($id);

		$objcars=json_decode($cars);

		foreach($objcars as $car)
		{
			$car=(array)$car;
			$curCar=array(
						'BRAND' =>$car['brand'],
						'ID' => $car['id'],
						'MODEL' => $car['model'],
						'YEAR' => $car['year'],
						'COLOR' => $car['color'],
						'MAX_SPEED' => $car['max_speed'],
						'PRICE' => $car['price']);

		array_push($carsById,$curCar);
		}

		return $carsById;
	}

	public function	getCarsByParams($arrParams)
	{
		$carsByParam=array();
		$arrParams=json_encode($arrParams);
		$cars=$this
			->client
			->getCarsByParams($arrParams);
		$objcars=json_decode($cars);

		foreach($objcars as $car)
		{
			$car=(array)$car;
			$curCar=array(
						'BRAND' =>$car['brand'],
						'ID' => $car['id'],
						'MODEL' => $car['model'],
						'YEAR' => $car['year'],
						'COLOR' => $car['color'],
						'MAX_SPEED' => $car['max_speed'],
						'PRICE' => $car['price']);

		array_push($carsByParam,$curCar);
		}
		return $carsByParam;
	}

	public function getAllCars()
	{
		$allcars=array();
		$cars=$this->client->getAllCars();
		$objcars=json_decode($cars);

		foreach($objcars as $car)
		{
			$car=(array)$car;

			$curCar=array(
						'BRAND' =>$car['brand'],
						'ID' => $car['id'],
						'MODEL' => $car['model'],
						'YEAR' => $car['year'],
						'COLOR' => $car['color'],
						'MAX_SPEED' => $car['max_speed'],
						'PRICE' => $car['price']);

		array_push($allcars,$curCar);
		}
	return $allcars;
}

	public function getOrderCar($arrParams)
	{
		$arrParams=json_encode($arrParams);

		$count=$this
			->client
			->getOrderCar($arrParams);

		$count=json_decode($count);
		return $count;
	}


}
