<div style="height:calc(10vh);">
<div class="container-fluid">
    <div class="row">
        <div class='col-lg-3'>
            <div class="form-group">起始日期：
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class='col-lg-3'>
            <div class="form-group">結尾日期：
                <div class='input-group date' id='datetimepicker2'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class='col-lg-3'>
            <div class="form-group">統計分析：
                <div class='input-group date' id='statistics_type' style="width:100%;">
                    <select class="form-control" style="border-radius: 0.25em;">
                      <option>各區案件申請數量</option>
                      <option>各區人均案件申請數量(/萬人)</option>
                      <option>各區人均案件通過數量</option>
                      <option>各區平均初審耗費時間</option>
                      <option>各區人口密度與案件申請數量比值</option>
                      <option>各區人口密度與案件通過數量比值</option>
                    </select>
                </div>
            </div>
        </div>
        <div class='col-lg-3'>
            <div class="form-group">行政區域：
                <div class='input-group date' id='statistics_type' style="width:100%;">
                    <select class="form-control" style="border-radius: 0.25em;">
                      <option>請勾選要列入之行政區域(可複選)</option>
                      <option>各區人均案件申請數量(/萬人)</option>
                      <option>各區人口與案件數量雙重顯示</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div style="height:calc(75vh - 10em);">
    <div class="box">
        <canvas id="chart-area" class="zone"></canvas>
    </div>
</div>
<div style="height:calc(15vh);">

</div>