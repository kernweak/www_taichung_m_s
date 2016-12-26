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
  <br><br><br>

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
    
    hideChart();
    hideMap();
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
    .done(function(response) {
      console.log("success");      
      
      var origData = response;
      var chartData = [];
      var sttsType = $("#statistics_type select").val();

      //prepare chart data
      switch (sttsType){
        case "各區案件申請數量":
          chartData.push(["區域", "件數", { role: 'annotation' }]);
          for(i=0; i<origData.length; i++){
            var row = [origData[i].Town_name, parseInt(origData[i].amount), origData[i].amount];
            chartData.push(row);            
          }
          break;
        case "各區核定案件數量":
        case "各區核定案件扶助級別人數":
          chartData.push(['區域','甲級','乙級',"丙級"]);
          for(i=0; i<origData.length; i++){
            var row = [origData[i].區別, parseInt(origData[i].甲級), parseInt(origData[i].乙級), parseInt(origData[i].丙級)];
            chartData.push(row);
          }
          break;        
        case "全市核定案件扶助級別人數":
          chartData.push(["扶助級別", "人數"]);
          for(i=0; i<origData.length; i++){
            var row = [origData[i].GroupName, parseInt(origData[i].PostCount)];
            chartData.push(row);
          }
          break;
      }          

      //draw chart
      switch (sttsType){
        case "各區案件申請數量":
        case "各區核定案件數量":
        case "各區核定案件扶助級別人數":
          setTimeout(function(){ PieColumnChart(chartData,sttsType,"Column"); }, 1000);
          setTimeout(showChart, 1000);
          $("#statistics").css({
            overflowY: 'scroll',
            paddingRight: '0.3em'
          });
          break;
        case "全市核定案件扶助級別人數":
          setTimeout(function(){ PieColumnChart(chartData,sttsType,"Pie"); }, 1000);
          setTimeout(showChart, 1000);
          $("#statistics").css({
            overflowY: 'hidden',
            paddingRight: '1.6em'
          });
          break;
      }      

      //prepare map data and draw map
      var mapInfoData;
      switch (sttsType){
        case "各區案件申請數量":
          mapInfoData = convertData1(origData);
          setTimeout(function(){drawMap(mapInfoData)}, 1000);
          setTimeout(showMap, 1000);
          break;
        case "各區核定案件數量":
          mapInfoData = convertData2(origData);
          setTimeout(function(){drawMap(mapInfoData)}, 1000);
          setTimeout(showMap, 1000);
          break;
        case "各區核定案件扶助級別人數":
          mapInfoData = convertData3(origData);
          setTimeout(function(){drawMap(mapInfoData)}, 1000);
          setTimeout(showMap, 1000);
          break;
        case "全市核定案件扶助級別人數":
        default:          
          // hideMap();
      }      
      
    })
    .fail(function() {
      console.log("error");      
    })
    .always(function() {
      console.log("complete");
    });    
  });

  function convertData1(data){
    var mapData = [];
    for(i=0; i<data.length; i++){
      var info = {
          content: data[i].Town_name + ' '+ data[i].amount+'件',
          position: {
             lat: parseFloat(data[i].lat),
             lng: parseFloat(data[i].lng)
           }
      }
      mapData.push(info);
    }
    
    return mapData;
  }

  function convertData2(data){
    var mapData = [];
    for(i=0; i<data.length; i++){
      var total = parseInt(data[i].甲級) + parseInt(data[i].乙級) + parseInt(data[i].丙級);
      var info = {
          content: data[i].區別 + ' ' + total +'件',
          position: {
             lat: parseFloat(data[i].lat),
             lng: parseFloat(data[i].lng)
           }
      }
      mapData.push(info);
    }    
    return mapData;
  }

  function convertData3(data){
    var mapData = [];
    for(i=0; i<data.length; i++){
      var total = parseInt(data[i].甲級) + parseInt(data[i].乙級) + parseInt(data[i].丙級);
      var info = {
          content: data[i].區別 + ' ' + total +'人',
          position: {
             lat: parseFloat(data[i].lat),
             lng: parseFloat(data[i].lng)
           }
      }
      mapData.push(info);
    }    
    return mapData;
  }


  function drawMap(data){
    var xintun ={lat: 24.1779, lng: 120.633328};
    var map = new google.maps.Map(document.getElementById('map'), {
      center: xintun,
      zoom: 12
    });    

    for(i=0; i<data.length;i++){
      var infowindow = new google.maps.InfoWindow(data[i]);
      infowindow.open(map);
    }        
    // showMap();
  }

  function hideMap(){
    $("#map").removeClass('in');
    // $("#map").hide();
  }
  function showMap(){
    $("#map").addClass('in');    
    // $("#map").show();
    // google.maps.event.trigger(map, 'resize');
  }

  function hideChart(){
    $("#piechart").removeClass('in');
  }

  function showChart(){
    $("#piechart").addClass('in');
  }

</script>

    <script async defer
       src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAf3yYFNmlOV2vZnox1g0SkBMXajb6rL1o">
    </script>
<style type="text/css">
  #piechart > div, #map{
    box-shadow: 2px 2px 10px 1px;
  }
</style>
<row>
  <div style="height:calc(85vh - 10em);" id="draw_area">
    <div id="piechart" class='col-lg-8 col-lg-offset-2 fade' style="height: calc(85vh - 10em);transition: 1s;/*margin:auto;*/"></div>

      <!--<div class="box">
          <canvas id="chart-area" class="zone"></canvas>
      </div>-->
  </div>
</row>
<row>
  <br/><br/><br/>
  <div style="height:calc(85vh - 10em);padding-left:1.38em;padding-right:1.38em;" id="map_area">
    <div id="map" class='col-lg-8 col-lg-offset-2 fade' style="height: 100%; transition: 1s;"></div>

      <!--<div class="box">
          <canvas id="chart-area" class="zone"></canvas>
      </div>-->
  </div>
</row>
