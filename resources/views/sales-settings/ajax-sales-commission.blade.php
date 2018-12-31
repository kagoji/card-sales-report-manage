
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
                    <strong>Commission Name</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <select class="form-control" name="cmm_prd_grp_type_name">
                        <option value="Basic Card"  >Basic Card</option>
                        <option value="Supplementary Card" Supplementary Card</option>
                        <option value="Travel Card" >Travel Card</option>
                        <option value="Virtual Card" >Virtual Card</option>
                    </select>
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
                        <strong>Commission Name</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <select class="form-control" name="cmm_prd_grp_type_name">
                            <option value="Basic Card" {{isset($commission_info->cmm_prd_grp_type_name) && ($commission_info->cmm_prd_grp_type_name=='Basic Card')?'selected':''}} >Basic Card</option>
                            <option value="Supplementary Card" {{isset($commission_info->cmm_prd_grp_type_name) && ($commission_info->cmm_prd_grp_type_name=='Supplementary Card')?'selected':''}}>Supplementary Card</option>
                            <option value="Travel Card" {{isset($commission_info->cmm_prd_grp_type_name) && ($commission_info->cmm_prd_grp_type_name=='Travel Card')?'selected':''}}>Travel Card</option>
                            <option value="Virtual Card" {{isset($commission_info->cmm_prd_grp_type_name) && ($commission_info->cmm_prd_grp_type_name=='Virtual Card')?'selected':''}}>Virtual Card</option>
                        </select>
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


