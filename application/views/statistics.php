<div style="height:calc(10vh);">
  <div class="container-fluid">
      <div class="row">
          <div class='col-lg-3'>
              <div class="form-group"><span style="color:white;">起始日期：</span>
                  <div class='input-group date' id='datetimepicker1'>
                      <input type='text' class="form-control" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
              </div>
          </div>
          <div class='col-lg-3'>
              <div class="form-group"><span style="color:white;">結尾日期：</span>
                  <div class='input-group date' id='datetimepicker2'>
                      <input type='text' class="form-control" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
              </div>
          </div>
          <div class='col-lg-3'>
              <div class="form-group"><span style="color:white;">統計分析：</span>
                  <div class='input-group date' id='statistics_type' style="width:100%;">
                      <select class="form-control" style="border-radius: 0.25em;">
                        <option value=""><<請選擇統計類型>></option>
                        <option value="各區案件申請數量">各區案件申請數量</option>
                        <option value="各區人均案件申請數量">各區人均案件申請數量(/萬人)</option>
                        <option value="各區人均案件通過數量">各區人均案件通過數量</option>
                        <option value="各區平均初審耗費時間">各區平均初審耗費時間</option>
                        <option value="各區人口密度與案件申請數量比值">各區人口密度與案件申請數量比值</option>
                        <option value="各區人口密度與案件通過數量比值">各區人口密度與案件通過數量比值</option>
                      </select>
                  </div>
              </div>
          </div>
          <div class='col-lg-3'>
              <div class="form-group"><span style="color:white;">圖表類型：</span>
                  <div class='input-group date' id='statistics_type' style="width:100%;">
                      <select class="form-control" style="border-radius: 0.25em;">
                        <option>長條圖</option>
                        <option>圓餅圖</option>
                      </select>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart', 'bar']});
      //google.charts.setOnLoadCallback(drawChart);
      function drawChart(chart_data, chart1_main_title) {

        // var data = google.visualization.arrayToDataTable([
        //   ['Task', 'Hours per Day'],
        //   ['西屯區',     11],
        //   ['南屯區',      2],
        //   ['北屯區',  2],
        //   ['豐原區', 2],
        //   ['霧峰區',    7]
        // ]);

        // var options = {
        //   pieSliceText: 'label',
        //   title: '各區案件申請數量'
        // };

        // chart1_main_title = '各區案件申請數量';
        // chart_data = 
        // [
        //   ['Task', 'Hours per Day'],
        //   ['西屯區',     11],
        //   ['南屯區',      2],
        //   ['北屯區',  2],
        //   ['豐原區', 2],
        //   ['霧峰區',    7]
        // ];
        chart_data[0][2] = { role: 'annotation' };


        var data = google.visualization.arrayToDataTable(chart_data);
        var options = {
           pieSliceText: 'label',
           animation: {"startup": true},
           title: chart1_main_title,
           colors: ['red', 'green','blue']
         };










        var chart = new google.visualization.ColumnChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
</script>
<script type="text/javascript">
  $("#piechart").fadeOut('fast');
  $("#statistics_type").on('change', function(event) {
    event.preventDefault();
    

    $.ajax({
      url: '/chart/pie',
      type: 'POST',
      dataType: 'json',
      data: {statistics_type: $("#statistics_type select").val()},
    })
    .done(function(responsive) {
      console.log("success");
      $("#piechart").removeClass('in');
      setTimeout(function(){ drawChart(responsive,$("#statistics_type select").val()); }, 1000);
      
      setTimeout(function(){ $("#piechart").addClass('in'); }, 1000);
      

      
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
    







  });
</script>
<style type="text/css">
  #piechart > div{
    box-shadow: 2px 2px 10px 1px;
  }
</style>
<row>
  <div style="height:calc(75vh - 10em);" id="draw_area">
    <div id="piechart" class='col-lg-12 fade' style="height: calc(85vh - 10em);transition: 1s;/*margin:auto;*/"></div>

      <!--<div class="box">
          <canvas id="chart-area" class="zone"></canvas>
      </div>-->
  </div>
</row>
<div style="height:calc(70vh);">

</div>
