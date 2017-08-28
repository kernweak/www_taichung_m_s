	var M_Y = 12;	//以年收顯示:12		以月收顯示:1
	
    //計算目前歲數
    function _calculateAge(birthday) { // birthday is a date
        var ageDifMs = Date.now() - birthday.getTime();
        var ageDate = new Date(ageDifMs); // miliseconds from epoch
        return Math.abs(ageDate.getUTCFullYear() - 1970);
    }

    //重新計算成員面板上的財產數字
    function recount_member_pro(MDIV){      
        var IGContiv = $(MDIV).find('.property-cont').eq(0);     //income-cont -> property-cont
        var IGCD = $(IGContiv).children('div');
        // console.log(IGCD);
        var Inc_Title   =  "";
        var Inc_Value   =  "";
        var Inc_from    =  "";
        var Inc_self   =  "";
        var Inc_area   =  "";
        var Income = 0;
        for (i=0;i<IGCD.length;i++){
            Inc_Title   =   $(IGCD).eq(i).find(".proper-inc-div-1 option:selected").text();
            Inc_Value   =   $(IGCD).eq(i).find(".proper-inc-div-2").val();
            Inc_from    =   $(IGCD).eq(i).find(".proper-inc-div-3").val();
            Inc_self   =   $(IGCD).eq(i).find(".proper-inc-div-4 option:selected").text();
            Inc_area   =   $(IGCD).eq(i).find(".proper-inc-div-6 option:selected").text();
            
                if(Inc_Title == '房屋' || Inc_Title == '土地' ){
                    if(Inc_self == "自住"){
                        Income += parseInt(0);
                    }else{
                        Income += parseInt(Inc_Value);
                    }
                }else{
                    Income += parseInt(Inc_Value);
                }
            // console.log(Inc_Title);
            // console.log(Inc_Value);
            // console.log(Inc_from);
            // console.log(Inc_self);
        }
        Income = parseInt(Income);
        // console.log(Income);
        $(MDIV).find('.people-property-total-value').html(numberWithCommas(Income) + '<img class="svg social-link NTD" src="/0MS/images/NTD.svg">');
        svg_redraw();
    }

    //重新計算成員面板上的所得數字
    function recount_member_inc(MDIV){      
        var IGContiv = $(MDIV).find('.income-cont').eq(0);     //income-cont -> property-cont
        var Special = $(MDIV).find(".people-special .people-input-left").val();
        var arr1= Special.split(',');
        var IGCD = $(IGContiv).children('div');
        var Inc_Title   =  "";
        var Inc_Value   =  "";
        var Inc_from    =  "";
        var Inc_Cycle   =  "";
        var Income = 0;
        var Income_Sal = 0;
        var Income_NonSal = 0;
        var SalaryWaring = "" ;
        if (arr1[0] == '0' ){
            //console.log("身分0");
            for (i=0;i<IGCD.length;i++){
                Inc_Title   =   $(IGCD).eq(i).find(".proper-inc-div-1 option:selected").text();
                Inc_Value   =   $(IGCD).eq(i).find(".proper-inc-div-2").val();
                Inc_from    =   $(IGCD).eq(i).find(".proper-inc-div-3").val();
                Inc_Cycle   =   $(IGCD).eq(i).find(".proper-inc-div-4 option:selected").text();
                if(Inc_Title == "薪資"){
                    if(Inc_Cycle == "年收"){
                        Income_Sal += parseInt(Inc_Value)/(12/M_Y);
                    }else{
                        Income_Sal += parseInt(Inc_Value)*M_Y;
                    }
                }else{
                    if(Inc_Cycle == "年收"){
                        Income_NonSal += parseInt(Inc_Value)/(12/M_Y);
                    }else{
                        Income_NonSal += parseInt(Inc_Value)*M_Y;
                    }
                }
                // console.log(Inc_Title);
                // console.log(Inc_Value);
                // console.log(Inc_from);
                // console.log(Inc_Cycle);
            }
            SalaryWaring = (Income_Sal < monthly_minimum_wage*12) ? "<span class='Salary-Waring  cz-tooltip' data-toggle='tooltip' data-placement='right' title='一般身分下，薪資合計未達基本工資者，依基本工資計算'>！</span>" : "";
            Income_Sal = (Income_Sal <= monthly_minimum_wage*12)?monthly_minimum_wage*12:Income_Sal;
            Income = Income_Sal + Income_NonSal;
            //console.log(SalaryWaring);
        }else{
            for (i=0;i<IGCD.length;i++){
                Inc_Title   =   $(IGCD).eq(i).find(".proper-inc-div-1 option:selected").text();
                Inc_Value   =   $(IGCD).eq(i).find(".proper-inc-div-2").val();
                Inc_from    =   $(IGCD).eq(i).find(".proper-inc-div-3").val();
                Inc_Cycle   =   $(IGCD).eq(i).find(".proper-inc-div-4 option:selected").text();
                if(Inc_Cycle == "年收"){
                    Income += parseInt(Inc_Value)/(12/M_Y);
                }else{
                    Income += parseInt(Inc_Value)*M_Y;
                }
                // console.log(Inc_Title);
                // console.log(Inc_Value);
                // console.log(Inc_from);
                // console.log(Inc_Cycle);
            }
        }
        Income = parseInt(Income) || 0;
        // console.log(Income);
        $(MDIV).find('.people-income-total-value').html(SalaryWaring + numberWithCommas(Income) + '<img class="svg social-link NTD" src="/0MS/images/NTD.svg">');
        $('[data-toggle="tooltip"]').tooltip();
        svg_redraw();

    }

    //檢查成員面板的稱謂、姓名、生日三項必填欄位有沒有填
    function members_must_input_check(){
        $('.center-total-count .group-div').find(".people-title, .people-name, .people-birthday").each(function(index, el) {
            Input = $(this).children('input').eq(0);

            if($(Input).val() == ""){
                $(Input).addClass('EmptyWar');
            }
            else if($(this).hasClass('people-title') || $(this).hasClass('people-name')){
                $(Input).removeClass('EmptyWar');
            }
        });
    }

$(document).ready(function() {

    /*************************全網站初始化****************************************/
    
    //按鈕小說明
    $('[data-toggle="tooltip"]').tooltip(); 


    //重繪所有SVG，變成內嵌，這樣才能著色
    svg_redraw();

    redraw_area_list_L1();  //各縣市列表icon改成用js跑
     //啟用"案件編輯"下拉選單 (最終... 必須要開啟案件/新增案件 才能觸發 "案件編輯" )
     //$("#family-edit-nav").fadeIn(400);

    /*************************全網站通用      TEST.php****************************************/
    //重新計算家屬編修左面板
    //recount_left_family_panel();

    function recount_left_family_panel(){
        total_count_members();
        total_count_incomes();
        total_count_property();
    }

    /*************************待辦案件      filelist.php****************************************/
    //彈出窗--點擊開啟檔案
    /*
    $("#myModal-table_id > tbody > tr:nth-child(1) > td:nth-child(2) > button").click(function(event) {
        $('#myModal').modal('hide');
        $("#bs-example-navbar-collapse-1 > ul:nth-child(1) > li:nth-child(2) > a").tab('show')
    });
    */

    


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
        
        //console.log(GDIV);
        //console.log(GDAI);
        total_members_num = $(GDIV).length-1;   //要扣掉 新增家屬 按鈕
        //console.log(total_members_num);
        for(i=0;i < total_members_num;i++){
            var GDAI = $(GDIV).eq(i).find(".member_area").attr('area-index');
            var Special = $(GDIV).eq(i).find(".people-special .people-input-left").val();
            //console.log(Special);
            if (GDAI == "" || GDAI == null){
                break;
            }

            var arr1= Special.split(',');
            if (arr1[0] == '0'){    //-------------------一般-----------------------------------------------------------------------------------------    

                list_members_num++;
                var area = $(GDIV).eq(i).find(".member_area").val();
                var area_income_limit_index = parseInt(GDAI);
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
                var area_income_limit_index = parseInt(GDAI);
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
                var area_income_limit_index = parseInt(GDAI);
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

		limit_income = limit_income * M_Y;	//總收入以年或月計算
		
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
        $("#PH-need").text(numberWithCommas(limit_income));
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
            var title = $(GDIV).eq(i).find(".people-title input").val();
            if (arr1[0] == '0'){    //-------------------一般-----------------------------------------------------------------------------------------    
                //console.log(arr1[0]);
                var Income_Sal = 0; //薪資部分初始化
                for(j=0;j<$(Income_Div).length;j++){
                    var income_ex_flag = 0;
                    var Inc_Title = $(Income_Div).eq(j).find(".proper-inc-div-1 option:selected").text();
                    var Inc_Value = $(Income_Div).eq(j).find(".proper-inc-div-2").val();
                    var Inc_Cycle = $(Income_Div).eq(j).find(".proper-inc-div-4 option:selected").text();

                    if(Inc_Title == "薪資"){      //同一人各薪資獨立統計，
                        if(Inc_Cycle == "年收"){
                            Income_Sal += parseInt(Inc_Value)/(12/M_Y);
                        }else{
                            Income_Sal += parseInt(Inc_Value)*M_Y;
                        }
                    }

                    //console.log("test1");
                    for(k=0;k<incomes_array.length;k++){
                        //console.log($(Income_Div).eq(j).find(".proper-inc-div-1").text());
                        
                        //console.log("test");
                        if(incomes_array[k][0] == Inc_Title){
                            income_ex_flag = 1;
                            if(Inc_Cycle=="月收"){
                                incomes_array[k][1] += parseInt(Inc_Value*M_Y);

                            }else{
                                incomes_array[k][1] += parseInt(parseInt(Inc_Value)/(12 / M_Y));

                            }
                            
                        }
                    }
                    if(income_ex_flag == 0){    //若不存在則新增
                            
                            if(Inc_Cycle == "月收"){
                                incomes_array.push([Inc_Title, parseInt(Inc_Value*M_Y)]);

                            }else{
                                incomes_array.push([Inc_Title, parseInt(parseInt(Inc_Value)/(12 / M_Y))]);

                            }
                    }
                }
                //console.log(incomes_array);
                if(Income_Sal > 0){
                    //console.log(incomes_array['薪資']);
                    if (Income_Sal < monthly_minimum_wage*12){
                        for(k=0;k<incomes_array.length;k++){
                            if(incomes_array[k][0]=='薪資'){
                                incomes_array[k][1] += monthly_minimum_wage*12 - Income_Sal;
                            }
                        }
                    }
                }

            }else if (arr1[0] == '3' || title == "役男"){    //-------------------役男&依實際所得-----------------------------------------------------------------------------------------    
                //console.log(arr1[0]);
                
                for(j=0;j<$(Income_Div).length;j++){
                    var Inc_Title = $(Income_Div).eq(j).find(".proper-inc-div-1 option:selected").text();
                    var Inc_Value = $(Income_Div).eq(j).find(".proper-inc-div-2").val();
                    var Inc_Cycle = $(Income_Div).eq(j).find(".proper-inc-div-4 option:selected").text();
                    var income_ex_flag = 0;
                    for(k=0;k<incomes_array.length;k++){
                        if(incomes_array[k][0] == Inc_Title){
                            income_ex_flag = 1;
                            if(Inc_Cycle == "月收"){
                                incomes_array[k][1] += parseInt(Inc_Value*M_Y);
                            }else{
                                incomes_array[k][1] += parseInt(parseInt(Inc_Value)/(12 / M_Y));
                            }
                        }
                    }
                    if(income_ex_flag == 0){
                            if(Inc_Cycle == "月收"){
                                incomes_array.push([Inc_Title, parseInt(Inc_Value*M_Y)]);
                            }else{
                                incomes_array.push([Inc_Title, parseInt(parseInt(Inc_Value)/(12 / M_Y))]);
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
            outs += '<div class="total-count-left-lc">' + incomes_array[i][0] + '</div><div class="total-count-left-rc">' + numberWithCommas(incomes_array[i][1]) + '</div>';
            sum +=  parseInt(incomes_array[i][1]);
            if(incomes_array[i][0]=="薪資"){
                $("#PH-Salary").text(numberWithCommas(incomes_array[i][1]));
            }
            if(incomes_array[i][0]=="股票配息"){
                $("#PH-Stock-int").text(numberWithCommas(incomes_array[i][1]));
            }
            if(incomes_array[i][0]=="營利"){
                $("#PH-Profit").text(numberWithCommas(incomes_array[i][1]));
            }
            if(incomes_array[i][0]=="存款利息"){
                $("#PH-Bank-int").text(numberWithCommas(incomes_array[i][1]));
            }
            if(incomes_array[i][0]=="其他"){
                $("#PH-others-int").text(numberWithCommas(incomes_array[i][1]));
            }
        }
        $("#PH-Property-int").text("0");
        $(".TC-L-D2").append(outs);
        $(".TC-L-D2-sum").text(numberWithCommas(sum));
        $("#PH-total-inc").text(numberWithCommas(sum));
        var Thonscomm = $(".TC-L-D1-lastincome").text();
        var TInt = Thonscomm.replace(/,/g , "");
        // console.log("TintO:" + TInt);
        // console.log("Tint:"+parseInt(TInt));
        // console.log("sum:"+sum);
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
        //$(".TC-L-D2-percent").css('color', 'gray');
        $(".TC-L-D2-percent").removeClass('waring');
        $("#PH-level").text(lavel + listpeople + "口");
        if(result>100){
            $("#LP-result").text("資格不符");
            $("#PH-level").text("資格不符");
            //$(".TC-L-D2-percent").css('color', 'red');
            $(".TC-L-D2-percent").addClass('waring');
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
        var imm_area_array = []    //縣市
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
                  
                //var area = $(GDIV).eq(i).find(".member_area").attr('area-index');   //2016-12-25捕捉縣市區域用的ARRAY，目前是用人來抓，準備改成用房屋土地來抓

                //imm_area_array.push(Property_limit[area][3]);       //2016-12-25捕捉縣市區域用的ARRAY，目前是用人來抓，準備改成用房屋土地來抓




                //Property_limit.getImmLimitbyName("臺中市")

                for(j=0;j<$(Property_Div).length;j++){  
                    //var income_ex_flag = 0;
                    var Property_type = $(Property_Div).eq(j).find(".proper-inc-div-1 option:selected").text();

                    //if( Property_type == "儲蓄存款" || Property_type == "有價證券" ||  Property_type == "投資" ||  Property_type == "其他"){
                    if( Property_type == "儲蓄存款"){
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


                            //改成要計算房屋的位置
                            // console.log((Property_Div).eq(j).find(".proper-inc-div-6").val());
                            // console.log(Property_limit.getImmLimitbyName((Property_Div).eq(j).find(".proper-inc-div-6").val()));
                            imm_area_array.push(Property_limit.getImmLimitbyName((Property_Div).eq(j).find(".proper-inc-div-6").val())); 
                            



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

                            //改成要計算房屋的位置
                            // console.log((Property_Div).eq(j).find(".proper-inc-div-6").val());
                            // console.log(Property_limit.getImmLimitbyName((Property_Div).eq(j).find(".proper-inc-div-6").val()));
                            imm_area_array.push(Property_limit.getImmLimitbyName((Property_Div).eq(j).find(".proper-inc-div-6").val())); 

                            
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
        property_move_limit = property_move_limit_base + (total_members_count ) * property_move_limit_single; //動產限額
        property_imm_limit = imm_area_array.min();
        //console.log(property_imm_limit);
        if(!isFinite(property_imm_limit)){   //抓不到的話，就用役男的戶籍地
            var area = $(GDIV).eq(0).find(".member_area").attr('area-index');   //2016-12-25捕捉縣市區域用的ARRAY，目前是用人來抓，準備改成用房屋土地來抓
            property_imm_limit = Property_limit[area][3]; 
            //console.log("抓到啥?");
        }
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
         $("#total_property_move").text(numberWithCommas(total_property_move));
         $("#PH-total-pro").text(total_property_move);
         //console.log("不動產總額："+total_property_imm);
         //console.log("不動產列計總額："+total_property_imm_count);
         $("#total_property_imm_count").text(numberWithCommas(total_property_imm_count));
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
        $("#property_move_limit").text(numberWithCommas(property_move_limit));
        //console.log("不動產限額："+property_imm_limit);
        $("#property_imm_limit").text(numberWithCommas(property_imm_limit));
        
        if(property_move_limit < total_property_move) {
            //$("#property_move_limit").css('color', 'red');
            $("#property_move_limit").addClass('waring');
            $("#LP-result").text("資格不符");
            $("#PH-level").text("資格不符");
        }
        else{
            //$("#property_move_limit").css('color', 'gray');
            $("#property_move_limit").removeClass('waring');
        }

        if(property_imm_limit < total_property_imm_count) {
            //$("#property_imm_limit").css('color', 'red');
            $("#property_imm_limit").addClass('waring');
            $("#LP-result").text("資格不符");
            $("#PH-level").text("資格不符");
        }
        else{
            //$("#property_imm_limit").css('color', 'gray');
            $("#property_imm_limit").removeClass('waring');

        }


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
        $('.right-total-count').fadeOut('slow');
    });

    //中面板-成員面板被點擊時，加上被選擇狀態，且更新右側詳細資料面板
    $('.center-total-count').on('click', '.group-div', function(event) {
        if($(this).is(".add-new-button")){return;}
        $('.group-div.selected').removeClass('selected');
        $(this).addClass('selected');
        right_total_count_redraw();
        $(".right-total-count").fadeIn();
    });

    //中面板-選定中間成員後，重繪整個右方4大區塊
    function right_total_count_redraw(){
        //----------------------------若是役男，要提醒不要把服役薪資列計--------------------------
        //console.log($('.group-div.selected .people-title input').val());
        if($('.group-div.selected .people-title input').val() == "役男"){
            $(".miliboy-add-new-inc-comm").addClass('in');
        }else{
            $(".miliboy-add-new-inc-comm").removeClass('in');
        }
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
        $("#right_tab_membercomm  textarea").val($('.group-div.selected').find(".comm-cont").val());
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
        //console.log($(this).attr("value"));
        var PRO_DIV = property_template();
        $(PRO_DIV).appendTo('#right_tab_property .pro-div-cont');
        var area = $(".center-total-count .group-div").eq(0).find(".member_area").val();
        var new_pro = $('#right_tab_property .pro-div-cont .proper-inc-div').last();
        $(new_pro).find('.proper-inc-div-6').val(area).trigger('change');
        $(new_pro).find('.proper-inc-div-1').val($(this).attr("value")).trigger('change');
        $("#right_tab_property > div").animate({scrollTop:$("#right_tab_property > div").scrollTop()+170}, '500', 'swing');
    });

    //右面板.財產.自動帶入按鈕點擊事件
    $("#right_tab_property").on('click', '.auto-proper', function(event) {
        $(".group-div.selected .income-cont .proper-inc-div").each(function(index, el) {
              var type = $(this).children('.proper-inc-div-1').val();
              if( type == "Stock-int" || type == "Bank-int" ){   //Securities    Deposits
                if (type == "Stock-int"){
                    var type2 = "Securities";
                    var value = Math.floor($(this).children('.proper-inc-div-2').val() / $(this).children('.proper-inc-div-7').val() * 10);

                } 
                if (type == "Bank-int"){
                    var type2 = "Deposits";
                    var value = Math.floor($(this).children('.proper-inc-div-2').val() / $(this).children('.proper-inc-div-7').val());

                } 
                
                 //若是財產中有股票/銀行利息者
                 //存款 = 年入金額 / 息率
                 //股票 = 年入金額 / 息率 * 10
                 //prepend() 和 prependTo()   從上方插入
                
                var PRO_DIV = property_template();
                $(PRO_DIV).prependTo('#right_tab_property .pro-div-cont');
                var area = $(".center-total-count .group-div").eq(0).find(".member_area").val();
                var new_pro = $('#right_tab_property .pro-div-cont .proper-inc-div').eq(0);
                $(new_pro).addClass('Pdiv-Strong');
                $(new_pro).find('.proper-inc-div-6').val(area).trigger('change');
                $(new_pro).find('.proper-inc-div-1').val(type2).trigger('change');
                $(new_pro).find('.proper-inc-div-2').val(value).trigger('change');
                $(new_pro).find('.proper-inc-div-3').val($(this).children('.proper-inc-div-3').val()).trigger('change');
                $(new_pro).find('.proper-inc-div-5').val("自動逆算產生").trigger('change');
                
              }
        }).delay(2000,function(){$(".Pdiv-Strong").removeClass('Pdiv-Strong');});
        //這寫法有點問題，等於each的每個物件都會去呼叫一次
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
                    // $(this).parent().find(".proper-inc-div-6").fadeIn();         //fadein fadeout 是改變透明度，有動畫過程，導致瞬間寫回去的時候，都還是0而消失
                    // $(this).parent().children(".proper-inc-div-4").fadeIn();     //
                    $(this).parent().find(".proper-inc-div-6").addClass('in').removeClass('display-none');
                    $(this).parent().children(".proper-inc-div-4").addClass('in').removeClass('display-none');
                }else{
                    $(this).parent().find(".proper-inc-div-6").removeClass('in').addClass('display-none');
                    $(this).parent().children(".proper-inc-div-4").removeClass('in').addClass('display-none');
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
    $("#right_tab_income").on('click', '.add-inc', function(event) {
        var INC_DIV = income_template();
        $(INC_DIV).appendTo('#right_tab_income .inc-div-cont');

        //     var area = $(".center-total-count .group-div").eq(0).find(".member_area").val();
        var new_pro = $('#right_tab_income .inc-div-cont .proper-inc-div').last();
        //     $(new_pro).find('.proper-inc-div-6').val(area).trigger('change');
        $(new_pro).find('.proper-inc-div-1').val($(this).attr("value")).trigger('change');
        if($(this).text()=="＋基本薪資"){  
            $(new_pro).find('.proper-inc-div-5').val("無薪資證明，依"+This_Year+"年度基本工資計算");
            $(new_pro).find('.proper-inc-div-4').val("m").trigger('change');
            $(new_pro).find('.proper-inc-div-2').val(monthly_minimum_wage).trigger('change');
        }
        if($(this).text()=="＋職類別薪資"){  
            $(new_pro).find('.proper-inc-div-5').val("依105年勞動部職類別薪資調查報告-...(後續請依需要自填)").addClass('worker');
            $(new_pro).find('.proper-inc-div-4').val("m").trigger('change');
            $(new_pro).find('.proper-inc-div-2').val("").trigger('change');
        }//＋職類別薪資
        if($(this).text()=="＋執行業務"){  
            $(new_pro).find('.proper-inc-div-5').val("執行業務所得").addClass('worker');
            $(new_pro).find('.proper-inc-div-4').val("y").trigger('change');
            $(new_pro).find('.proper-inc-div-2').val("").trigger('change');
            $(new_pro).find('.proper-inc-div-7').addClass('display-none');
        }//＋職類別薪資




        $("#right_tab_income > div").animate({scrollTop:$("#right_tab_income > div").scrollTop()+170}, '500', 'swing');
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

    //所得種類切換
    $('.right-total-count').on('change', '#right_tab_income .proper-inc-div-1', function(event) {
        //console.log("抓到");
        //console.log($(this).children("option:selected").text());
        var Pan_div = $(this).parents('.proper-inc-div').eq(0);
        var Sel_Val = $(this).children("option:selected").text();
        if(Sel_Val == '薪資' || Sel_Val == '營利'){
            //console.log("進入薪資");
            Pan_div.find('.proper-inc-div-5').addClass('Salary');
            Pan_div.find('.proper-inc-div-7').addClass('display-none');
        }else{
            Pan_div.find('.proper-inc-div-5').removeClass('Salary').removeClass('worker');
            Pan_div.find('.proper-inc-div-7').removeClass('display-none');
            //display-none
        }
        //var P_Spec  = $(this).parents('.people-special').children('span').eq(0);
        //var PJob    = Pan_div.find('.people-job input');
    });

    //右面板.所得.輸入欄位有變動觸發，立即寫回成員隱藏面板，並更新此家屬所得總額(轉換為月收入)
    $('.right-total-count').on('change', '#right_tab_income .proper-inc-div input, #right_tab_income .proper-inc-div select', function(event) {
        if ($(this).is('select')){
            $(this).find("option[selected]").removeAttr('selected');
            $(this).find("option:selected").attr('selected','selected');

            if($(this).children("option:selected").text() == '股票配息' || $(this).children("option:selected").text() == '存款利息'){
                $(this).parent().find(".proper-inc-div-4").val("y");
                $(this).parent().find(".proper-inc-div-7").addClass('in');
                if($(this).children("option:selected").text() == '存款利息'){
                    $(this).parent().find(".proper-inc-div-7").val(bank_interest_rate); 
                }else{
                    $(this).parent().find(".proper-inc-div-7").val("");
                }
            }else{
                if($(this).hasClass('proper-inc-div-1')){
                   $(this).parent().find(".proper-inc-div-7").removeClass('in'); 
                }
            }
        }
        if($(this).is(".proper-inc-div-3") && $(this).parent().find(".proper-inc-div-1").children("option:selected").text() == '股票配息'){
            $('#Law_4').modal('toggle');
            //Stock_table.search($(this).val()).draw() ;
            $("#Stock_table_filter > label > input").val($(this).val()).trigger('keyup');
        }
        //複製回成員隱藏面板
        var MDIV = $(".group-div.selected").eq(0);


        // var Special = $(".group-div.selected").find(".people-special .people-input-left").val();
        // var arr1= Special.split(',');

        var IGContiv = $(MDIV).find('.income-cont').eq(0);
        $(IGContiv).empty();
        $("#right_tab_income .inc-div-cont > div").clone().appendTo($(IGContiv));
        //更新成員面板所得月薪
        // var IGCD = $(IGContiv).children('div');
        // var Inc_Title   =  "";
        // var Inc_Value   =  "";
        // var Inc_from    =  "";
        // var Inc_Cycle   =  "";
        // var Income = 0;
        // var Income_Sal = 0;
        // var Income_NonSal = 0;

        // if (arr1[0] == '0' ){
        //     console.log("身分0");
        //     for (i=0;i<IGCD.length;i++){
        //         Inc_Title   =   $(IGCD).eq(i).find(".proper-inc-div-1 option:selected").text();
        //         Inc_Value   =   $(IGCD).eq(i).find(".proper-inc-div-2").val();
        //         Inc_from    =   $(IGCD).eq(i).find(".proper-inc-div-3").val();
        //         Inc_Cycle   =   $(IGCD).eq(i).find(".proper-inc-div-4 option:selected").text();
        //         if(Inc_Title == "薪資"){
        //             if(Inc_Cycle == "年收"){
        //                 Income_Sal += parseInt(Inc_Value)/(12/M_Y);
        //             }else{
        //                 Income_Sal += parseInt(Inc_Value)*M_Y;
        //             }
        //         }else{
        //             if(Inc_Cycle == "年收"){
        //                 Income_NonSal += parseInt(Inc_Value)/(12/M_Y);
        //             }else{
        //                 Income_NonSal += parseInt(Inc_Value)*M_Y;
        //             }
        //         }
        //         console.log(Inc_Title);
        //         console.log(Inc_Value);
        //         console.log(Inc_from);
        //         console.log(Inc_Cycle);
        //     }
        //     Income_Sal = (Income_Sal <= monthly_minimum_wage*12)?monthly_minimum_wage*12:Income_Sal;
        //     Income = Income_Sal + Income_NonSal;

        // }else{

        //     for (i=0;i<IGCD.length;i++){
        //         Inc_Title   =   $(IGCD).eq(i).find(".proper-inc-div-1 option:selected").text();
        //         Inc_Value   =   $(IGCD).eq(i).find(".proper-inc-div-2").val();
        //         Inc_from    =   $(IGCD).eq(i).find(".proper-inc-div-3").val();
        //         Inc_Cycle   =   $(IGCD).eq(i).find(".proper-inc-div-4 option:selected").text();
        //         if(Inc_Cycle == "年收"){
        //             Income += parseInt(Inc_Value)/(12/M_Y);
        //         }else{
        //             Income += parseInt(Inc_Value)*M_Y;
        //         }
        //         console.log(Inc_Title);
        //         console.log(Inc_Value);
        //         console.log(Inc_from);
        //         console.log(Inc_Cycle);
        //     }
        // }



        // Income = parseInt(Income);
        // console.log(Income);
        // $(".group-div.selected").find('.people-income-total-value').html(numberWithCommas(Income) + '<img class="svg social-link NTD" src="/0MS/images/NTD.svg">');
        // svg_redraw();
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
        job = job?job:'無業';
        var income = $.trim($(".group-div.selected .people-income-total-value").text());
        income = (income === '0')?'查無所得資料':'全年所得：$'+numberWithCommas(income);
        var special = $(".group-div.selected .people-special select option:selected").val();
        var status = $(".group-div.selected .people-special select option:selected").text();
        var status_result =  $(".group-div.selected .people-special span").text();
        var special_txt = '';
        var description = '';
        if(status_result == "實際所得"){
            status_result = "依實際所得計算";
        }
        var minimum_wage = "";
        if ($(".group-div.selected > div.income-total > div.people-income-total-value > span") && $(".group-div.selected > div.income-total > div.people-income-total-value > span").length ) {
            minimum_wage = "(其薪資部分未達每月最低工資標準故依每月最低薪資所得：$"+numberWithCommas(monthly_minimum_wage)+"計算) ";
        }
        switch(special){
            case '1,15':
                description = title+'：'+name+'，歿。';
                break;
            case '0,0':
            case '0,2':
                description = title+'：'+name+'，'+age+'歲，'+job+'，'+income+'。'+minimum_wage;                
                break;
            default:
                special_txt = '，因其為'+status+'，故'+status_result+'。';
                description = title+'：'+name+'，'+age+'歲，'+job+'，'+income+special_txt;      
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
        real_estate = (real_estate ==='')?'':'\n名下有不動產：'+real_estate+'列計總額共 $'+numberWithCommas(house_land_value)+'元整。';
        
        var movable = (saving_count>0)?'儲蓄存款 '+saving_count+'筆；':'';
        movable += (security_count>0)?'有價證券 '+security_count+'筆；':'';
        movable += (investment_count>0)?'投資 '+investment_count+'筆；':'';
        movable += (others_count>0)?'其他 '+others_count+'筆；':'';
        movable = (movable === '')?'':'\n名下有動產：'+movable+'共 $'+numberWithCommas(movable_value)+'元整。';
        description = description + real_estate + movable;

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
    
    // window.onload = function(){
    //     var ctx = document.getElementById("chart-area").getContext("2d");
    //     new Chart(ctx, {
    //         type: "bar",
    //         data: data,
    //         // Boolean - whether or not the chart should be responsive and resize when the browser does.
    //         responsive: true,
    //         // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    //         maintainAspectRatio: false,
    //         options: {
    //             scales: {
    //                 xAxes: [{
    //                     stacked: true
    //                 }],
    //                 yAxes: [{
    //                     stacked: true
    //                 }]
    //             }
    //         }
    //     });
    // };

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
        var Pan_div = $(this).parents('.group-div').eq(0);
        var P_Spec  = $(this).parents('.people-special').children('span').eq(0);
        var PJob    = Pan_div.find('.people-job input');

        var arr = $(this).val();
        //console.log(arr.split());
        var arr1= arr.split(',');
        // console.log(arr1);
        // console.log(arr1[0]);
        if (arr1[0] == 0){
            P_Spec.text('一般');
        }else if(arr1[0] == 1){
            P_Spec.text('不列口數');
        }else if(arr1[0] == 2){
            P_Spec.text('不計收入');
        }else if(arr1[0] == 3){
            P_Spec.text('實際所得');
        }

        var Title = Pan_div.find('.people-title .people-input-center').val();
        var female = Title.match(/母|姨|姑|嬸|嫂|姊|妹|姐|配|妻|娘|婆/g);
        var student_g = '<img id="Picon-man" class="svg social-link svg-people" src="/0MS/images/people/custom/female-graduate-student.svg">';
        var student_b = '<img id="Picon-man" class="svg social-link svg-people" src="/0MS/images/people/custom/graduate-student-avatar.svg">';
        var woman = '<img id="Picon-man" class="svg social-link svg-people" src="/0MS/images/people/custom/woman-avatar.svg">';
        var man = '<img id="Picon-man" class="svg social-link svg-people" src="/0MS/images/people/custom/man-avatar.svg">';
        var captain = '<img id="Picon-man" class="svg social-link svg-people" src="/0MS/images/people/custom/captain.svg">';
        Pan_div.find('.svg-people').remove();
        if(arr1[1] == 33 || arr1[1] == 4){  //是否學生
            if(female != null){ //女或男
                $(student_g).appendTo(Pan_div);
            }else{
                $(student_b).appendTo(Pan_div);
            }
            PJob.val("學生"); 
            svg_redraw();
        }
        else{
           if(female != null){ //女或男
                $(woman).appendTo(Pan_div);
            }else{//是否役男
                if(arr1[1] == 1){
                    $(captain).appendTo(Pan_div);
                }else{
                    $(man).appendTo(Pan_div); 
                }
            }
            PJob.val("");  
        }
        svg_redraw();
        recount_member_inc(Pan_div);
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
        var female = Title.match(/母|姨|姑|嬸|嫂|姊|妹|姐|配|妻|娘|婆/g);
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
        
        
        var GROUP_DIV = member_template($("#PH-fulladdress").text());
        $(GROUP_DIV).insertBefore($(this).parent());
        svg_redraw();
        var index_g = $(".group-div").length - 2;
        $(".group-div").eq(index_g).find('.people-id-address input').trigger('change');
        $(".group-div").eq(index_g).find('.people-title > input').val($(this).attr("value")).trigger('change');
        $(".center-total-count > div").animate({scrollTop:$(".center-total-count > div").scrollTop()+270}, '500', 'swing').delay(300, members_must_input_check());
        
    });

    //中面板.家屬.生日改變：計算其歲數
    $('.center-total-count').on('change', '.birthday', function(event) {
        var dateString = parseInt(NTW($(this).val()));
        dateString = dateString.toString();
        if(dateString.length == 6){ dateString = "0" + dateString;}
        var YYY = dateString.substring(0, 3);
        var MM  = dateString.substring(3, 5);
        var DD  = dateString.substring(5, 7);
        var YYYMMDD = YYY + "年" + MM + "月" + DD + "日";
        $(this).val(YYYMMDD);

        var YYYY = parseInt(YYY) + 1911;
        var YYYYMMDD = "" + YYYY + "-" + MM + "-" + DD +"";

        if (Date.parse(YYYYMMDD)) {
           //console.log(YYYYMMDD);
           $(this).removeClass('EmptyWar');
        }
        else {
           console.log("非有效日期");
           $(this).addClass('EmptyWar');
        }             

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

    //中面板.家屬.選擇生日：把值換回7碼
    $('.center-total-count').on('focus', '.birthday', function(event) {
        //console.log("選擇生日");
        if($(this).val()!=""){
            $(this).val(date_to_yyy($(this).attr("yyyymmdd")));
        }
    });

    $('.center-total-count').on('blur', '.birthday', function(event) {
        //console.log("選擇生日");
        if($(this).val()!=""){
            if($(this).attr("yyyymmdd") == yyy_to_date($(this).val()) ){
                $(this).trigger('change');
            }
            
        }
    });

    //稱謂、姓名、生日有改變時觸發
    $('.center-total-count').on('change', '.people-title>input, .people-name>input, .people-birthday>input', function(event) {
        members_must_input_check();
    });

    //家屬身分證字號改變時觸發
    $('.center-total-count').on('change', '.people-id>input', function(event) {
        //setTimeout(function(){ 
            value = NTW(this.value);
            if(value != ""){
                if(TW_PersonalCodeCheck(value)){
                    $(this).removeClass('EmptyWar');
                }else{
                    $(this).addClass('EmptyWar');
                }
            }else{
                $(this).removeClass('EmptyWar');
            }
        //}, 500);
    });




    
    //****************************************
    $("a[href='#filelist-navcon']").click(function(event) {
        CWait_Start();
        event.preventDefault();
        event.stopPropagation();
        $('[data-toggle="dropdown"]').parent().removeClass('open');
        read_file_list_pending();
    });


    
});


