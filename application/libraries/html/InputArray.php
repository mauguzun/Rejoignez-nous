<?php


class InputArray
{



    protected $class = "form-control";
	/**
	* 
	* @param string $name
	* @param input type default='text'$type
	* @param string $placeholder
	* @param string $value
	* @param string $required
	* 
	* @return
	*/
    public function getArray($name,$type = 'text',$placeholder = NULL ,$value = NULL  , $required = FALSE ,$moreAttr = FALSE)
    {

        $result = [
            'class'=>$this->class,
            'name' => $name,
            'type' => $type,
            'id'=>$name
            ] ;
		
		if ($placeholder)
        $result['placeholder'] = $placeholder;
        
       
        if ($value && $value!='')
        $result['value'] = trim($value);

        if ($required)
        $result['required'] = 'required';
        
        if(is_array($moreAttr)){
			foreach($moreAttr as $k=>$v){
				$result[$k]=$v;
			}
		}


        return $result;

    }
}
?>