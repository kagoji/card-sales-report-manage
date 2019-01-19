
@if(isset($action)&&($action=='add'))
<form role="form" class="form-horizontal" action="{{ url('/report-history/view') }}"
      id="" method="post" role="form" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">

            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="action" value="add">
            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Report Title</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="history_title">
                </div>
            </div>

            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Report Year</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <input type="number" class="form-control" name="history_year" min="2017" step="1">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-5 control-label">
                    <strong>Report Month</strong>
                    <span class="symbol required" aria-required="true"></span>
                </label>
                <div class="col-sm-5">
                    <select class="form-control" name="history_month">
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
    <form role="form" class="form-horizontal" action="{{ url('/report-history/view') }}"
          id="" method="post" role="form" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">

                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="action" value="edit">

                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Report Title</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="history_title" value="{{isset($history_info->history_title)?$history_info->history_title:''}}">
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Report Year</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <input type="number" class="form-control" name="history_year" min="2017" step="1" value="{{isset($history_info->history_year)?$history_info->history_year:''}}">
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label class="col-sm-5 control-label">
                        <strong>Report Month</strong>
                        <span class="symbol required" aria-required="true"></span>
                    </label>
                    <div class="col-sm-5">
                        <select class="form-control" name="history_month">
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


