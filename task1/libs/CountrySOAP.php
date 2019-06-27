<?php
include_once 'libs/SOAP.php';

class CountrySOAP extends SOAP 
{
  function __construct()
  {
      $this->connect(COUNTRYINFO_URL);
  }
  
  public function getContinents()
  {
    return $this->get('ListOfContinentsByName')->ListOfContinentsByNameResult->tContinent;
  }
  
  public function getCountries()
  {
    return $this->get('ListOfCountryNamesByName')->ListOfCountryNamesByNameResult->tCountryCodeAndName;
  }
  
  public function getALLCountryInfo($isoCode)
  {
    return $this->get('FullCountryInfo',array('sCountryISOCode'=>$isoCode))->FullCountryInfoResult;
  }


}