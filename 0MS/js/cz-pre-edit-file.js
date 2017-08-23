//區域,年度,最低生活費,不動產限額
var Property_limit =[
	["臺北市",106,15544,7400000],
	["新北市",106,13700,3620000],
	["桃園市",106,13692,3600000],
	["臺中市",106,13084,3520000],
	["臺南市",106,11448,3500000],
	["高雄市",106,12941,3530000],
	["基隆市",106,11448,3500000],
	["新竹縣",106,11448,3500000],
	["苗栗縣",106,11448,3500000],
	["彰化縣",106,11448,3500000],
	["雲林縣",106,11448,3500000],
	["嘉義縣",106,11448,3500000],
	["屏東縣",106,11448,3500000],
	["宜蘭縣",106,11448,3500000],
	["花蓮縣",106,11448,3500000],
	["臺東縣",106,11448,3500000],
	["金門縣",106,10290,2700000],
	["連江縣",106,10290,2700000]
];

Property_limit.getIndexbyName = function(){
}

Property_limit.getImmLimitbyName = function(area_string){
    //為了相容於舊版JS引擎，參數預設值改成在內部定義
    area_string = typeof area_string !== 'undefined' ? area_string : "";
    //....................................
    var result = 9999999999999;     //抓不到回傳值，就給一個超大值(爆掉)
    $.each(this, function(index, area) {
        if(area[0] == area_string){
            result = area[3];
        }
    });
    return result;    
}
//今年
var This_Year = 106;
//銀行定存利率(用於反算存款)
//var bank_interest_rate = 0.01355; //105年
var bank_interest_rate = 0.0107; //106年

//最低月薪所得(106年7月)
var monthly_minimum_wage = 21009;

//property_move_limit = property_move_limit_base + (total_members_count) * property_move_limit_single; 
//動產限額公式，含役男本身從250萬開始，多一個家屬多25萬。
var property_move_limit_base = 2500000;

var property_move_limit_single = 250000;

//不同案件要呼叫不同年份的規定
function update_calc_setting_by_year(year_in, file_key){
    //為了相容於舊版JS引擎，參數預設值改成在內部定義
    year_in = typeof year_in !== 'undefined' ? year_in : This_Year;
    //console.log(year_in, file_key);
    $.ajax({
        url: '/file/get_calc_setting_by_year',
        type: 'post',
        dataType: 'json',
        data: {
            year: year_in
        },
    })
    .done(function(responsive_) {
        //console.log(responsive_);
        var LowIncome = responsive_['LowIncome'];
        var BankRate = responsive_['BankRate'];
        var MProperty = responsive_['MProperty'];

        bank_interest_rate = parseFloat(BankRate[0].利率);
        property_move_limit_base = parseInt(MProperty[0].起算額);
        property_move_limit_single = parseInt(MProperty[0].每人增加額);
        for(i=0;i<LowIncome.length;i++){
            Property_limit[i] = LowIncome[i];
            if(i == LowIncome.length - 1){
                //run原本的讀取檔案
                read_file_test_1(file_key);
            }
        }
    })
    .fail(function() {
        //console.log("error-update_calc_setting_by_year");
    });
}

//點擊編輯之後的處理，先讀取該案件的所屬年分，然後讀取該年分設定檔，讀取完再讀取檔案

function read_file_new(file_key){
    update_calc_setting_by_year(This_Year,file_key);
}

function read_file_test(file_key,e){
    var thisdate = $(e).parents('tr').find('td').eq(6).text();
    var a = thisdate.split("-");
    $("#reload_file_button").attr('onclick', 'reload_file('+a[0]+')');
    update_calc_setting_by_year(a[0],file_key);
}



//
function read_file_test_1(file_key){
    empty_members();
    $("#PH-file_comm_1").val("");
    $("#PH-file_comm_2").val("");
    $('.right-total-count').hide();//隱藏右面板
    CWait_Start();
    $.ajax({
        url: '/family/get_members_file',
        type: 'post',
        dataType: 'json',
        data: {
            file_key        : file_key,
        },
    })
    .done(function(responsive) {
        //console.log("success");
        update_Access_Print_botton(file_key);
        count = responsive.members.length;
        zero_member_bug = 0;
        console.log(count);
        if (count == 0){
            zero_member_bug = 1;
        }
        $.each(responsive.members, function(index, member) {
            var GROUP_DIV = rf_member(member);
            $(GROUP_DIV).insertBefore($(".group-div.add-new-button"));
            svg_redraw();
            var this_index = $(".group-div").length - 2 ;
            var MDIV = $(".group-div").eq(this_index);
            $(MDIV).find('.people-special select').val(member.specials).trigger('change');
            $(MDIV).find('.people-birthday input').trigger('change');
            $(MDIV).find('.people-marriage input').trigger('change');
            $(MDIV).find('.people-marriage2 input').trigger('change');
            recount_member_pro($(MDIV));
            recount_member_inc($(MDIV));
            if (!--count){
                setTimeout(function(){
                    $('#Add_file').modal('hide');
                    $("#family-edit-nav").fadeIn('400');
                    if(responsive.members.length <= 1){
                        $("#family-edit-nav > ul > li:nth-child(2) > a").tab('show');
                    }else{
                        $("#family-edit-nav > ul > li:nth-child(1) > a").tab('show');
                    }
                    $("#edit-navcon > div.center-total-count > div > div.group-div").first().find("button.close").remove();
                    CWait_End();
                },300);
            }

        });
        rf_file_info(responsive.file_info);
        if (zero_member_bug){
            setTimeout(function(){
                add_miliboy();  //Fmenu中停用的功能，改用於此
                $('#Add_file').modal('hide');
                $("#family-edit-nav").fadeIn('400');
                $("#family-edit-nav > ul > li:nth-child(2) > a").tab('show');
                $("#edit-navcon > div.center-total-count > div > div.group-div").first().find("button.close").remove();
                CWait_End();
            },300);
        }
    })
    .fail(function() {
        console.log("error");
    });
}

//更新列按按鈕的指向
function update_Access_Print_botton(file_key){

    $("#Access_Print_botton").attr('href', '/Report/Access_Print_Form/'+file_key);
}

//讀取案件整體資訊
function rf_file_info(responsive){
    //console.log(responsive);
    $("#PH-filetype").text(responsive['作業類別名稱']);
    $("#PH-name").text(responsive['役男姓名']);
    $("#PH-code").text(responsive['身分證字號']);
    $("#PH-birthday").text(yyy_dash(date_to_yyy(responsive['役男生日'])));
    $("#PH-milidate").text(yyy_dash(date_to_yyy(responsive['入伍日期'])));
    $("#PH-type").text(responsive['服役軍種']);
    $("#PH-status").text(responsive['服役狀態']);

    $("#PH-echelon").text(responsive['梯次']);
    $("#PH-phone").text(responsive['聯絡電話1']);
    $("#PH-email").text(responsive['email']);


    $("#PH-fulladdress").text(responsive['County_name']+responsive['Town_name']+responsive['Village_name']+responsive['戶籍地址']);
    
    $("#PH-members").text(responsive['總列計人口']);
    $("#PH-need").text(numberWithCommas(responsive['月所需']));


    $("#PH-Deposits").text(numberWithCommas(responsive['存款本金總額']));
    $("#PH-Investment").text(numberWithCommas(responsive['投資總額']));
    $("#PH-Securities").text(numberWithCommas(responsive['有價證券總額']));
    $("#PH-others-Pro").text(numberWithCommas(responsive['其他動產總額']));
    $("#PH-total-pro").text(numberWithCommas(responsive['總動產']));

    $("#PH-Salary").text(numberWithCommas(responsive['薪資月所得']));
    $("#PH-Profit").text(numberWithCommas(responsive['營利月所得']));
    $("#PH-Property-int").text(numberWithCommas(responsive['財產月所得']));
    $("#PH-Bank-int").text(numberWithCommas(responsive['利息月所得']));
    $("#PH-Stock-int").text(numberWithCommas(responsive['股利月所得']));
    $("#PH-others-int").text(numberWithCommas(responsive['其他月所得']));
    $("#PH-total-inc").text(numberWithCommas(responsive['月總所得']));
    
    $("#PH-Houses").text(numberWithCommas(responsive['房屋棟數']));
    $("#PH-Houses-total").text(numberWithCommas(responsive['房屋總價']));
    $("#PH-Houses-num").text(numberWithCommas(responsive['房屋列計棟數']));
    $("#PH-Houses-listtotal").text(numberWithCommas(responsive['房屋列計總價']));
    $("#PH-Land").text(numberWithCommas(responsive['土地筆數']));
    $("#PH-Land-total").text(numberWithCommas(responsive['土地總價']));
    $("#PH-Land-num").text(numberWithCommas(responsive['土地列計筆數']));
    $("#PH-Land-listtotal").text(numberWithCommas(responsive['土地列計總價']));
    $("#PH-total-imm").text(numberWithCommas(responsive['不動產列計總額']));
    $("#PH-file_comm_1").val("");
    $("#PH-file_comm_2").val("");
    $("#PH-file_comm_1").val(responsive['整體家況敘述-公所']);
    $("#PH-file_comm_2").val(responsive['整體家況敘述-局處']);

    $("#attach_0").text(responsive['attach_household']);
    $("#attach_1").text(responsive['attach_income']);
    $("#attach_2").text(responsive['attach_property']);
    $("#attach_3").text(responsive['attach_statusprove']);
    $("#attach_4").text(responsive['attach_others']);

    $("#attach_0").attr('href', '/uploads/'+responsive['attach_household']);
    $("#attach_1").attr('href', '/uploads/'+responsive['attach_income']);
    $("#attach_2").attr('href', '/uploads/'+responsive['attach_property']);
    $("#attach_3").attr('href', '/uploads/'+responsive['attach_statusprove']);
    $("#attach_4").attr('href', '/uploads/'+responsive['attach_others']);

    $(".people_home").attr('file_id', responsive['案件流水號']);
    $(".people_home").attr('boy_id', responsive['役男系統編號']);
}

//讀取家屬個資
function rf_member(member){
    //console.log(member.income)
    //console.log(member.property)
    //console.log(rf_mem_property(propertys));
    //console.log(rf_mem_income(incomes));
    DIV_propertys = rf_mem_property(member.property);
    DIV_incomes = rf_mem_income(member.income);


            // var member = {
            //     "key" : $(this).attr('code'),
            //     "edit" : $(this).attr('edit'),
            //     "title" : $(this).find('.people-title input').val(),
            //     "name" : $(this).find('.people-name input').val(),
            //     "code" : $(this).find('.people-id input').val(),
            //     "birthday" : $(this).find('.people-birthday input').attr('YYYYMMDD'),
            //     "address" : $(this).find('.people-id-address input').val(),
            //     "job" : $(this).find('.people-job input').val(),
            //     "special" : $(this).find('.people-special select').val(),
            //     "marriage" : $(this).find('.people-marriage input').val(),
            //     "marriage_ex" : $(this).find('.people-marriage2 input').val(),
            //     "area" : $(this).find('.member_area').val(),
            //     "area_key" : $(this).find('.member_area').attr('area-index'),
            //     "comm" : $(this).find('.comm-cont').val(),
            //     "income" : [],
            //     "property" : []
            // };

    //console.log(date_to_yyy(member.birthday));        
    //console.log(member.birthday);

    member_str = '' +
    '<div class="group-div" code="' + member.key + '">' +
        '<button type="button" class="close" data-toggle="modal" data-target="#confirm-delete-people" aria-label="Close" style="top: 0.2em;right: 0.2em;position: absolute;"><span aria-hidden="true">×</span></button>' +
        '<div style="width: 8em;height: 8em;"><img id="Picon-man" class="svg social-link svg-people" src="0MS/images/people/custom/man-avatar.svg" /></div>' +
        '<div class="income-total"><div>所得</div><div class="people-income-total-value">22766<img class="svg social-link NTD" src="0MS/images/NTD.svg"></div></div>' +
        '<div class="property-total"><div>財產</div><div class="people-property-total-value">19600<img class="svg social-link NTD" src="0MS/images/NTD.svg"></div></div>' +
        '<div class="people-job"><input class="people-input-left" placeholder="所得職業" value="' + member.job + '"></div>' +
        '<div class="people-title"><input class="people-input-center" value="' + member.title + '"></div>' +
        '<div class="people-name"><input class="people-input-left" value="' + member.name + '"></div>' +
        '<div class="people-id"><input class="people-input-left" placeholder="身分證字號" value="' + member.code + '"></div>' +
        '<div class="people-id-address"><input class="people-input-left" value="' + member.address + '"></div>' +
        '<div class="people-marriage"><input style="width: 5em;" class="people-input-left" placeholder="配偶姓名" value="' + member.marriage + '"></div>' +
        '<div class="people-marriage2"><input style="width: 5em;" class="people-input-left" value="" placeholder="' + member.marriage_ex + '"></div>' +
        '<div class="people-birthday"><span>生日：</span><input placeholder="7位數民國生日" class="people-input-left birthday" value="' + date_to_yyy(member.birthday) + '" >　　<span class="color-age"></span><span class="input-group-addon age-button"><span class="glyphicon glyphicon-calendar"></span></span></div>' +
        '<div class="people-special">身分：<span style="color: #a47523;">一般</span>' +
            '<div>' +
                '<select class="people-input-left">' +
                  '<option value="0,0" selected>一般</option>' +
                  '<option value="0,2">產業訓儲或第3階段替代</option>' +
                  '<option value="1,15">歿</option>' +
                  '<option value="1,1">服役中</option>' +
                  '<option value="1,3">榮民領有生活費</option>' +
                  '<option value="1,4">就學領有公費</option>' +
                  '<option value="1,5">通緝或服刑</option>' +
                  '<option value="1,6">失蹤有案</option>' +
                  '<option value="1,7">災難失蹤</option>' +
                  '<option value="1,8">政府安置</option>' +
                  '<option value="1,9">無設籍外、陸配</option>' +
                  '<option value="1,10">無扶養事實之直系尊親屬</option>' +
                  '<option value="1,11">未盡照顧職責之父母</option>' +
                  '<option value="1,12">父母離異而分離之兄弟姊妹</option>' +
                  '<option value="1,13">無國籍</option>' +
                  '<option value="1,14">不列口數：其他</option>' +
                  '<option value="3,30">55歲以上,16歲以下無收入</option>' +
                  '<option value="3,31">身心障礙、重大傷病</option>' +
                  '<option value="3,32">3個月內之重大傷病</option>' +
                  '<option value="3,33">學生</option>' +
                  '<option value="3,34">孕婦</option>' +
                  '<option value="3,35">獨自照顧直系老幼親屬</option>' +
                  '<option value="3,36">獨自照顧重大傷病親屬</option>' +
                  '<option value="3,37">依實際收入：其他</option>' +
                  '<option value="2,38">不計收入：其他</option>' +
                '</select>' +
            '</div>' +
        '</div>' +
        '<div class=hidden-info>' +
            '<input type="hidden" name="" class="member_area" value="' + member.area + '" area-index=' + member.area_key + '>' +
            DIV_incomes +
            DIV_propertys +
            // '<div class="income-cont"></div>' +
            // '<div class="property-cont"></div>' +
            '<textarea class="comm-cont">'+ member.comm +'</textarea>' +
        '</div>' +
    '</div>' ;
    return member_str;
}

//讀取各家屬財產資料
function rf_mem_property(propertys){
    //console.log(propertys);
    var property_str = '<div class="property-cont">';
    $.each(propertys, function(index, property) {
        // console.log(property);
        // console.log(property.key);
        // console.log(property.type);
        // console.log(property.value);
        // console.log(property.from);
        // console.log(property.note);
        // console.log(property.self_use);
        var D_none = "in", SD = "" , SS = "", SI = "", SH = "", SL = "", SO = "", SY = "", SM = "";
        var a0="", a1="", a2="", a3="", a4="", a5="", a6="", a7="", a8="", a9="", a10="", a11="", a12="", a13="", a14="", a15="", a16="", a17="";
        switch(property.area) {
            case "臺北市":
                a0 = "selected";
                break;
            case "新北市":
                a1 = "selected";
                break;
            case "桃園縣":
                a2 = "selected";
                break;
            case "臺中市":
                a3 = "selected";
                break;
            case "臺南市":
                a4 = "selected";
                break;
            case "高雄市":
                a5 = "selected";
                break;
            case "基隆市":
                a6 = "selected";
                break;
            case "新竹縣":
                a7 = "selected";
                break;
            case "苗栗縣":
                a8 = "selected";
                break;
            case "彰化縣":
                a9 = "selected";
                break;
            case "雲林縣":
                a10 = "selected";
                break;
            case "嘉義縣":
                a11 = "selected";
                break;
            case "屏東縣":
                a12 = "selected";
                break;
            case "宜蘭縣":
                a13 = "selected";
                break;
            case "花蓮縣":
                a14 = "selected";
                break;
            case "臺東縣":
                a15 = "selected";
                break;
            case "金門縣":
                a16 = "selected";
                break;
            case "連江縣":
                a17 = "selected";
                break;
            default: 
        }

        if (property.type != "房屋" && property.type != "土地"){
            D_none = '';
        }
        if(property.type == "儲蓄存款"){ SD = 'selected="selected"'; };
        if(property.type == "有價證券"){ SS = 'selected="selected"'; };
        if(property.type == "投資"){ SI = 'selected="selected"'; };
        if(property.type == "房屋"){ SH = 'selected="selected"'; };
        if(property.type == "土地"){ SL = 'selected="selected"'; };
        if(property.type == "其他"){ SO = 'selected="selected"'; };
        if(property.self_use == "m"){ SM = 'selected="selected"'; };
        if(property.self_use == "y"){ SY = 'selected="selected"'; };
        property_str += '<div class="proper-inc-div" code="'+ property.key +'" edit="new"><button type="button" class="close" data-toggle="modal" data-target="#confirm-delete-pro" aria-label="Close" style="top: 0.2em;right: 0.2em;position: absolute;"><span aria-hidden="true">×</span></button>' +
                         '<select class="proper-inc-div-1">' + 
                             '<option value="Deposits" '+ SD +'>儲蓄存款</option>' +
                            '<option value="Securities" '+ SS +'>有價證券</option>' +
                            '<option value="Investment" '+ SI +'>投資</option>' +
                            '<option value="Houses" '+ SH +'>房屋</option>' +
                            '<option value="Land" '+ SL +'>土地</option>' +
                            '<option value="others" '+ SO +'>其他</option>' +
                        '</select>' +
                        '<input placeholder="價值" class="people-input-right proper-inc-div-2" value="'+ property.value +'">' +
                        '<input placeholder="地址/地號/銀行/公司" class="people-input-left proper-inc-div-3" value="'+ property.from +'">' +
                        '<input placeholder="備註欄" class="people-input-left proper-inc-div-5" value="'+ property.note +'">' +
                        '<select class="proper-inc-div-4 fade '+ D_none +'" >' +
                            '<option value="m" '+ SM +'>自住</option>' +
                            '<option value="y" '+ SY +'>非自住</option></select>' +
                        '<select class="proper-inc-div-6 fade '+ D_none +'" >' +
                            '<option value="">縣市</option>' +
                            '<option value="臺北市"    '+ a0 +'>臺北市</option>' +
                            '<option value="新北市"    '+ a1 +'>新北市</option>' +
                            '<option value="桃園縣"    '+ a2 +'>桃園縣</option>' +
                            '<option value="臺中市"    '+ a3 +'>臺中市</option>' +
                            '<option value="臺南市"    '+ a4 +'>臺南市</option>' +
                            '<option value="高雄市"    '+ a5 +'>高雄市</option>' +
                            '<option value="基隆市"    '+ a6 +'>基隆市</option>' +
                            '<option value="新竹縣"    '+ a7 +'>新竹縣</option>' +
                            '<option value="苗栗縣"    '+ a8 +'>苗栗縣</option>' +
                            '<option value="彰化縣"    '+ a9 +'>彰化縣</option>' +
                            '<option value="雲林縣"    '+ a10 +'>雲林縣</option>' +
                            '<option value="嘉義縣"    '+ a11 +'>嘉義縣</option>' +
                            '<option value="屏東縣"    '+ a12 +'>屏東縣</option>' +
                            '<option value="宜蘭縣"    '+ a13 +'>宜蘭縣</option>' +
                            '<option value="花蓮縣"    '+ a14 +'>花蓮縣</option>' +
                            '<option value="臺東縣"    '+ a15 +'>臺東縣</option>' +
                            '<option value="金門縣"    '+ a16 +'>金門縣</option>' +
                            '<option value="連江縣"    '+ a17 +'>連江縣</option>' +
                        '</select>' +
                    '</div>';
    });
    property_str += '</div>';
    return property_str;
}

//讀取各家屬所得資料
function rf_mem_income(incomes){
    var incomes_str = '<div class="income-cont">';
    $.each(incomes, function(index, income) {
        var D_none = "", SS = "" , ST = "", SP = "", SB = "", SO = "", SY = "", SM = "", SA = "";
        if (income.type == "股票配息" || income.type == "存款利息"){
            D_none = 'in';
        }
        if(income.type == "薪資"){ SS = 'selected="selected"'; SA = "Salary";};
        if(income.type == "股票配息"){ ST = 'selected="selected"'; };
        if(income.type == "營利"){ SP = 'selected="selected"'; SA = "Salary";};
        if(income.type == "存款利息"){ SB = 'selected="selected"'; };
        if(income.type == "其他"){ SO = 'selected="selected"'; };
        if(income.m_or_y == "m"){ SM = 'selected="selected"'; };
        if(income.m_or_y == "y"){ SY = 'selected="selected"'; };

        incomes_str +='<div class="proper-inc-div" code="'+income.key+'" edit="new"><button type="button" class="close" data-toggle="modal" data-target="#confirm-delete-inc" aria-label="Close" style="top: 0.2em;right: 0.2em;position: absolute;"><span aria-hidden="true">×</span></button>' + 
                        '<select class="proper-inc-div-1">' +
                            '<option value="Salary"  '+ SS +'>薪資</option>' +
                            '<option value="Stock-int" '+ ST +'>股票配息</option>' +
                            '<option value="Profit" '+ SP +'>營利</option>' +
                            '<option value="Bank-int" '+ SB +'>存款利息</option>' +
                            '<option value="others" '+ SO +'>其他</option>' +
                        '</select>' +
                        '<input placeholder="額度-新台幣(元)" class="people-input-right proper-inc-div-2" value="'+income.value+'">' +
                        '<input placeholder="來源單位(企業或機構)" class="people-input-left proper-inc-div-3" value="'+income.from+'">' +
                        '<input placeholder="備註欄" class="people-input-left proper-inc-div-5 '+ SA +'" value="'+income.note+'">' +
                        '<select class="proper-inc-div-4">' +
                            '<option value="m" '+ SM +'>月收</option>' +
                            '<option value="y" '+ SY +'>年收</option>' +
                        '</select>' +
                        '<input placeholder="利率/值" class="people-input-right proper-inc-div-7 fade '+ D_none +'" value="'+income.rate+'" >' +
                      '</div>';
    });
    incomes_str += '</div>';
    return incomes_str;
}

//清空編輯頁面中的家屬資料
function empty_members(){
    //右側欄位清空
    $("#right_tab_area .town-name.selected").removeClass('selected');
    $("#area_cost").text("");
    $("#area_cost_year").text("");
    $("#area_limit").text("");
    $(".inc-div-cont").empty();
    $(".pro-div-cont").empty();

    $('.group-div').each(function(index, el) {
        if(!$(this).is('.add-new-button')){
            $(this).remove();
        }
    });
    //console.log($("#PH-birthday").text());
    //console.log(date_to_yyy($("#PH-birthday").text()));  
}

//edit-home 兩組自動帶入家況的按鈕設定
$(document).ready(function() {

    $("#PH-file_comm_1_button").on('click', function(event) {
        //User_Level
        event.preventDefault();
        //console.log("帶入自動家況");
        var HomeStr = "";
        HomeStr = "本戶扶助等級擬列為" + $("#PH-level").text() + "，查其動產總額為" + numberWithCommas($("#PH-total-pro").text()) + "元整，不動產列計總額為" + numberWithCommas($("#PH-total-imm").text()) + "元整；全戶月均所得為" + numberWithCommas($("#PH-total-inc").text()) + "元整，所得支出比為" + (parseInt(noCommas($("#PH-total-inc").text()))/parseInt(noCommas($("#PH-need").text()))*100).toFixed(4) + "%。\n";

        $('.group-div').find(".comm-cont").each(function(index, el) {
            HomeStr += ($(this).val()).replace(/\n/g , "") + "\n";
        });

        $("#PH-file_comm_1").val(HomeStr);
        //console.log(HomeStr);
        
        /* Act on the event */
    });

    $("#PH-file_comm_2_button").on('click', function(event) {

        event.preventDefault();
        
        $("#PH-file_comm_2").val($("#PH-file_comm_1").val());
    });

    if(User_Level == 1){
        $("#PH-file_comm_1_button").fadeIn('fast');
        $("#PH-file_comm_2_button").fadeOut('fast');
        $("#PH-file_comm_2").attr('disabled', 'disabled');
        $("#PH-file_comm_1").removeAttr('disabled');


    }else if(User_Level <= 3){
        $("#PH-file_comm_1_button").fadeOut('fast');
        $("#PH-file_comm_2_button").fadeOut('fast');
        $("#PH-file_comm_2").attr('disabled', 'disabled');
        $("#PH-file_comm_1").attr('disabled', 'disabled');

    }else if(User_Level <= 4){
        $("#PH-file_comm_1_button").fadeOut('fast');
        $("#PH-file_comm_2_button").fadeIn('fast');
        $("#PH-file_comm_1").attr('disabled', 'disabled');
        $("#PH-file_comm_2").removeAttr('disabled');
    }else if(User_Level <= 6){
        $("#PH-file_comm_1_button").fadeOut('fast');
        $("#PH-file_comm_2_button").fadeOut('fast');
        $("#PH-file_comm_2").attr('disabled', 'disabled');
        $("#PH-file_comm_1").attr('disabled', 'disabled');
    }else{
        $("#PH-file_comm_1_button").fadeIn('fast');
        $("#PH-file_comm_2_button").fadeIn('fast');
        $("#PH-file_comm_2").removeAttr('disabled');
        $("#PH-file_comm_1").removeAttr('disabled');
    }
});