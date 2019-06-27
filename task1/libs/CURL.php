<?php
class CURL
{
  private $serviceUrl;
  private $functions;
  
  function __construct($WsdlUrl)
  {
    $this->connect($WsdlUrl);
  }
    
  protected function connect($WsdlUrl)
  {
      $this->serviceUrl = $WsdlUrl;
	}
  
  protected function CurlNoParam($name)
  {
	$url=$this->serviceUrl.'/'.$name;
    $ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$rez = curl_exec($ch); 
    $info = curl_getinfo($ch);      
    curl_close($ch);  
    return $rez;    
  }
  
  protected function CurlWithParam($name,$data)
  {
	$url=$this->serviceUrl.'/'.$name;
    $ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	
	$rez = curl_exec($ch); 
	$info = curl_getinfo($ch);      
    curl_close($ch);  
    return $rez;   
  }
  
}