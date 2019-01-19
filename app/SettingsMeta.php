<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingsMeta extends Model
{
    protected $table = 'settings_meta';
    protected $fillable = [
        'field_name',           //key: non_basic_card_grp |
        'field_value',          //value:9999,2400,2500
    ];


    /********************************************
    ## NonBasicCardGrp
     *********************************************/
    public static function NonBasicCardGrp()
    {
        $card = array();

        $cardlist = \App\SettingsMeta::where('field_name','non_basic_card_grp')->first();

        if(isset($cardlist->id) && !empty($cardlist->field_value)){
            $card = explode(',',$cardlist->field_value);
        }
        return $card;
    }

    /********************************************
    ## CardMetaGrp
     *********************************************/
    public static function CardMetaGrp($field_name)
    {
        $card = array();

        $cardlist = \App\SettingsMeta::where('field_name',$field_name)->first();

        if(isset($cardlist->id) && !empty($cardlist->field_value)){
            $card = explode(',',$cardlist->field_value);
        }
        return $card;
    }

    /********************************************
    ## CardMetaValue
     *********************************************/
    public static function CardMetaValue($field_name)
    {
        $meta_value = null;

        $cardlist = \App\SettingsMeta::where('field_name',$field_name)->first();

        if(isset($cardlist->id) && !empty($cardlist->field_value)){
            $meta_value = $cardlist->field_value;
        }
        return $meta_value;
    }

}
