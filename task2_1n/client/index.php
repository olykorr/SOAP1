<?php

include_once ('libs/SoapClientMaker.php');

$sclient = new SoapClientMaker();
$Cars = $sclient->getAllCars();

if (isset($_POST['FindCar']))
{
	if (!empty($_POST['year'])||!empty($_POST['brand'])||!empty($_POST['model'])||!empty($_POST['engine'])||!empty($_POST['color'])||!empty($_POST['max_speed'])||!empty($_POST['price']))
	{
		$Cars = $sclient->getCarsByParams($_POST);
		require 'template/index.php';
	}
	else
	{
		$Cars = $sclient->getAllCars();
		require 'template/index.php';

	}
}
elseif (isset($_POST['Bye']))
{
	$chosenID=$_POST['Bye'];
	$Cars = $sclient->getCarById((int)$_POST['Bye']);
	foreach($Cars as $car)
	{
		$AllInfo=$car['COLOR'].' '.$car['BRAND'].' '.$car['MODEL'].' ('.$car['YEAR'].') ';
	}
	require 'template/Order.php';
}

elseif (isset($_POST['SendOrder']))
{
	if (!empty($_POST['id_car']) && !empty($_POST['f_name']) && !empty($_POST['l_name']) && !empty($_POST['payment'])&&isset($_POST['payment']))
	{
		$subject = $_POST['subject'];
		$Cars = $sclient->getOrderCar($_POST);
		if ($Cars)
		{
			require 'template/OrderSend.php';
		}
		
		
	}
	else
	{
		$chosenID=$_POST['id_car'];
		$AllInfo=$_POST['carName'];
		$Errors="Wrong data please check!";
		require 'template/Order.php';
	}

}
else
{
	require 'template/index.php';
}
