<?php

class SOAP

{
  private $client;
  
  function __construct($WsdlUrl)
  {
      $this->connect($WsdlUrl);
  }
    
  protected function connect($WsdlUrl)
  {
      $this->client = new SoapClient($WsdlUrl.'?WSDL');
  }
  
  public function getAllFunc()
  {
    return $this->client->__getFunctions();
  }
  
  protected function get($name,$params=NULL) 
  {
    if($params)
    {
      return $this->client->$name($params);
    }
    return $this->client->$name();
  }
  
}