//區域,年度,最低生活費,不動產限額
var Property_limit =[
	["臺北市",105,21661,8760000],
	["新北市",105,19260,5250000],
	["桃園縣",105,20538,5400000],
	["臺中市",105,19626,5280000],
	["臺南市",105,17172,4800000],
	["高雄市",105,18728,5300000],
	["基隆市",105,17172,4800000],
	["新竹縣",105,17172,4800000],
	["苗栗縣",105,17172,4800000],
	["彰化縣",105,17172,4800000],
	["雲林縣",105,17172,4800000],
	["嘉義縣",105,17172,4800000],
	["屏東縣",105,17172,4800000],
	["宜蘭縣",105,17172,4800000],
	["花蓮縣",105,17172,4800000],
	["臺東縣",105,17172,4800000],
	["金門縣",105,15435,3750000],
	["連江縣",105,15435,3750000]
]

var Stock = [
[104, "鴻海2317", 5],
[103, "鴻海2317", 4.3],
[102, "鴻海2317", 3],
[102, "鴻海2317", 2.5],
[104, "台積電2330", 6],
[103, "台積電2330", 4.5],
[102, "台積電2330", 3],
[104, "大立光3008", 63.5],
[103, "大立光3008", 51],
[102, "大立光3008", 28.5],
]

//測試chart.js 圖表
var data = {
    labels: ["西屯區", "北屯區", "南屯區", "西區", "中區", "東區", "南區", "北區"],
    datasets: [
        {
            label: "105年 1月~12月 各區扶助案件申請數",
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(173, 82, 155, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(173, 82, 155, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1,
            data: [95, 89, 40, 61, 56, 55, 55, 40],
        }
    ]
};


$(document).ready(function() {
/*************************全網站初始化****************************************/
    recount_left_family_panel();

    //重繪所有SVG，變成內嵌，這樣才能著色
    svg_redraw();

    redraw_area_list_L1();  //各縣市列表icon改成用js跑
    //全畫面縮放倍率初始化
     $("body").css('zoom', $("#body-zoom").val());
     //啟用"案件編輯"下拉選單 (最終... 必須要開啟案件/新增案件 才能觸發 "案件編輯" )
     //$("#family-edit-nav").fadeIn(400);

/*************************全網站通用      TEST.php****************************************/
    //全畫面縮放倍率變化時
    $("#body-zoom").change(function(event) {    $("body").css('zoom', $("#body-zoom").val());    });

    //重新計算家屬編修左面板
    function recount_left_family_panel(){
        total_count_members();
        total_count_incomes();
        total_count_property();
    }


    

/*************************待辦案件      filelist.php****************************************/
    //彈出窗--點擊開啟檔案
    $("#myModal-table_id > tbody > tr:nth-child(1) > td:nth-child(2) > button").click(function(event) {
        $('#myModal').modal('hide');
        $("#bs-example-navbar-collapse-1 > ul:nth-child(1) > li:nth-child(2) > a").tab('show')
    });

    read_file_list_pending();
    //案件列表，轉換為可排序可分頁之dataTable

    setTimeout(function(){
        $('#table_id').dataTable({
            "lengthMenu": [100, 75, 50, 25, 10, 1],
            "language": {
                "paginate": {
                    "previous": "前頁",
                    "next": "後頁"
                },
                "lengthMenu": "每頁顯示 _MENU_ 筆",
                "info": "第 _PAGE_ / _PAGES_ 頁",
                "search": "粗搜索:"
            }
        });
    }, 1000); /*
    setTimeout(function(){
        $('#table_progress').dataTable({
            "lengthMenu": [100, 75, 50, 25, 10, 1],
            "language": {
                "paginate": {
                    "previous": "前頁",
                    "next": "後頁"
                },
                "lengthMenu": "每頁顯示 _MENU_ 筆",
                "info": "第 _PAGE_ / _PAGES_ 頁",
                "search": "粗搜索:"
            }
        });
    }, 1000);
    setTimeout(function(){
        $('#table_supporting').dataTable({
            "lengthMenu": [100, 75, 50, 25, 10, 1],
            "language": {
                "paginate": {
                    "previous": "前頁",
                    "next": "後頁"
                },
                "lengthMenu": "每頁顯示 _MENU_ 筆",
                "info": "第 _PAGE_ / _PAGES_ 頁",
                "search": "粗搜索:"
            }
        });
    }, 1000);*/

    
    
    //版本列表，轉換為可排序可分頁之dataTable
    $('#Stock_table').dataTable({
        "lengthMenu": [10, 25, 1],
        "language": {
            "paginate": {
                "previous": "前頁",
                "next": "後頁"
            },
            "lengthMenu": "每頁顯示 _MENU_ 筆",
            "info": "第 _PAGE_ / _PAGES_ 頁",
            "search": "粗搜索:",
            "infoFiltered": "(從 _MAX_ 筆資料中過濾出)"
        }
    });


    

/*************************家屬編修      people_basic.php****************************************/

    //左面板-點擊左側左側整體家戶資料，詳細/簡單切換
    $('.left-total-count').click(function(event) {      $(".detial").toggle('slow');    });
    //左面板-總人口數計算
    function total_count_members(){ 
        var members_area_array = [];
        var total_members_num = 0;  //總人數
        var list_members_num = 0;   //總列計人數
        var limit_income = 0    //最低生活費總和
        var GDIV = $(".center-total-count .group-div");
        total_members_num = $(GDIV).length-1;   //要扣掉 新增家屬 按鈕
        //console.log(total_members_num);
        for(i=0;i < total_members_num;i++){
            var Special = $(GDIV).eq(i).find(".people-special .people-input-left").val();
            if ($(GDIV).eq(i).find(".member_area").attr('area-index') == "" || $(GDIV).eq(i).find(".member_area").attr('area-index') == null){
                break;
            }
            var arr1= Special.split(',');
            if (arr1[0] == '0'){    //-------------------一般-----------------------------------------------------------------------------------------    

                list_members_num++;
                var area = $(GDIV).eq(i).find(".member_area").val();
                var area_income_limit_index = parseInt($(GDIV).eq(i).find(".member_area").attr('area-index'));
                limit_income += Property_limit[area_income_limit_index][2];
                
                var area_ex_flag = 0;
                for(j=0;j<members_area_array.length;j++){
                    if(members_area_array[j][0] == area){
                        members_area_array[j][1] +=1;
                        area_ex_flag = 1;
                    }
                }
                if (area_ex_flag ==0){
                    members_area_array.push([area,1]);
                }

            }else if(arr1[0] == '1'){   //-------------------不列口數--------------------------------
                //total_members_num++;

            }else if(arr1[0] == '2'){   //-------------------不計收入--------------------------------
                //total_members_num++;
                list_members_num++;
                var area = $(GDIV).eq(i).find(".member_area").val();
                var area_income_limit_index = parseInt($(GDIV).eq(i).find(".member_area").attr('area-index'));
                limit_income += Property_limit[area_income_limit_index][2];
                var area_ex_flag = 0;
                for(j=0;j<members_area_array.length;j++){
                    if(members_area_array[j][0] == area){
                        members_area_array[j][1] +=1;
                        area_ex_flag = 1;
                    }
                }
                if (area_ex_flag ==0){
                    members_area_array.push([area,1]);
                }
            }else if (arr1[0] == '3'){    //-------------------依實際所得-----------------------------------------------------------------------------------------    

                list_members_num++;
                var area = $(GDIV).eq(i).find(".member_area").val();
                var area_income_limit_index = parseInt($(GDIV).eq(i).find(".member_area").attr('area-index'));
                limit_income += Property_limit[area_income_limit_index][2];
                
                var area_ex_flag = 0;
                for(j=0;j<members_area_array.length;j++){
                    if(members_area_array[j][0] == area){
                        members_area_array[j][1] +=1;
                        area_ex_flag = 1;
                    }
                }
                if (area_ex_flag ==0){
                    members_area_array.push([area,1]);
                }

            }
        }
        //console.log(members_area_array);
        redraw_left_total_members(members_area_array,total_members_num,list_members_num,limit_income);
    }
    //左面板-總人口數更新
    function redraw_left_total_members(members_area_array,total_members_num,list_members_num,limit_income){
        //members_area_array
        $(".TC-L-D1").empty();
        var outs = "";
        for(i=0;i<members_area_array.length;i++){
            outs += '<div class="total-count-left-lc">' + members_area_array[i][0] + '</div><div class="total-count-left-rc">' + members_area_array[i][1] + '口</div>';
        }
        $(".TC-L-D1").append(outs);
        $(".TC-L-D1-allpeople").text(total_members_num);
        $(".TC-L-D1-listpeople").text(list_members_num);
        $(".TC-L-D1-lastincome").text(numberWithCommas(limit_income));
        $("#PH-need").text(limit_income);
    }
    //左面板-總收入計算
    function total_count_incomes(){ 
        var incomes_array = [];
        var total_members_num = 0;  //總人數
        var total_income = 0    //所得總和
        var GDIV = $(".center-total-count .group-div");
        total_members_num = $(GDIV).length-1;   //要扣掉 新增家屬 按鈕
        //console.log(total_members_num);
        for(i=0;i < total_members_num;i++){
            //console.log($(GDIV));
            var Special = $(GDIV).eq(i).find(".people-special .people-input-left").val();
            // if ($(GDIV).eq(i).find(".member_area").attr('area-index') == "" || $(GDIV).eq(i).find(".member_area").attr('area-index') == null){
            //     continue;
            // }
            var Income_Div = $(GDIV).eq(i).find(".income-cont > div");
            if ($(Income_Div).length == 0){
                continue;
            }
            var arr1= Special.split(',');
            if (arr1[0] == '0' || arr1[0] == '3'){    //-------------------一般&依實際所得-----------------------------------------------------------------------------------------    
                //console.log(arr1[0]);
                
                for(j=0;j<$(Income_Div).length;j++){
                    var income_ex_flag = 0;
                    //console.log("test1");
                    for(k=0;k<incomes_array.length;k++){
                        //console.log($(Income_Div).eq(j).find(".proper-inc-div-1").text());
                        $(Income_Div).eq(j).find(".proper-inc-div-1 option:selected").text();
                        //console.log("test");
                        if(incomes_array[k][0] == $(Income_Div).eq(j).find(".proper-inc-div-1 option:selected").text()){
                            income_ex_flag = 1;
                            if((Income_Div).eq(j).find(".proper-inc-div-4 option:selected").text()=="月收"){
                                incomes_array[k][1] += parseInt($(Income_Div).eq(j).find(".proper-inc-div-2").val());
                            }else{
                                incomes_array[k][1] += parseInt(parseInt($(Income_Div).eq(j).find(".proper-inc-div-2").val())/12);
                            }
                            
                        }
                    }
                    if(income_ex_flag == 0){
                            
                            if((Income_Div).eq(j).find(".proper-inc-div-4 option:selected").text()=="月收"){
                                incomes_array.push([$(Income_Div).eq(j).find(".proper-inc-div-1 option:selected").text(), parseInt($(Income_Div).eq(j).find(".proper-inc-div-2").val())]);
                            }else{
                                incomes_array.push([$(Income_Div).eq(j).find(".proper-inc-div-1 option:selected").text(), parseInt(parseInt($(Income_Div).eq(j).find(".proper-inc-div-2").val())/12)]);
                            }
                    }
                }

            }else if(arr1[0] == '1'){   //-------------------不列口數-----------------------------------------------------------------------------------------
                //total_members_num++;

            }else if(arr1[0] == '2'){   //-------------------不計收入-----------------------------------------------------------------------------------------
                //total_members_num++;
            }
        }
        //console.log(incomes_array);
        //redraw_left_total_members(members_area_array,total_members_num,list_members_num,limit_income);
        redraw_left_total_incomes(incomes_array);
    }
    //左面板-總收入更新
    function redraw_left_total_incomes(incomes_array){
        //members_area_array
        //TC-L-D2-percent
        //TC-L-D2-sum

        $(".TC-L-D2").empty();
        var outs = "";
        var sum = 0;
        $("#PH-Property-int").text("0");
        $("#PH-Salary").text("0");
        $("#PH-Stock-int").text("0");
        $("#PH-Profit").text("0");
        $("#PH-Bank-int").text("0");
        $("#PH-others-int").text("0");

        for(i=0;i<incomes_array.length;i++){
            outs += '<div class="total-count-left-lc">' + incomes_array[i][0] + '</div><div class="total-count-left-rc">' + incomes_array[i][1] + '</div>';
            sum +=  parseInt(incomes_array[i][1]);
            if(incomes_array[i][0]=="薪資"){
                $("#PH-Salary").text(incomes_array[i][1]);
            }
            if(incomes_array[i][0]=="股票配息"){
                $("#PH-Stock-int").text(incomes_array[i][1]);
            }
            if(incomes_array[i][0]=="營利"){
                $("#PH-Profit").text(incomes_array[i][1]);
            }
            if(incomes_array[i][0]=="存款利息"){
                $("#PH-Bank-int").text(incomes_array[i][1]);
            }
            if(incomes_array[i][0]=="其他"){
                $("#PH-others-int").text(incomes_array[i][1]);
            }
        }
        $("#PH-Property-int").text("0");
        $(".TC-L-D2").append(outs);
        $(".TC-L-D2-sum").text(numberWithCommas(sum));
        $("#PH-total-inc").text(sum);
        var Thonscomm = $(".TC-L-D1-lastincome").text();
        var TInt = Thonscomm.replace(",", "");
        //console.log(parseInt(TInt));
        var original = sum/parseInt(TInt);
       // console.log($(".TC-L-D1-lastincome").text());
        //console.log(original);
        var result = Math.round(original*10000)/100;
        //console.log(result);
        $(".TC-L-D2-percent").text(result + "%");

        var listpeople = $(".TC-L-D1-listpeople").text();
        var lavel = "";
        if(result<=10){
            lavel = "甲級"; 
        }else if(result<=70){
            lavel = "乙級"; 
        }else if(result<=100){
            lavel = "丙級"; 
        }
        $("#LP-result").text(lavel + listpeople + "口");
        $(".TC-L-D2-percent").css('color', 'gray');
        $("#PH-level").text(lavel + listpeople + "口");
        if(result>100){
            $("#LP-result").text("資格不符");
            $("#PH-level").text("資格不符");
            $(".TC-L-D2-percent").css('color', 'red');
        }

        
        //$(".TC-L-D1-lastincome").text();
        // $(".TC-L-D1-allpeople").text(total_members_num);
        // $(".TC-L-D1-listpeople").text(list_members_num);
        // $(".TC-L-D1-lastincome").text(numberWithCommas(limit_income));
    }

    //左面板-總財產計算
    function total_count_property(){ 
        var property_move_array = [];
        var total_members_num = 0;  //總人數
        var total_members_count = 0;  //總列計人數
        var total_property_move = 0;    //動產總和
        var total_property_Deposits = 0;    //儲蓄存款
        var total_property_Securities = 0;  //有價證券
        var total_property_Investment = 0;  //投資
        var total_property_Others = 0;      //其他動產

        var total_property_imm = 0;    //不動產總和
        var total_property_imm_count = 0;    //不動產列計總和


        var total_property_house_num = 0 ;   //房屋數
        var total_property_house_value = 0;    //房屋總值
        var total_property_house_num_con = 0;    //房屋列計數
        var total_property_house_value_con = 0;    //房屋列計總值
        var total_property_land_num = 0 ;   //房屋數
        var total_property_land_value = 0 ;   //房屋總值
        var total_property_land_num_con = 0 ;   //房屋列計數
        var total_property_land_value_con = 0 ;   //房屋列計總值
        


        var property_move_limit = 0    //動產限額
        var property_imm_limit = 0    //不動產限額
        var members_area_array = []    //縣市
        var GDIV = $(".center-total-count .group-div");
        total_members_num = $(GDIV).length-1;   //要扣掉 新增家屬 按鈕


        //console.log(total_members_num);
        for(i=0;i < total_members_num;i++){
            //console.log($(GDIV));
            var Special = $(GDIV).eq(i).find(".people-special .people-input-left").val();
            
            // if ($(GDIV).eq(i).find(".member_area").attr('area-index') == "" || $(GDIV).eq(i).find(".member_area").attr('area-index') == null){
            //     continue;
            // }
            var Property_Div = $(GDIV).eq(i).find(".property-cont > div");
            // if ($(Property_Div).length == 0){
            //     continue;
            // }
            var arr1= Special.split(',');
            var title = $(GDIV).eq(i).find(".people-title input").val();
            if (arr1[0] == '0' || arr1[0] == '2' || title == "役男" || arr1[0] == '3'){    //-------------------一般&依實際所得&不計收入-----------------------------------------------------------------------------------------    
                if(title != "役男"){total_members_count++;}//列計人數+1
                  
                var area = $(GDIV).eq(i).find(".member_area").attr('area-index');

                members_area_array.push(Property_limit[area][3]);
                for(j=0;j<$(Property_Div).length;j++){  
                    //var income_ex_flag = 0;
                    var Property_type = $(Property_Div).eq(j).find(".proper-inc-div-1 option:selected").text();

                    if( Property_type == "儲蓄存款" || Property_type == "有價證券" ||  Property_type == "投資" ||  Property_type == "其他"){
                        //total_property_move += parseInt($(Property_Div).eq(j).find(".proper-inc-div-2").val());
                        total_property_Deposits += parseInt($(Property_Div).eq(j).find(".proper-inc-div-2").val());
        
                    }else if(Property_type == "有價證券"){
                        total_property_Securities += parseInt($(Property_Div).eq(j).find(".proper-inc-div-2").val());
        
                    }
                    else if(Property_type == "投資"){
                        total_property_Investment += parseInt($(Property_Div).eq(j).find(".proper-inc-div-2").val());
        
                    }
                    else if(Property_type == "其他"){
                        total_property_Others += parseInt($(Property_Div).eq(j).find(".proper-inc-div-2").val());
                    }
                    else if(Property_type == "房屋"){
                        if((Property_Div).eq(j).find(".proper-inc-div-4 option:selected").text()=="非自住"){
                            //非自住
                            total_property_house_num++;
                            total_property_house_num_con++;
                            total_property_house_value += parseInt($(Property_Div).eq(j).find(".proper-inc-div-2").val());
                            total_property_house_value_con += parseInt($(Property_Div).eq(j).find(".proper-inc-div-2").val());
                        }else{
                            //自住
                            total_property_house_num++;
                            total_property_house_value += parseInt($(Property_Div).eq(j).find(".proper-inc-div-2").val());
                        }

                    }else if(Property_type == "土地"){
                        if((Property_Div).eq(j).find(".proper-inc-div-4 option:selected").text()=="非自住"){
                            //非自住
                            total_property_land_num++;
                            total_property_land_num_con++;
                            total_property_land_value += parseInt($(Property_Div).eq(j).find(".proper-inc-div-2").val());
                            total_property_land_value_con += parseInt($(Property_Div).eq(j).find(".proper-inc-div-2").val());
                        }else{
                            //自住
                            total_property_land_num++;
                            total_property_land_value += parseInt($(Property_Div).eq(j).find(".proper-inc-div-2").val());
                        }
                    }
                }

            }else if(arr1[0] == '1'){   //-------------------不列口數-----------------------------------------------------------------------------------------
            }
        }
        total_property_imm_count = total_property_land_value_con + total_property_house_value_con;
        property_move_limit = 2500000 + (total_members_count - 1) * 250000;
        property_imm_limit = members_area_array.min();
        total_property_move = total_property_Deposits+total_property_Securities+total_property_Investment+total_property_Others;

        //console.log("列計人數："+total_members_count);
        $("#PH-members").text(total_members_count);
        
        //console.log("儲蓄存款："+total_property_Deposits); 
        $(".TC-L-D3 .total-count-left-rc").eq(0).text(total_property_Deposits);
        $("#PH-Deposits").text(total_property_Deposits);

        //console.log("投資："+total_property_Investment); 
        $(".TC-L-D3 .total-count-left-rc").eq(1).text(total_property_Investment);
        $("#PH-Investment").text(total_property_Investment);
        //console.log("有價證券："+total_property_Securities); 
        $(".TC-L-D3 .total-count-left-rc").eq(2).text(total_property_Securities);
        $("#PH-Securities").text(total_property_Securities);
        
        //console.log("其他動產："+total_property_Others); 
        $(".TC-L-D3 .total-count-left-rc").eq(3).text(total_property_Others);
        $("#PH-others-Pro").text(total_property_Others);
         //console.log("動產總額："+total_property_move);
         $("#total_property_move").text(total_property_move);
         $("#PH-total-pro").text(total_property_move);
         //console.log("不動產總額："+total_property_imm);
         //console.log("不動產列計總額："+total_property_imm_count);
         $("#total_property_imm_count").text(total_property_imm_count);
         $("#PH-total-imm").text(total_property_imm_count);
        //console.log("房屋數："+total_property_house_num);  
        $(".TC-L-D4 .imm-total .imm-head3 span").eq(0).text(total_property_house_num);
        $("#PH-Houses").text(total_property_house_num);
        //console.log("房屋總值："+total_property_house_value);    
        $(".TC-L-D4 .imm-total .imm-head3").eq(1).text(total_property_house_value);
        $("#PH-Houses-total").text(total_property_house_value);
        //console.log("房屋列計數："+total_property_house_num_con);     
        $(".TC-L-D4 .imm-total .imm-head3").eq(2).text(total_property_house_num_con);
        $("#PH-Houses-num").text(total_property_house_num_con);
        //console.log("房屋列計總值："+total_property_house_value_con);  
        $(".TC-L-D4 .imm-total .imm-head3").eq(3).text(total_property_house_value_con);
        $("#PH-Houses-listtotal").text(total_property_house_value_con);
        //console.log("土地數："+total_property_land_num);  
        $(".TC-L-D4 .imm-total .imm-head3 span").eq(1).text(total_property_land_num);
        $("#PH-Land").text(total_property_land_num);
        //console.log("土地總值："+total_property_land_value); 
        $(".TC-L-D4 .imm-total .imm-head3").eq(5).text(total_property_land_value);
        $("#PH-Land-total").text(total_property_land_value);
        //console.log("土地列計數："+total_property_land_num_con);  
        $(".TC-L-D4 .imm-total .imm-head3").eq(6).text(total_property_land_num_con);
        $("#PH-Land-num").text(total_property_land_num_con);
        //console.log("土地列計總值："+total_property_land_value_con);   
        $(".TC-L-D4 .imm-total .imm-head3").eq(7).text(total_property_land_value_con);
        $("#PH-Land-listtotal").text(total_property_land_value_con);

        //console.log("動產限額："+property_move_limit);
        $("#property_move_limit").text(property_move_limit);
        //console.log("不動產限額："+property_imm_limit);
        $("#property_imm_limit").text(property_imm_limit);
        
        if(property_move_limit < total_property_move) {
            $("#property_move_limit").css('color', 'red');
            $("#LP-result").text("資格不符");
            $("#PH-level").text("資格不符");
        }
        else{$("#property_move_limit").css('color', 'gray');}

        if(property_imm_limit < total_property_imm_count) {
            $("#property_imm_limit").css('color', 'red');
            $("#LP-result").text("資格不符");
            $("#PH-level").text("資格不符");
        }
        else{$("#property_imm_limit").css('color', 'gray');}


        //console.log(incomes_array);
        //redraw_left_total_members(members_area_array,total_members_num,list_members_num,limit_income);
        //redraw_left_total_incomes(incomes_array);
    }

    //中面板-個人資料-地址變化時，更新縣市紀錄，寫入個人隱藏紀錄板
    $('.center-total-count').on('change', '.people-id-address .people-input-left', function(event) {
        var AREA = $(this).val();
        var Gdiv = $(this).parents('.group-div').eq(0);
        
        var area_index = -1;
        for ( i=0;i<Property_limit.length;i++ ){
            if(AREA.match(Property_limit[i][0]) != null){
                //alert(Property_limit[i][0]);
                //class="member_area" value="臺中市" area-index=3
                $(Gdiv).find(".member_area").val(Property_limit[i][0]).attr("area-index",i);
                break;
            }
        }
        recount_left_family_panel();
    });

    //中面板-個人資料-刪除紐點擊時，更新提示面板內的資料
    $('.center-total-count').on('click', '.group-div .close', function(event) {
        var Gdiv = $(this).parents('.group-div').eq(0);
        $(Gdiv).addClass('selected');
        var Title   = $(Gdiv).find('.people-title .people-input-center').val();
        var Name    = $(Gdiv).find('.people-name .people-input-left').val();
        var Id    = $(Gdiv).find('.people-id .people-input-left').val();
        $('#confirm-delete-people .modal-body').html("家屬：" + Title + "  " + Name + "  " + Id + "<span style='color:red;'>即將被刪除!</span>");
        recount_left_family_panel();
    });

    //中面板-警告刪除個人資料彈出板關閉時觸發，取消某成員被選取的狀態
    $('#confirm-delete-people').on('hidden.bs.modal', function (event) {    $('.group-div.selected').removeClass('selected');   });

    //中面板-警告刪除個人資料彈出板-點選確認時，刪除被selected的成員
    $('#confirm-delete-people').on('click', 'a.btn-ok', function(event) {
        $('.group-div.selected').remove();
        $('#confirm-delete-people').modal('hide');
        recount_left_family_panel();
    });

    //中面板-成員面板被點擊時，加上被選擇狀態，且更新右側詳細資料面板
    $('.center-total-count').on('click', '.group-div', function(event) {
        if($(this).is(".add-new-button")){return;}
        $('.group-div.selected').removeClass('selected');
        $(this).addClass('selected');
        right_total_count_redraw();

    });

    //中面板-選定中間成員後，重繪整個右方4大區塊
    function right_total_count_redraw(){
        //----
        //console.log("Family member selceted");
        //----------------------------住址頁籤----------------------------------------------------
        $("#right_tab_area .town-name.selected").removeClass('selected');
        $("#area_cost").text("");
        $("#area_cost_year").text("");
        $("#area_limit").text("");

        $("#right_tab_area .town-name.selected").removeClass('selected');
        if ($('.group-div.selected').find(".member_area").attr('area-index') != "" && $('.group-div.selected').find(".member_area").attr('area-index') != null){
            var Aindex = $('.group-div.selected').find(".member_area").attr("area-index");
            $("#right_tab_area .town-name").eq(Aindex).addClass('selected');
            $("#area_cost").text(numberWithCommas(Property_limit[Aindex][2]));
            $("#area_cost_year").text(numberWithCommas(Property_limit[Aindex][2]*12));
            $("#area_limit").text(numberWithCommas(Property_limit[Aindex][3]));
        }
        //----------------------------所得頁籤----------------------------------------------------
        $(".inc-div-cont").empty();
        if ($('.group-div.selected').find(".income-cont > div").length >= 1){
            $('.group-div.selected').find(".income-cont > div").clone().appendTo($(".inc-div-cont"));
        }
        //----------------------------財產頁籤----------------------------------------------------
        $(".pro-div-cont").empty();
        if ($('.group-div.selected').find(".property-cont > div").length >= 1){
            $('.group-div.selected').find(".property-cont > div").clone().appendTo($(".pro-div-cont"));
        }
        //----------------------------敘述頁籤----------------------------------------------------
        $("#right_tab_membercomm > textarea").val($('.group-div.selected').find(".comm-cont").val());
        //$('.group-div.selected').find(".comm-cont").val();

        //<div class=comm-cont></div>
    }




    //右面板-住址-繪製各縣市標籤
    function redraw_area_list_L1(){
        var DIV = $('#right_tab_area > div').eq(0);
        for ( i=0;i<Property_limit.length;i++ ){
               $(DIV).append('<div class="town-name" area="'+Property_limit[i][0]+'">'+Property_limit[i][0]+'</div>');
        }
    }

    //右面板.財產.新增財產按鈕點擊事件
    $("#right_tab_property").on('click', '.add-proper', function(event) {
        var PRO_DIV = '<div class="proper-inc-div" code=new edit=new><button type="button" class="close" data-toggle="modal" data-target="#confirm-delete-pro" aria-label="Close" style="top: 0.2em;right: 0.2em;position: absolute;"><span aria-hidden="true">×</span></button><select class="proper-inc-div-1"><option value="Deposits" selected="">儲蓄存款</option><option value="Securities">有價證券</option><option value="Investment">投資</option><option value="Houses">房屋</option><option value="Land">土地</option><option value="others">其他</option></select><input placeholder="價值" class="people-input-right proper-inc-div-2" value="0"><input placeholder="地址/地號/銀行/公司" class="people-input-left proper-inc-div-3" value=""><input placeholder="備註欄" class="people-input-left proper-inc-div-5" value=""><select class="proper-inc-div-4"style="display: none;"><option value="y" selected="">非自住</option><option value="m">自住</option></select><select class="proper-inc-div-6" style="display: none;"><option value="" selected>縣市</option><option value="臺北市">臺北市</option><option value="新北市">新北市</option><option value="桃園縣">桃園縣</option><option value="臺中市">臺中市</option><option value="臺南市">臺南市</option><option value="高雄市">高雄市</option><option value="基隆市">基隆市</option><option value="新竹縣">新竹縣</option><option value="苗栗縣">苗栗縣</option><option value="彰化縣">彰化縣</option><option value="雲林縣">雲林縣</option><option value="嘉義縣">嘉義縣</option><option value="屏東縣">屏東縣</option><option value="宜蘭縣">宜蘭縣</option><option value="花蓮縣">花蓮縣</option><option value="臺東縣">臺東縣</option><option value="金門縣">金門縣</option><option value="連江縣">連江縣</option></select></div>';
        $(PRO_DIV).appendTo('#right_tab_property .pro-div-cont');
        /* Act on the event */
    });    

    //右面板.財產.財產面板-刪除紐點擊時，將此div selected，並更新提示面板內的資料
    $('.right-total-count').on('click', '#right_tab_property .proper-inc-div .close', function(event) {
        var Gdiv = $(".group-div.selected").eq(0);
        $(Gdiv).addClass('selected');

        var Idiv = $(this).parents('.proper-inc-div').eq(0);
        $(Idiv).addClass('selected');

        var Title   = $(Gdiv).find('.people-title .people-input-center').val();
        var Name    = $(Gdiv).find('.people-name .people-input-left').val();
        var Id      = $(Gdiv).find('.people-id .people-input-left').val();
        var Inc_Title   =   $(Idiv).find(".proper-inc-div-1 option:selected").text();
        var Inc_Value   =   $(Idiv).find(".proper-inc-div-2").val();
        var Inc_from    =   $(Idiv).find(".proper-inc-div-3").val();
        //var Inc_Cycle   =   $(Idiv).find(".proper-inc-div-4 option:selected").text();

        $('#confirm-delete-pro .modal-body').html("家屬：" + Title + "  " + Name + "  " + Id + "的財產：<br>在" +
         Inc_from + "的" + Inc_Title + "共" + Inc_Value +"元<span style='color:red;'>即將被刪除!</span>");
    });
    //右面板.財產.警告刪除財產提示板.關閉時觸發，取消某財產被選取的狀態
    $('#confirm-delete-pro').on('hidden.bs.modal', function (event) {   $('.proper-inc-div.selected').removeClass('selected');  });

    //右面板.財產.警告刪除財產提示板.點選確認觸發，刪除被selected的財產
    $('#confirm-delete-pro').on('click', 'a.btn-ok', function(event) {
        //var property = [];
        //var PDIV = $('.proper-inc-div.selected').eq(0);
        // if($(PDIV).attr('code')=="new"){

        // }else{
        //     property['code'] = $(PDIV).attr('code');
        //     property['edit'] = "delete";
        //     //console.log(property);
        //     File_data_property.push(property);
        //     //console.log(File_data_property);
        // }
        $('.proper-inc-div.selected').remove();
        $('#confirm-delete-pro').modal('hide');
        var MDIV = $(".group-div.selected").eq(0);
        var IGContiv = $(".group-div.selected").find('.property-cont').eq(0);     //income-cont -> property-cont
        $(IGContiv).empty();
        $("#right_tab_property .pro-div-cont > div").clone().appendTo($(IGContiv));
        setTimeout(function(){
          recount_member_pro(MDIV);
          recount_left_family_panel();
        }, 300);
        

        
        
    });
    
    //右面板.財產.輸入欄位有變動觸發，立即寫回成員隱藏面板，並更新此家屬財產總額
    $('.right-total-count').on('change', '#right_tab_property .proper-inc-div input, #right_tab_property .proper-inc-div select', function(event) {       
        if ($(this).is('select')){
            $(this).find("option[selected]").removeAttr('selected');
            $(this).find("option:selected").attr('selected','selected');
            //$(this).find("option:selected").text();
            //alert($(this).find("option:selected").text());
            var title = $(this).parent().children(".proper-inc-div-1 option:selected").text();
            //alert('pro select');
            if($(this).is('.proper-inc-div-1')){
                if($(this).children("option:selected").text() == '房屋' || $(this).children("option:selected").text() == '土地' ){
                    $(this).parent().find(".proper-inc-div-6").fadeIn();
                    $(this).parent().children(".proper-inc-div-4").fadeIn();
                }else{
                    $(this).parent().find(".proper-inc-div-6").fadeOut();
                    $(this).parent().children(".proper-inc-div-4").fadeOut();
                }
            }
        }
        //複製回成員隱藏面板
        var MDIV = $(".group-div.selected").eq(0);
        var IGContiv = $(".group-div.selected").find('.property-cont').eq(0);     //income-cont -> property-cont
        $(IGContiv).empty();
        $("#right_tab_property .pro-div-cont > div").clone().appendTo($(IGContiv));
        //更新此家屬面板財產
        // var IGCD = $(IGContiv).children('div');
        // var Inc_Title   =  "";
        // var Inc_Value   =  "";
        // var Inc_from    =  "";
        // var Inc_self   =  "";
        // var Inc_area   =  "";
        // var Income = 0;
        // for (i=0;i<IGCD.length;i++){
        //     Inc_Title   =   $(IGCD).eq(i).find(".proper-inc-div-1 option:selected").text();
        //     Inc_Value   =   $(IGCD).eq(i).find(".proper-inc-div-2").val();
        //     Inc_from    =   $(IGCD).eq(i).find(".proper-inc-div-3").val();
        //     Inc_self   =   $(IGCD).eq(i).find(".proper-inc-div-4 option:selected").text();
        //     Inc_area   =   $(IGCD).eq(i).find(".proper-inc-div-6 option:selected").text();
            
        //         if(Inc_Title == '房屋' || Inc_Title == '土地' ){
        //             if(Inc_self == "自住"){
        //                 Income += parseInt(0);
        //             }else{
        //                 Income += parseInt(Inc_Value);
        //             }
        //         }else{
        //             Income += parseInt(Inc_Value);
        //         }
        // }
        // Income = parseInt(Income);
        // $(".group-div.selected").find('.people-property-total-value').html(numberWithCommas(Income) + '<img class="svg social-link NTD" src="/0MS/images/NTD.svg">');
        // svg_redraw();


        recount_member_pro(MDIV);
        recount_left_family_panel();
    });



    //右面板.所得.新增所得按鈕被點擊後
    $("#right_tab_income .add-proper-inc").click(function(event) {
        var INC_DIV = '<div class="proper-inc-div" code=new edit=new><button type="button" class="close" data-toggle="modal" data-target="#confirm-delete-inc" aria-label="Close" style="top: 0.2em;right: 0.2em;position: absolute;"><span aria-hidden="true">×</span></button><select class="proper-inc-div-1"><option value="Salary" selected>薪資</option><option value="Stock-int">股票配息</option><option value="Profit">營利</option><option value="Bank-int" >存款利息</option><option value="others">其他</option></select><input placeholder="額度-新台幣(元)" class="people-input-right proper-inc-div-2" value="0"><input placeholder="來源單位(企業或機構)" class="people-input-left proper-inc-div-3" value=""><input placeholder="備註欄" class="people-input-left proper-inc-div-5" value=""><select class="proper-inc-div-4"><option value="m">月收</option><option value="y" selected>年收</option></select><input placeholder="利率/值" class="people-input-right proper-inc-div-7" value="" style="display: none;"></div>';
        $(INC_DIV).appendTo('#right_tab_income .inc-div-cont');
    });

    //右面板.所得.所得面板-刪除紐點擊時，將此div selected，並更新提示面板內的資料
    $('.right-total-count').on('click', '#right_tab_income .proper-inc-div .close', function(event) {
        var Gdiv = $(".group-div.selected").eq(0);
        $(Gdiv).addClass('selected');

        var Idiv = $(this).parents('.proper-inc-div').eq(0);
        $(Idiv).addClass('selected');

        var Title   = $(Gdiv).find('.people-title .people-input-center').val();
        var Name    = $(Gdiv).find('.people-name .people-input-left').val();
        var Id      = $(Gdiv).find('.people-id .people-input-left').val();
        var Inc_Title   =   $(Idiv).find(".proper-inc-div-1 option:selected").text();
        var Inc_Value   =   $(Idiv).find(".proper-inc-div-2").val();
        var Inc_from    =   $(Idiv).find(".proper-inc-div-3").val();
        var Inc_Cycle   =   $(Idiv).find(".proper-inc-div-4 option:selected").text();

        $('#confirm-delete-inc .modal-body').html("家屬：" + Title + "  " + Name + "  " + Id + "的所得：<br>從" +
         Inc_from + Inc_Cycle + Inc_Value + "的" + Inc_Title +"<span style='color:red;'>即將被刪除!</span>");
    });

    //右面板.所得.警告刪除所得提示板.關閉時觸發，取消某所得被選取的狀態
    $('#confirm-delete-inc').on('hidden.bs.modal', function (event) {   $('.proper-inc-div.selected').removeClass('selected');  });

    //右面板.所得.警告刪除所得提示板.點選確認觸發，刪除被selected的所得
    $('#confirm-delete-inc').on('click', 'a.btn-ok', function(event) { 
        
        $('.proper-inc-div.selected').remove();
        $('#confirm-delete-inc').modal('hide');
        var MDIV = $(".group-div.selected").eq(0);
        var IGContiv = $(".group-div.selected").find('.income-cont').eq(0);     //income-cont -> property-cont
        $(IGContiv).empty();
        $("#right_tab_income .inc-div-cont > div").clone().appendTo($(IGContiv));
        setTimeout(function(){
          recount_member_inc(MDIV);
          recount_left_family_panel();
        }, 300);






        
        //total_count_incomes();
        //recount_left_family_panel();
    });

    //右面板.所得.輸入欄位有變動觸發，立即寫回成員隱藏面板，並更新此家屬所得總額(轉換為月收入)
    $('.right-total-count').on('change', '#right_tab_income .proper-inc-div input, #right_tab_income .proper-inc-div select', function(event) {
        if ($(this).is('select')){
            $(this).find("option[selected]").removeAttr('selected');
            $(this).find("option:selected").attr('selected','selected');

            if($(this).children("option:selected").text() == '股票配息' || $(this).children("option:selected").text() == '存款利息'){
                $(this).parent().find(".proper-inc-div-4").val("y");
                $(this).parent().find(".proper-inc-div-7").fadeIn();
                if($(this).children("option:selected").text() == '存款利息'){$(this).parent().find(".proper-inc-div-7").val(0.01355)}
            }else{
                $(this).parent().find(".proper-inc-div-7").fadeOut();
            }
        }
        //複製回成員隱藏面板
        var MDIV = $(".group-div.selected").eq(0);
        var IGContiv = $(MDIV).find('.income-cont').eq(0);
        $(IGContiv).empty();
        $("#right_tab_income .inc-div-cont > div").clone().appendTo($(IGContiv));
        //更新成員面板所得月薪
        var IGCD = $(IGContiv).children('div');
        var Inc_Title   =  "";
        var Inc_Value   =  "";
        var Inc_from    =  "";
        var Inc_Cycle   =  "";
        var Income = 0;
        for (i=0;i<IGCD.length;i++){
            Inc_Title   =   $(IGCD).eq(i).find(".proper-inc-div-1 option:selected").text();
            Inc_Value   =   $(IGCD).eq(i).find(".proper-inc-div-2").val();
            Inc_from    =   $(IGCD).eq(i).find(".proper-inc-div-3").val();
            Inc_Cycle   =   $(IGCD).eq(i).find(".proper-inc-div-4 option:selected").text();
            if(Inc_Cycle == "年收"){
                Income += parseInt(Inc_Value)/12;
            }else{
                Income += parseInt(Inc_Value);
            }
            console.log(Inc_Title);
            console.log(Inc_Value);
            console.log(Inc_from);
            console.log(Inc_Cycle);
        }
        Income = parseInt(Income);
        console.log(Income);
        $(".group-div.selected").find('.people-income-total-value').html(numberWithCommas(Income) + '<img class="svg social-link NTD" src="/0MS/images/NTD.svg">');
        svg_redraw();
        recount_member_inc(MDIV);
        //total_count_incomes();
        recount_left_family_panel();
    }); 

    //右面板.敘述欄位有變動觸發，立即寫回成員隱藏面板，並更新此家屬所得總額(轉換為月收入)
    $('#right_tab_membercomm').on('change', 'textarea', function(event) {
        //event.preventDefault();
        $(".group-div.selected").find('.comm-cont').val($(this).val());
        /* Act on the event */
    });

    //自動成員敘述產生按鈕點擊.更新提示面板資訊
    $('#right_tab_membercomm').on('click', '.auto-comm', function(event) {
        $('#confirm-auto-comm').modal('toggle');
        //var Inc_Cycle   =   $(Idiv).find(".proper-inc-div-4 option:selected").text();
        var title = $(".group-div.selected .people-title input").val();
        var name =  $(".group-div.selected .people-name input").val();
        var age =   $(".group-div.selected .people-birthday input").attr('age');
        var job = $.trim($(".group-div.selected .people-job input").val());
        job = job?job:'無';
        var income = $.trim($(".group-div.selected .people-income-total-value").text());       
        income = (income === '0')?'查無所得資料':'月均所得：$'+income;

        var special = $(".group-div.selected .people-special select option:selected").val();
        var status = $(".group-div.selected .people-special select option:selected").text();
        var status_result =  $(".group-div.selected .people-special span").text();
        var special_txt = '';
        var description = '';
        if(status_result == "實際所得"){
            status_result = "依實際所得計算";
        }
        switch(special){
            case '1,15':
                description = title+'：'+name+'，歿。';
                break;
            case '0,0':
            case '0,2':
                description = title+'：'+name+'，'+age+'歲，職業：'+job+'，'+income+'。';                
                break;
            default:
                special_txt = '，因其為'+status+'，故'+status_result+'。';
                description = title+'：'+name+'，'+age+'歲，職業：'+job+'，'+income+special_txt;      
        }
        //財產
        var properties = $(".group-div.selected .property-cont").children('.proper-inc-div');
        var self_house_count = 0;
        var self_land_count = 0;
        var house_count = 0;    //非自用房屋數
        var land_count = 0;     //菲自用土地數
        var house_land_value =0 //非自用房屋+菲自用土地 總額
        var saving_count = 0;   // 儲蓄存款 筆數
        var security_count = 0; //有價證券 筆數
        var investment_count = 0; // 投資 筆數
        var others_count = 0; //其他 筆數
        var movable_value = 0 //動產總額
        for( var i= 0; i<properties.length; i++){
            var pType = properties.eq(i).find(".proper-inc-div-1 option:selected").text();
            var pValue = parseInt(properties.eq(i).find(".proper-inc-div-2").val());
            var pSelf = properties.eq(i).find(".proper-inc-div-4 option:selected").text();
            switch(pType){
                case '房屋':                    
                    if (pSelf === '自住'){
                        self_house_count++;
                    }else{
                        house_count++;
                        house_land_value+= pValue;
                    }
                    break;
                case '土地':                    
                    if (pSelf === '自住'){
                        self_land_count++;
                    }else{
                        land_count++;
                        house_land_value+= pValue;
                    }
                    break;
                case '儲蓄存款':
                    saving_count++;
                    movable_value += pValue;
                    break;
                case '有價證券':
                    security_count++;
                    movable_value += pValue;
                    break;
                case '投資':
                    investment_count++;
                    movable_value += pValue;
                    break;
                case '其他':
                    others_count++;
                    movable_value += pValue;
                    break;
            }
        }

        var real_estate = (self_house_count>0)?'自用房屋 '+self_house_count+'筆；':'';
        real_estate += (self_land_count>0)? '自用土地 '+self_land_count+'筆；':'';
        real_estate += (house_count>0)? '非自用房屋 '+house_count+'筆；':'';
        real_estate += (land_count>0)? '非自用土地 '+land_count+'筆；':'';
        real_estate = (real_estate ==='')?'':'名下有不動產：'+real_estate+'列計總額共 $'+house_land_value+'元整。';
        
        var movable = (saving_count>0)?'儲蓄存款 '+saving_count+'筆；':'';
        movable += (security_count>0)?'有價證券 '+security_count+'筆；':'';
        movable += (investment_count>0)?'投資 '+investment_count+'筆；':'';
        movable += (others_count>0)?'其他 '+others_count+'筆；':'';
        movable = (movable === '')?'':'名下有動產：'+movable+'共 $'+movable_value+'元整。';
        description = description +'\n' +real_estate+'\n' +movable;

        $('#confirm-auto-comm .modal-body').html(description);
    });
    //自動成員敘述產生按鈕點擊.關閉時觸發
    $('#confirm-auto-comm').on('hidden.bs.modal', function (event) {
       //$('.proper-inc-div.selected').removeClass('selected');  


    });

    //自動成員敘述產生按鈕點擊.點選確認觸發，啟用自動成員家況敘述功能
    $('#confirm-auto-comm').on('click', 'a.btn-ok', function(event) {
        $('#confirm-auto-comm').modal('toggle');
        var description = $('#confirm-auto-comm .modal-body').html();
        $("#right_tab_membercomm textarea").val(description).trigger('change');

    });












      
/*************************統計分析          statistics.php****************************************/
    //測試chart.js 圖表
    window.onload = function(){
        var ctx = document.getElementById("chart-area").getContext("2d");
        new Chart(ctx, {
            type: "bar",
            data: data,
            // Boolean - whether or not the chart should be responsive and resize when the browser does.
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: false,
            options: {
                scales: {
                    xAxes: [{
                        stacked: true
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
        });
    };
    //---------------------------------------------------------------財產------------------------------------------------------------------------------------


    // //警告刪除個人財產資料彈出板關閉時觸發，取消某成員被選取的狀態
    // $('#confirm-delete-pro').on('hidden.bs.modal', function (event) {
    //     $('.proper-inc-div.selected').removeClass('selected');
    // });

    // //警告刪除個人財產資料彈出板-點選確認時，刪除被selected的成員
    // $('#confirm-delete-pro').on('click', 'a.btn-ok', function(event) {
    //     $('.proper-inc-div.selected').remove();
    //     $('#confirm-delete-pro').modal('hide');
    // });

    

    //---------------------------------------------------------------所得------------------------------------------------------------------------------------


    //---------------------------------------------------------------------------------------------------------------------------------------------------      

    //中面板.家屬.特殊身份狀態更新時，判斷是否要列入口數，是否為學生狀態，男學生或女學生，是否服役中，轉換重繪SVG，以便著色
    $('.center-total-count').on('change', '.people-special .people-input-left', function(event) {
        var arr = $(this).val();
        //console.log(arr.split());
        var arr1= arr.split(',');
        // console.log(arr1);
        // console.log(arr1[0]);
        if (arr1[0] == 0){
            $(this).parents('.people-special').children('span').text('一般');
        }else if(arr1[0] == 1){
            $(this).parents('.people-special').children('span').text('不列口數');
        }else if(arr1[0] == 2){
            $(this).parents('.people-special').children('span').text('不計收入');
        }else if(arr1[0] == 3){
            $(this).parents('.people-special').children('span').text('實際所得');
        }

        var Title = $(this).parents('.group-div').find('.people-title .people-input-center').val();
        var female = Title.match(/母|姨|姑|嬸|嫂|姊|妹|姐|娘|婆/g);
        var student_g = '<img id="Picon-man" class="svg social-link svg-people" src="/0MS/images/people/custom/female-graduate-student.svg">';
        var student_b = '<img id="Picon-man" class="svg social-link svg-people" src="/0MS/images/people/custom/graduate-student-avatar.svg">';
        var woman = '<img id="Picon-man" class="svg social-link svg-people" src="/0MS/images/people/custom/woman-avatar.svg">';
        var man = '<img id="Picon-man" class="svg social-link svg-people" src="/0MS/images/people/custom/man-avatar.svg">';
        var captain = '<img id="Picon-man" class="svg social-link svg-people" src="/0MS/images/people/custom/captain.svg">';
        $(this).parents('.group-div').find('.svg-people').remove();
        if(arr1[1] == 33 || arr1[1] == 4){  //是否學生
            if(female != null){ //女或男
                $(student_g).appendTo($(this).parents('.group-div'));
            }else{
                $(student_b).appendTo($(this).parents('.group-div'));
            }
            svg_redraw();
        }
        else{
           if(female != null){ //女或男
                $(woman).appendTo($(this).parents('.group-div'));
            }else{//是否役男
                if(arr1[1] == 1){
                    $(captain).appendTo($(this).parents('.group-div'));
                }else{
                    $(man).appendTo($(this).parents('.group-div')); 
                }
            } 
        }
        svg_redraw();
        recount_left_family_panel();

    });

    //中面板.家屬.是否有結婚，要加圖示
    $('.center-total-count').on('change', '.people-marriage .people-input-left', function(event) {
        var MS = $(this).val();
        var marriage = '<img class="svg social-link marriage" src="/0MS/images/marriage.svg">';
        if (MS != "未婚" && MS != "無" && MS != ""){
            $(this).parents('.people-marriage').html(marriage + '<input style="width: 5em;" class="people-input-left" placeholder="配偶姓名" value="'+ MS +'">');
            svg_redraw();
        }else{
            $(this).parents('.people-marriage').html('<input style="width: 5em;" class="people-input-left" placeholder="配偶姓名" value="未婚">');
        }
    });

    //中面板.家屬.是否有離婚，要加圖示
    $('.center-total-count').on('change', '.people-marriage2 .people-input-left', function(event) {
        var MS = $(this).val();
        var marriage2 = '<img class="svg social-link marriage" src="/0MS/images/broke_heart.svg">';
        if (MS != "未離異" && MS != "無" && MS != ""){
            $(this).parents('.people-marriage2').html(marriage2 + '<input style="width: 5em;" class="people-input-left" placeholder="前配偶" value="'+ MS +'">');
            svg_redraw();
        }else{
            $(this).parents('.people-marriage2').html('<input style="width: 5em;" class="people-input-left" placeholder="前配偶" value="">');
        }
    });

    //中面板.家屬.稱謂變化觸發 是否女生? 清除原本SVG，然後重繪SVG以便著色
    $('.center-total-count').on('change', '.people-title .people-input-center', function(event) {
        var Title = $(this).val();
        var female = Title.match(/母|姨|姑|嬸|嫂|姊|妹|姐|娘|婆/g);
        var woman = '<img id="Picon-man" class="svg social-link svg-people" src="/0MS/images/people/custom/woman-avatar.svg">';
        var man = '<img id="Picon-man" class="svg social-link svg-people" src="/0MS/images/people/custom/man-avatar.svg">';
        var captain = '<img id="Picon-man" class="svg social-link svg-people" src="/0MS/images/people/custom/captain.svg">';
        $(this).parents('.group-div').find('.svg-people').remove();

        if(female != null){ //女
            $(woman).appendTo($(this).parents('.group-div'));
        }else{
            var Sboy = Title.match(/役男/g);
            if(Sboy != null){
                $(captain).appendTo($(this).parents('.group-div'));
            }else{
               $(man).appendTo($(this).parents('.group-div')); 
            }
        }
        svg_redraw();
    });

    //中面板.家屬.新增家屬按鈕被點擊
    $(".center-total-count").on('click', '.add-people', function(event) {
        //event.preventDefault();
        var GROUP_DIV = '<div class="group-div" code=new edit=new><button type="button" class="close" data-toggle="modal" data-target="#confirm-delete-people" aria-label="Close" style="top: 0.2em;right: 0.2em;position: absolute;"><span aria-hidden="true">×</span></button><div style="width: 8em;height: 8em;"><img id="Picon-man" class="svg social-link svg-people" src="/0MS/images/people/custom/man-avatar.svg" /></div><div class="income-total"><div>所得</div><div class="people-income-total-value">0<img class="svg social-link NTD" src="/0MS/images/NTD.svg"></div></div><div class="property-total"><div>財產</div><div class="people-property-total-value">0<img class="svg social-link NTD" src="/0MS/images/NTD.svg"></div></div><div class="people-job"><input class="people-input-left" placeholder="所得職業" value=""></div><div class="people-title"><input class="people-input-center" placeholder="稱謂" value=""></div><div class="people-name"><input class="people-input-left" placeholder="姓名" value=""></div><div class="people-id"><input class="people-input-left" placeholder="身份證字號" value=""></div><div class="people-id-address"><input class="people-input-left" placeholder="戶籍地址" value="'+ $("#PH-fulladdress").text() +'"></div><div class="people-marriage"><input style="width: 5em;" class="people-input-left" placeholder="配偶姓名" value="未婚"></div><div class="people-marriage2"><input style="width: 5em;" class="people-input-left" value="" placeholder="前配偶"></div><div class="people-birthday"><span>生日：</span><input placeholder="7位數民國生日" class="people-input-left birthday" value="" style="width: 7em;">　　<span>(0歲)</span></div><div class="people-special">身分：<span style="color: #a47523;">一般</span><div style="width: 7.5em;position: relative;left: 1em;display: inline-block;"><select class="people-input-left"><option value="0,0" selected>一般</option><option value="0,2">產業訓儲或第3階段替代</option><option value="1,15">歿</option><option value="1,1">服役中</option><option value="1,3">榮民領有生活費</option><option value="1,4">就學領有公費</option><option value="1,5">通緝或服刑</option><option value="1,6">失蹤有案</option><option value="1,7">災難失蹤</option><option value="1,8">政府安置</option><option value="1,9">無設籍外、陸配</option><option value="1,10">無扶養事實之直系尊親屬</option><option value="1,11">未盡照顧職責之父母</option><option value="1,12">父母離異而分離之兄弟姊妹</option><option value="1,13">無國籍</option><option value="1,14">不列口數：其他</option><option value="3,30">55歲以上,16歲以下無收入</option><option value="3,31">身心障礙、重大傷病</option><option value="3,32">3個月內之重大傷病</option><option value="3,33">學生</option><option value="3,34">孕婦</option><option value="3,35">獨自照顧直系老幼親屬</option><option value="3,36">獨自照顧重大傷病親屬</option><option value="3,37">依實際所得：其他</option><option value="2,38">不計收入：其他</option></select></div></div><div class=hidden-info><input type="hidden" name="" class="member_area" value="" area-index><div class=income-cont></div><div class=property-cont></div><textarea class=comm-cont></textarea></div></div>';
        $(GROUP_DIV).insertBefore($(this).parent());
        svg_redraw();
        var index_g = $(".group-div").length - 2;
        $(".group-div").eq(index_g).find('.people-id-address input').trigger('change');
        //recount_left_family_panel();
    });

    //中面板.家屬.生日改變：計算其歲數
    $('.center-total-count').on('change', '.birthday', function(event) {
        var dateString = parseInt($(this).val());
        dateString = dateString.toString();
        if(dateString.length == 6){ dateString = "0" + dateString;}
        var YYY = dateString.substring(0, 3);
        var MM  = dateString.substring(3, 5);
        var DD  = dateString.substring(5, 7);
        var YYYMMDD = YYY + "年" + MM + "月" + DD + "日";
        $(this).val(YYYMMDD);

        var YYYY = parseInt(YYY) + 1911;
        var YYYYMMDD = "" + YYYY + "-" + MM + "-" + DD +"";
        $(this).attr('YYYYMMDD', YYYYMMDD);
        // console.log(YYYYMMDD);
        var age_ = new Date(YYYYMMDD);
        var age = _calculateAge(age_);
        $(this).attr('age', age);
        // console.log(age);
        $(this).next('span').text("(" + age + "歲)");
        if(age<16 ||age >=55){
            $(this).next('span').css('color', 'red');
        }else{
            $(this).next('span').css('color', '');
        }
        recount_left_family_panel();
    });



    //統計頁面，範圍起始日期，選擇器初始化        
    $('#datetimepicker1').datetimepicker({
        viewMode: 'years',
        format: 'YYYY-MM',
        locale: 'zh-tw'
    });
    //統計頁面，範圍結束日期，選擇器初始化
    $('#datetimepicker2').datetimepicker({
        viewMode: 'years',
        format: 'YYYY-MM',
        locale: 'zh-tw'
    });


    
    //



    
});


