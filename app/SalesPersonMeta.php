<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class SalesPersonMeta extends Model
{
    protected $table = 'sales_person_meta';
    protected $fillable = [
        'metaExecutiveCode',
        'field_name',           //key: observation_status_2018_12,observation_description_2018_12
        'field_value'           //value: yes/no,Personal Leave
    ];

    /********************************************
    ## PersonMetaValue
     *********************************************/
    public static function PersonMetaValue($executiveCode,$field_name)
    {
        $meta_value = null;

        $cardlist = \App\SalesPersonMeta::where('metaExecutiveCode',$executiveCode)->where('field_name',$field_name)->first();

        if(isset($cardlist->id) && !empty($cardlist->field_value)){
            $meta_value = $cardlist->field_value;
        }
        return $meta_value;
    }

    /********************************************
    ## RemainingDay
     *********************************************/
    public static function RemainingDay($start,$end)
    {
        $date1 = new DateTime($start);  //current date or any date
        $date2 = new DateTime($end);   //Future date
        $diff = $date2->diff($date1)->format("%a");  //find difference
        $days = intval($diff);   //rounding days
        return $days;
    }



    /********************************************
    ## GetObservationStatus
     *********************************************/
    public static function GetObservationStatus($executiveCode,$history_year,$history_month)
    {

        #top_count
        $observation_yearly_count = \App\SettingsMeta::CardMetaValue('observation_yearly_count');
        $observation_yearly_count = !empty($observation_yearly_count)?$observation_yearly_count:2;

        $filed_name = "observation_status_$history_year%";
        $observation_count = \App\SalesPersonMeta::where('metaExecutiveCode',$executiveCode)->where('field_name','Like',$filed_name)->count();

        $data['observation_executiveCode']=$executiveCode;
        $data['observation_count']=$observation_count;
        $data['observation_status']=0;
        $data['observation_desc']='';

        if(($observation_count-1)<$observation_yearly_count){
            $status_name = "observation_status_$history_year"."_"."$history_month";
            $status_value = \App\SalesPersonMeta::PersonMetaValue($executiveCode,$status_name);

            if(!empty($status_value)){

                $status_desc = "observation_description_$history_year"."_"."$history_month";
                $status_desc_value = \App\SalesPersonMeta::PersonMetaValue($executiveCode,$status_desc);
                $data['observation_status']=1;
                $data['observation_desc']=$status_desc_value;
            }


        }

        $event_message = "ExecutiveCode $executiveCode | History : $history_year| Month: $history_month | Observation :".json_encode($data);
        \App\System::CustomLogWritter("SalesPersonCardReport","sales_person_observation_log",$event_message);

        return $data;
    }
}



