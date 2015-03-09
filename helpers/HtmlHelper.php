<?php

namespace app\helpers;

use app\support\AppConstant;

/**
 * Created by PhpStorm.
 * User: Sandeep
 * Date: 3/2/2015
 * Time: 8:29 PM
 */
class HtmlHelper
{
    public static function GetDropDownListOptions($prompt,$cssClass=true,$dataAttribute=true)
    {
        $dropDownOptions = [
            'prompt'=> is_null($prompt)?'Select': $prompt
        ];

        if($cssClass!=false){
            $dropDownOptions['class'] = (is_bool($cssClass) ? 'dropdown' : $cssClass);
        }

        if($dataAttribute!=false){
            $dropDownOptions['data'] = ['settings' => '{"wrapperClass":"flat"}'];
        }

        return $dropDownOptions;
    }
//
//    public static function GetOptionsForMonths($selectedValue)
//    {
//        $result = "";
//        foreach (AppConstant::$monthNames as $name)
//        {
//            if (!is_null($selectedValue) and $selectedValue ==$name)
//            {
//                $result += '<option selected="selected">' . $name . "</option>\n";
//            }
//            else
//            {
//                $result += "<option>" . $name . "</option>\n";
//            }
//        }
//        return $result;
//    }
} 