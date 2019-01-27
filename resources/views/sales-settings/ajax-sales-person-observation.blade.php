
@if(isset($action)&&($action=='add'))
<form role="form" class="form-horizontal" action="{{ url('/sales/settings-person-sales-observation') }}"
      id="" method="post" role="form" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">

            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="action" value="add">
            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Executive Code</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="metaExecutiveCode">
                </div>
            </div>

            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Report Year</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <input type="number" class="form-control" name="meta_year" min="2017" step="1">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Report Month</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <select class="form-control" name="meta_month">
                        <option value=''>--Select Month--</option>
                        <option selected value='1'>Janaury</option>
                        <option value='2'>February</option>
                        <option value='3'>March</option>
                        <option value='4'>April</option>
                        <option value='5'>May</option>
                        <option value='6'>June</option>
                        <option value='7'>July</option>
                        <option value='8'>August</option>
                        <option value='9'>September</option>
                        <option value='10'>October</option>
                        <option value='11'>November</option>
                        <option value='12'>December</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Description</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="obs_description">
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
    <form role="form" class="form-horizontal" action="{{ url('/sales/settings-person-sales-observation') }}"
          id="" method="post" role="form" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">

                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="action" value="edit">

                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Executive Code</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="metaExecutiveCode" value="{{isset($observation_info->metaExecutiveCode)?$observation_info->metaExecutiveCode:''}}">
                    </div>
                </div>

                @php
                    if(isset($observation_info->field_name)&&!empty($observation_info->field_name)){
                        $observation_date = substr($observation_info->field_name,-7);
                        $date_map = $observation_date.'_01';
                        $date_map = explode('_',$date_map);
                        $date_map = implode($date_map,'-');
                        $meta_year = date('Y',strtotime($date_map));
                        $meta_month = date('m',strtotime($date_map));
                    }
                @endphp

                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Report Year</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <input type="number" class="form-control" name="meta_year" min="2017" step="1" value="{{isset($meta_year)?$meta_year:''}}">
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Report Month</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <select class="form-control" name="meta_month">
                            <option {{(isset($meta_month) && ((int)$meta_month == 1)) ? 'selected':''}} value='1'>Janaury</option>
                            <option {{(isset($meta_month) && ((int)$meta_month == 2)) ? 'selected':''}} value='2'>February</option>
                            <option {{(isset($meta_month) && ((int)$meta_month == 3)) ? 'selected':''}} value='3'>March</option>
                            <option {{(isset($meta_month) && ((int)$meta_month == 4)) ? 'selected':''}} value='4'>April</option>
                            <option {{(isset($meta_month) && ((int)$meta_month == 5)) ? 'selected':''}} value='5'>May</option>
                            <option {{(isset($meta_month) && ((int)$meta_month == 6)) ? 'selected':''}} value='6'>June</option>
                            <option {{(isset($meta_month) && ((int)$meta_month == 7)) ? 'selected':''}} value='7'>July</option>
                            <option {{(isset($meta_month) && ((int)$meta_month == 8)) ? 'selected':''}} value='8'>August</option>
                            <option {{(isset($meta_month) && ((int)$meta_month == 9)) ? 'selected':''}} value='9'>September</option>
                            <option {{(isset($meta_month) && ((int)$meta_month == 10)) ? 'selected':''}} value='10'>October</option>
                            <option {{(isset($meta_month) && ((int)$meta_month == 11)) ? 'selected':''}} value='11'>November</option>
                            <option {{(isset($meta_month) && ((int)$meta_month == 12)) ? 'selected':''}} value='12'>December</option>
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Description</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="obs_description">
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


