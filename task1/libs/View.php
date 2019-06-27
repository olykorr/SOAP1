<?php
class View
{
	private $forRender;
	private $file;
	public function __construct($template)
	{       
		$this->file = file_get_contents($template);
		if (false === $this->file)
		{
			throw new NullPointerException(TEMPLATE_OPEN_ERROR);
		}
	}
	public function addToReplace($mArray)
	{
	  foreach($mArray as $key=>$val)
	   {
			$this->forRender[$key] = $val;
	   }
	}
	public function templateRender()
	{
		$this->replaceLoop($this->file);
		$this->file = $this->replace($this->forRender, $this->file);
														
		echo $this->file;
	}
	
	public function replaceLoop($text)
	{
		$exp = '/([\{\{].*[\}\}])/';
		$resultArr = preg_split($exp, $text, -1, PREG_SPLIT_OFFSET_CAPTURE | PREG_SPLIT_DELIM_CAPTURE);
		$this->file = '';
		foreach ($resultArr as $res)
		{
			if (preg_match('/^\{\{([A-Z]+)\|(.*)\}\}$/', $res[0], $matches))
			{
				if (0 < count($this->forRender[$matches[1]]))
				{
					$resultLoop='';
					foreach ($this->forRender[$matches[1]] as $item)
					{
            if(is_object($item))
            {
              $item = (array)$item;
            }
						$resultLoop.=$this->replace(array_change_key_case($item,CASE_UPPER), $matches[2]);				
					}
					$res[0]=$resultLoop;
				}
				else
				{
					$res[0]='';
				}
			}
			
			$this->file.=$res[0]."\n";
		}
	}
	public function replace($arr, $str)
	{	
		$result='';
		$exp = '/(\%[A-Z]+\%)/';
		$resultArr = preg_split($exp, $str, -1, PREG_SPLIT_OFFSET_CAPTURE | PREG_SPLIT_DELIM_CAPTURE);
		foreach ($resultArr as $res)
		{
			if (preg_match('/^\%([A-Z]+)\%$/', $res[0], $matches))
			{
				if (array_key_exists($matches[1], $arr))
				{
					$res[0]=$arr[$matches[1]];
				}
				else
				{
					$res[0]='';
				}
				
			}
			$result.=$res[0];
		}
		return $result;
	}
}
?>