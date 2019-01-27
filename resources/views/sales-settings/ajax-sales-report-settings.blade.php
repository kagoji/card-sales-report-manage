
@if(isset($action)&&($action=='add'))
<form role="form" class="form-horizontal" action="{{ url('/sales/settings-sales-report') }}"
      id="" method="post" role="form" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">

            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="action" value="add">

            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Settings Name</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <select class="form-control" name="field_name">
                        <option value=''>--Select Option--</option>
                        <option value='joining_observation_days'>Joining Observation (days)</option>
                        <option value='card_bonus_increment'>Card Bonus Increment(Tk.)</option>
                        <option value='non_basic_card_grp'>Non Basic Card Grp</option>
                        <option value='observation_yearly_count'>Yearly Observation Limit</option>
                        <option value='cash_reward_amount'>Cash Reward Amount(1,2,3,..) Tk.</option>
                        <option value='card_topper_count'>Card Topper Count Limit</option>
                        <option value='reward_card_limit'>Minimum Card Reward Limit</option>
                        <option value='virtual_card_grp'>Virtual Card Group</option>
                        <option value='supply_card_grp'>Supplementary Card Group</option>
                        <option value='travel_card_grp'>Travel Card Group</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Settings Value</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="field_value">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <input class="btn btn-danger btn-squared" name="reset" value="Reset" type="reset">
                    <input class="btn btn-success btn-squared" name="submit" value="Save" type="submit">
                </div>
                <div class="col-sm-2">
                </div>
            </div>
        </div>
    </div>
</form>
@elseif(isset($action)&&($action=='edit'))
    <form role="form" class="form-horizontal" action="{{ url('/sales/settings-sales-report') }}"
          id="" method="post" role="form" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">

                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="action" value="edit">

                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Settings Name</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <select class="form-control" name="field_name">
                            <option value=''>--Select Option--</option>
                            <option {{isset($settings_info->field_name) && ($settings_info->field_name=='joining_observation_days')?'selected':''}} value='joining_observation_days'>Joining Observation (days)</option>
                            <option {{isset($settings_info->field_name) && ($settings_info->field_name=='card_bonus_increment')?'selected':''}} value='card_bonus_increment'>Card Bonus Increment(Tk.)</option>
                            <option {{isset($settings_info->field_name) && ($settings_info->field_name=='non_basic_card_grp')?'selected':''}} value='non_basic_card_grp'>Non Basic Card Grp</option>
                            <option {{isset($settings_info->field_name) && ($settings_info->field_name=='observation_yearly_count')?'selected':''}} value='observation_yearly_count'>Yearly Observation Limit</option>
                            <option {{isset($settings_info->field_name) && ($settings_info->field_name=='cash_reward_amount')?'selected':''}} value='cash_reward_amount'>Cash Reward Amount(1,2,3,..) Tk.</option>
                            <option {{isset($settings_info->field_name) && ($settings_info->field_name=='card_topper_count')?'selected':''}} value='card_topper_count'>Card Topper Count Limit</option>
                            <option {{isset($settings_info->field_name) && ($settings_info->field_name=='reward_card_limit')?'selected':''}} value='reward_card_limit'>Minimum Card Reward Limit</option>
                            <option {{isset($settings_info->field_name) && ($settings_info->field_name=='virtual_card_grp')?'selected':''}} value='virtual_card_grp'>Virtual Card Group</option>
                            <option {{isset($settings_info->field_name) && ($settings_info->field_name=='supply_card_grp')?'selected':''}} value='supply_card_grp'>Supplementary Card Group</option>
                            <option {{isset($settings_info->field_name) && ($settings_info->field_name=='travel_card_grp')?'selected':''}} value='travel_card_grp'>Travel Card Group</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Settings Value</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="field_value" value="{{isset($settings_info->field_value) ?$settings_info->field_value:''}}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-3">
                        <input class="btn btn-danger btn-squared" name="reset" value="Reset" type="reset">
                        <input class="btn btn-success btn-squared" name="submit" value="Update" type="submit">
                    </div>
                    <div class="col-sm-2">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endif


