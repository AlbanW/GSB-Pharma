<?php 
namespace App\Service\Form;


class FormService 
{

    public static function getString(String $val) : string
    {
        return htmlspecialchars($_POST[$val]);
    }


    
    public static function isset($val) : bool
    {
       return (isset($_POST[$val]) AND !empty($_POST[$val]));
    }

}
