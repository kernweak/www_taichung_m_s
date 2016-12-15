<div id="piechart" style="width: 900px; height: calc(85vh - 10em);margin:auto; "></div>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['西屯區',     11],
          ['南屯區',      2],
          ['北屯區',  2],
          ['豐原區', 2],
          ['霧峰區',    7]
        ]);

        var options = {
          pieSliceText: 'label',
          legend: { position: 'labeled' }
          title: '各區案件申請數量'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
</script>
