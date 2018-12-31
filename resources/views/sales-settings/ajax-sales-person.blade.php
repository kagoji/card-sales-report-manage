
@if(isset($action)&&($action=='add'))
<form role="form" class="form-horizontal" action="{{ url('/sales/settings-person-sales') }}"
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
                    <input type="text" class="form-control" name="salesExecutiveCode">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Executive Name</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="salesExecutiveName">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Designation Code</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <select class="form-control" name="salesDesigCode">
                        @if(isset($config_list)&& count($config_list)>0)
                            @foreach($config_list as $key => $config)
                                <option value="{{$config->designationCode}}">{{$config->designationTitle}}</option>
                            @endforeach
                        @else
                            <option value="">Please add config</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Date of Joining</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <input type="date" class="form-control" name="dateOfJoining">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Account No.</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="sales_persons_account_no">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Mobile No.</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="sales_persons_mobile_no">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Zone Name</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <select class="form-control" name="sales_persons_zone_id">
                        @if(isset($zone_list)&& count($zone_list)>0)
                            @foreach($zone_list as $key => $zone)
                                <option value="{{$zone->id}}">{{$zone->zone_name}}</option>
                            @endforeach
                        @else
                            <option value="">Please add zone</option>
                        @endif
                    </select>
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
    <form role="form" class="form-horizontal" action="{{ url('/sales/settings-person-sales') }}"
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
                        <input type="text" class="form-control" name="salesExecutiveCode" value="{{isset($person_info->salesExecutiveCode)?$person_info->salesExecutiveCode:''}}">
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Executive Name</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="salesExecutiveName" value="{{isset($person_info->salesExecutiveName)?$person_info->salesExecutiveName:''}}">
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Designation Code</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <select class="form-control" name="salesDesigCode">
                            @if(isset($config_list)&& count($config_list)>0)
                                @foreach($config_list as $key => $config)
                                    <option value="{{$config->designationCode}}" {{isset($person_info->salesDesigCode) && ($person_info->salesDesigCode==$config->designationCode)?'selected':''}}>{{$config->designationTitle}}</option>
                                @endforeach
                            @else
                            <option value="">Please add config</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Date of Joining</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control" name="dateOfJoining" value="{{isset($person_info->dateOfJoining)?$person_info->dateOfJoining:''}}">
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Account No.</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="sales_persons_account_no" value="{{isset($person_info->sales_persons_account_no)?$person_info->sales_persons_account_no:''}}">
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Mobile No.</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="sales_persons_mobile_no" value="{{isset($person_info->sales_persons_mobile_no)?$person_info->sales_persons_mobile_no:''}}">
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Zone Name</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <select class="form-control" name="sales_persons_zone_id">
                            @if(isset($zone_list)&& count($zone_list)>0)
                                @foreach($zone_list as $key => $zone)
                                    <option value="{{$zone->id}}" {{isset($person_info->sales_persons_zone_id) && ($person_info->sales_persons_zone_id==$zone->id)?'selected':''}}>{{$zone->zone_name}}</option>
                                @endforeach
                            @else
                                <option value="">Please add zone</option>
                            @endif
                        </select>
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


