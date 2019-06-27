<?php
include_once 'CURL.php';

class CountryCURL extends CURL 
{
  function __construct()
  {
      $this->connect(COUNTRYINFO_URL);
  }
  
  public function getContinents()
  {
    $result = array();
    $response =  $this->CurlNoParam('ListOfContinentsByName');
	
    libxml_use_internal_errors(true); //hide errors
	$xmlstr=new DomDocument();
	$xmlstr->loadHTML($response);
    $continent = $xmlstr->getElementsByTagName('arrayoftcontinent')->item(0)->getElementsByTagName('tcontinent');
    for($i=0;$i<$continent->length;$i++)
    {
      $item = $continent->item($i);
      $code = $item->firstChild;
      $name = $item->lastChild;
      array_push($result, array('sName'=>$name->nodeValue, 'sCode'=>$code->nodeValue));
    }
    
    return $result;
  }
  
  public function getCountries()
  {
    $result = array();
    $response =  $this->CurlNoParam('ListOfCountryNamesByName');
	
    libxml_use_internal_errors(true);
	$xmlstr=new DomDocument();
	$xmlstr->loadHTML($response);
    $continent = $xmlstr->getElementsByTagName('arrayoftcountrycodeandname')->item(0)->getElementsByTagName('tcountrycodeandname');
    for($i=0;$i<$continent->length;$i++)
    {
      $item = $continent->item($i);
      $code = $item->firstChild;
      $name = $item->lastChild;
      array_push($result, array('sName'=>$name->nodeValue, 'sISOCode'=>$code->nodeValue));
    }
    
    return $result;
  }
  
  public function getCountryFullInfo($isoCode)
  {
    return $this->CurlWithParam('FullCountryInfo',array('sCountryISOCode'=>$isoCode));
  }
}