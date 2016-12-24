<div style="height:calc(10vh);">
  <div class="container-fluid">
      <div class="row">
          <div class='col-lg-4 col-md-4 col-sm-4'>
              <div class="form-group"><span style="color:white;">起始日期：</span>
                  <div class='input-group date' id='datetimepicker1'>
                      <input type='text' class="form-control" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
              </div>
          </div>
          <div class='col-lg-4 col-md-4 col-sm-4'>
              <div class="form-group"><span style="color:white;">結尾日期：</span>
                  <div class='input-group date' id='datetimepicker2'>
                      <input type='text' class="form-control" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
              </div>
          </div>
          <div class='col-lg-4 col-md-4 col-sm-4'>
              <div class="form-group"><span style="color:white;">統計分析：</span>
                  <div class='input-group date' id='statistics_type' style="width:100%;">
                      <select class="form-control" style="border-radius: 0.25em;">
                        <option value=""><<請選擇統計類型>></option>
                        <option value="各區案件申請數量">各區案件申請數量</option>
                        <option value="各區核定案件數量">各區核定案件數量</option>
                        <option value="各區核定案件扶助級別人數">各區核定案件扶助級別人數</option>
                        <option value="全市核定案件扶助級別人數">全市核定案件扶助級別人數</option>
                      </select>
                  </div>
              </div>
          </div>
          <!--<div class='col-lg-3'>
              <div class="form-group"><span style="color:white;">圖表類型：</span>
                  <div class='input-group date' id='statistics_type' style="width:100%;">
                      <select class="form-control" style="border-radius: 0.25em;">
                        <option>長條圖</option>
                        <option>圓餅圖</option>
                      </select>
                  </div>
              </div>
          </div>-->
      </div>
  </div>
</div>
<script type="text/javascript">
      function Date_today(year = 0){    //傳回今天日期 2016-05-13 變數調整年
        var today = new Date();
        // today += (1000 * 60 * 60 * 24) * offsetDay;
        // today = new Date(today);
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        yyyy = (parseInt(yyyy) + year);
        console.log(today);
        if(dd<10) {
            dd='0'+dd
        } 

        if(mm<10) {
            mm='0'+mm
        } 

        today = yyyy+'-'+mm+'-'+dd;
        console.log(today);
        return today;
      }

      google.charts.load('current', {'packages':['corechart', 'bar']});
      function PieColumnChart(chart_data, chart1_main_title, type = "Column") {
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
        //chart_data[0][2] = { role: 'annotation' };
        var data = google.visualization.arrayToDataTable(chart_data);
        
        if(type == "Column"){
          var options = {
           pieSliceText: 'label',
           animation:{
            duration: 5000,
            easing: 'out',
           },
           title: chart1_main_title,
           isStacked: true,
           colors: ['red', 'green','blue','CornflowerBlue','DarkCyan','DarkOrange','DarkOrchid','DarkSlateGray','DodgerBlue','GoldenRod','MediumPurple']
         };
          var chart = new google.visualization.ColumnChart(document.getElementById('piechart'));
        }
        if(type == "Pie"){
          var options = {
           title: chart1_main_title,
           colors: ['red', 'green','blue','CornflowerBlue','DarkCyan','DarkOrange','DarkOrchid','DarkSlateGray','DodgerBlue','GoldenRod','MediumPurple']
         };
          var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        }
        
        chart.draw(data, options);
      }
</script>
<script type="text/javascript">
  $("#piechart").fadeOut('fast');
  $("#statistics_type").on('change', function(event) {
    event.preventDefault();
    if($("#datetimepicker1 input").val() == ""){
      $("#datetimepicker1 input").val(Date_today(-1));
    }
    if($("#datetimepicker2 input").val() == ""){
      $("#datetimepicker2 input").val(Date_today());
    }
    

    $.ajax({
      url: '/chart/pie',
      type: 'POST',
      dataType: 'json',
      data: {
        statistics_type: $("#statistics_type select").val(),
        Date_1: $("#datetimepicker1 input").val(),
        Date_2: $("#datetimepicker2 input").val()
      },
    })
    .done(function(responsive) {
      console.log("success");

      if($("#statistics_type select").val()=="各區案件申請數量"){
        responsive[0][2] = { role: 'annotation' };
      }

      if($("#statistics_type select").val()=="全市核定案件扶助級別人數"){
        $("#piechart").removeClass('in');
        setTimeout(function(){ PieColumnChart(responsive,$("#statistics_type select").val(),"Pie"); }, 1000);
        setTimeout(function(){ $("#piechart").addClass('in'); }, 1000);
      }else{
        $("#piechart").removeClass('in');
        setTimeout(function(){ PieColumnChart(responsive,$("#statistics_type select").val(),"Column"); }, 1000);
        setTimeout(function(){ $("#piechart").addClass('in'); }, 1000);
      }

      
      
      

      
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
