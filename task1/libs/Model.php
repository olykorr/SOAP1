<?php

include_once 'libs/CountrySOAP.php';
include_once 'libs/CountryCURL.php';
class Model
{
    private $model;
    public function __construct()
    {
        $this->model = array('TITLE'=>TASK_NAME, 'ERRORS'=>'');
        $CountrySOAP = new CountrySOAP();

        $this->model['COUNTRYURL'] = COUNTRYINFO_URL;
		    $this->model['CONTINENTS'] = $CountrySOAP->getContinents();
        $this->model['COUNTRIES'] = $CountrySOAP->getCountries();
		    $this->model['COUNTRYFULL'] = array($CountrySOAP->getALLCountryInfo('UA'));
		    $countryCURL = new CountryCURL();
   
        $this->model['CONTINENTSCURL'] = $countryCURL->getContinents();
        $this->model['COUNTRIESCURL'] = $countryCURL->getCountries();
        $this->model['COUNTRYFULLCURL'] = $countryCURL->getCountryFullInfo('UA');
        $parts=explode(" ",$this->model['COUNTRYFULLCURL']);
        $this->model['SISOCODE']=$parts[4];
        $this->model['SNAME']=$parts[6];
        $this->model['SCAPITALCITY']=$parts[8];
        $this->model['SCURRENCYISOCODE']=$parts[14];
        $this->model['SCOUNTRYFLAG']=strip_tags ($parts[16]);
    }
		
    public function getArray()
    {
      return $this->model;
    }

}
