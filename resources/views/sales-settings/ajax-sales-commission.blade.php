
@if(isset($action)&&($action=='add'))
<form role="form" class="form-horizontal" action="{{ url('/sales/settings-commission') }}"
      id="" method="post" role="form" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">

            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="action" value="add">
            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Product Group</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="cmm_prd_grp">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Commission Name</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="cmm_name">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Commission Amount</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="cmm_amount">
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
    <form role="form" class="form-horizontal" action="{{ url('/sales/settings-commission') }}"
          id="" method="post" role="form" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">

                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="action" value="edit">
                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Product Group</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" value="{{isset($commission_info->cmm_prd_grp)?$commission_info->cmm_prd_grp:''}}" name="cmm_prd_grp">
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Commission Name</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" value="{{isset($commission_info->cmm_name)?$commission_info->cmm_name:''}}" name="cmm_name">
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Commission Amount</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" value="{{isset($commission_info->cmm_amount)?$commission_info->cmm_amount:''}}" name="cmm_amount">
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


