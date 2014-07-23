<?php namespace Api\Validators;

use Illuminate\Validation\Validator;

Class PostcodeValidator extends Validator {

	public function validatePostcode($attribute, $value, $parameters)
    {
        $regex = "/^((GIR 0AA)|((([A-PR-UWYZ][0-9][0-9]?)|(([A-PR-UWYZ][A-HK-Y][0-9][0-9]?)|(([A-PR-UWYZ][0-9][A-HJKSTUW])|([A-PR-UWYZ][A-HK-Y][0-9][ABEHMNPRVWXY])))) [0-9][ABD-HJLNP-UW-Z]{2}))$/i";
       
        if(preg_match($regex ,$value)) 
        {
            return true;
        }
        return false;
    }

}