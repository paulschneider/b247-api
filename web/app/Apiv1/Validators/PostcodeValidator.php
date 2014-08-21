<?php namespace Apiv1\Validators;

use Illuminate\Validation\Validator;

Class PostcodeValidator extends Validator {

	public function validatePostcode($attribute, $value, $parameters)
    {
        $regex = "^([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([AZa-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9]?[A-Za-z])))) [0-9][A-Za-z]{2})$^";
      
        if(preg_match($regex ,$value)) 
        {
            return true;
        }
        return false;
    }

}