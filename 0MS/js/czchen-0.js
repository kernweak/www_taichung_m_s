/*************************函式庫****************************************/    
    //找出所有img.svg，修改成嵌入式SVG碼，以便著色
    function svg_redraw(){
        jQuery('img.svg').each(function() {
            var $img = jQuery(this);
            var imgID = $img.attr('id');
            var imgClass = $img.attr('class');
            var imgURL = $img.attr('src');

            jQuery.get(imgURL, function(data) {
                // Get the SVG tag, ignore the rest
                var $svg = jQuery(data).find('svg');

                // Add replaced image's ID to the new SVG
                if (typeof imgID !== 'undefined') {
                    $svg = $svg.attr('id', imgID);
                }
                // Add replaced image's classes to the new SVG
                if (typeof imgClass !== 'undefined') {
                    $svg = $svg.attr('class', imgClass + ' replaced-svg');
                }

                // Remove any invalid XML tags as per http://validator.w3.org
                $svg = $svg.removeAttr('xmlns:a');

                // Replace image with new SVG
                $img.replaceWith($svg);

            }, 'xml');
        });
    }

    function date_to_yyy(date_string){ //西元日期轉民國7碼
        //date_string = "2016-05-03";
        var date_a = date_string.split("-");
        var yyy_date = (parseInt(date_a[0])-1911) + date_a[1] + date_a[2];
        if(yyy_date.length==6){
            yyy_date = "0" + yyy_date;
        }
        //console.log(yyy_date);
        return yyy_date;
    }
    //date_to_yyy();
    //yyy_to_date();

    function yyy_to_date(date_string){  //民國6/7碼轉西元日期
        //date_string = "1040310";
        date_string += "";
        if(date_string.length == 6){
           var yyyy_date = (parseInt(date_string.substr(0,2))+1911)+"-"+date_string.substr(2,2)+"-"+date_string.substr(4,2);
        }
        if(date_string.length == 7){
            var yyyy_date = (parseInt(date_string.substr(0,3))+1911)+"-"+date_string.substr(3,2)+"-"+date_string.substr(5,2);
        }
        //console.log(yyyy_date);
        return yyyy_date;
    }

    if (!String.prototype.trimall) {            //去除所有空白
      String.prototype.trimall = function () {
        return this.replace(/\s+/g, "");
      };
    }

    Array.prototype.max = function() {      //取出陣列最大最小值
      return Math.max.apply(null, this);
    };

    Array.prototype.min = function() {
      return Math.min.apply(null, this);
    };

    function read_file_test(file_key){
        //ajax read data
        //read file_info
        //read members
        //          read property
        //          read income
    }

    function rf_file_info(file_key){

    }

    function rf_members(file_key){
        
    }

    function rf_mem_property(property){
        property.key
        "type"
        "value"                 
        "from"
        "note"
        "self_use"

    }

    function rf_mem_income(income){
        
    }


    function read_file(file_key){
        $.ajax({
                url: '/file/read_new_file',
                type: 'post',
                dataType: 'json',
                data: {
                    file_key        : file_key
                },
            })
            .always(function() {
                console.log("complete");
                //$("#ADF-wait-icon").removeClass('in');
                  // remove loading image maybe
            })
            .done(function(responsive) {
                //var result = JSON.parse(responsive);
                //console.log(responsive);
                //console.log(responsive['役男姓名']);
                $("#PH-filetype").text(responsive['作業類別名稱']);
                $("#PH-name").text(responsive['役男姓名']);
                $("#PH-code").text(responsive['身分證字號']);
                $("#PH-birthday").text(responsive['役男生日']);
                $("#PH-milidate").text(responsive['入伍日期']);
                $("#PH-type").text(responsive['服役軍種']);
                $("#PH-status").text(responsive['服役狀態']);
                $("#PH-fulladdress").text(responsive['County_name']+responsive['Town_name']+responsive['Village_name']+responsive['戶籍地址']);
                
                $("#PH-members").text(responsive['總列計人口']);
                $("#PH-need").text(responsive['列計全年支出']);


                $("#PH-Deposits").text(responsive['存款本金總額']);
                $("#PH-Investment").text(responsive['投資總額']);
                $("#PH-Securities").text(responsive['有價證券總額']);
                $("#PH-others-Pro").text(responsive['其他動產總額']);
                $("#PH-total-pro").text(responsive['總動產']);

                $("#PH-Salary").text(responsive['薪資年所得']);
                $("#PH-Profit").text(responsive['營利年所得']);
                $("#PH-Property-int").text(responsive['財產年所得']);
                $("#PH-Bank-int").text(responsive['利息年所得']);
                $("#PH-Stock-int").text(responsive['股利年所得']);
                $("#PH-others-int").text(responsive['其他年所得']);
                $("#PH-total-inc").text(responsive['全年總所得']);
                
                $("#PH-Houses").text(responsive['房屋棟數']);
                $("#PH-Houses-total").text(responsive['房屋總價']);
                $("#PH-Houses-num").text(responsive['房屋非自用棟數']);
                $("#PH-Houses-listtotal").text(responsive['房屋列計總價']);
                $("#PH-Land").text(responsive['土地筆數']);
                $("#PH-Land-total").text(responsive['土地總價']);
                $("#PH-Land-num").text(responsive['土地非自用筆數']);
                $("#PH-Land-listtotal").text(responsive['土地列計總價']);
                $("#PH-total-imm").text(responsive['不動產列計總額']);

                $(".people_home").attr('file_id', file_key);
                $(".people_home").attr('boy_id', responsive['役男系統編號']);
                
                File_data = [];
                empty_members();
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            });
    }

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
        File_data = [];
        //console.log($("#PH-birthday").text());
        //console.log(date_to_yyy($("#PH-birthday").text()));
        var GROUP_DIV = '<div class="group-div" code=new edit=new><div style="width: 8em;height: 8em;"><img id="Picon-man" class="svg social-link svg-people" src="/0MS/images/captain.svg" /></div><div class="income-total"><div>所得</div><div class="people-income-total-value">0<img class="svg social-link NTD" src="/0MS/images/NTD.svg"></div></div><div class="property-total"><div>財產</div><div class="people-property-total-value">0<img class="svg social-link NTD" src="/0MS/images/NTD.svg"></div></div><div class="people-job"><input class="people-input-left" placeholder="所得職業" value=""></div><div class="people-title"><input class="people-input-center" placeholder="稱謂" value="役男"></div><div class="people-name"><input class="people-input-left" placeholder="姓名" value="'+$("#PH-name").text()+'"></div><div class="people-id"><input class="people-input-left" placeholder="身份證字號" value="'+$("#PH-code").text()+'"></div><div class="people-id-address"><input class="people-input-left" placeholder="戶籍地址" value="'+ $("#PH-fulladdress").text() +'"></div><div class="people-marriage"><input style="width: 5em;" class="people-input-left" placeholder="配偶姓名" value="未婚"></div><div class="people-marriage2"><input style="width: 5em;" class="people-input-left" value="" placeholder="前配偶"></div><div class="people-birthday"><span>生日：</span><input placeholder="7位數民國生日" class="people-input-left birthday" value="'+date_to_yyy($("#PH-birthday").text())+'" style="width: 7em;">　　<span>(0歲)</span></div><div class="people-special">身分：<span style="color: #a47523;">不列口數</span><div style="width: 7.5em;position: relative;left: 1em;display: inline-block;"><select class="people-input-left"><option value="0,0">一般</option><option value="0,2">產業訓儲或第3階段替代</option><option value="1,15">歿</option><option value="1,1" selected>服役中</option><option value="1,3">榮民領有生活費</option><option value="1,4">就學領有公費</option><option value="1,5">通緝或服刑</option><option value="1,6">失蹤有案</option><option value="1,7">災難失蹤</option><option value="1,8">政府安置</option><option value="1,9">無設籍外、陸配</option><option value="1,10">無扶養事實之直系尊親屬</option><option value="1,11">未盡照顧職責之父母</option><option value="1,12">父母離異而分離之兄弟姊妹</option><option value="1,13">無國籍</option><option value="1,14">不列口數：其他</option><option value="2,30">55歲以上,16歲以下無收入</option><option value="2,31">身心障礙、重大傷病</option><option value="2,32">3個月內之重大傷病</option><option value="2,33">學生</option><option value="2,34">孕婦</option><option value="2,35">獨自照顧直系老幼親屬</option><option value="2,36">獨自照顧重大傷病親屬</option><option value="2,37">不計收入：其他</option></select></div></div><div class=hidden-info><input type="hidden" name="" class="member_area" value="" area-index><div class=income-cont></div><div class=property-cont></div><textarea class=comm-cont></textarea></div></div>';
        $(GROUP_DIV).insertBefore($(".group-div.add-new-button"));
        svg_redraw();
        $(".group-div").eq(0).find('.people-id-address input').trigger('change');
        $(".group-div").eq(0).find('.people-birthday input').trigger('change');
        
    }

    function save_file(){
        members = [];
        $('.group-div').each(function(index, el) {
            if(!$(this).is('.add-new-button')){
                //每個成員
                var member = {
                    "key" : $(this).attr('code'),
                    "edit" : $(this).attr('edit'),
                    "title" : $(this).find('.people-title input').val(),
                    "name" : $(this).find('.people-name input').val(),
                    "code" : $(this).find('.people-id input').val(),
                    "birthday" : $(this).find('.people-birthday input').attr('YYYYMMDD'),
                    "address" : $(this).find('.people-id-address input').val(),
                    "job" : $(this).find('.people-job input').val(),
                    "special" : $(this).find('.people-special select').val(),
                    "marriage" : $(this).find('.people-marriage input').val(),
                    "marriage_ex" : $(this).find('.people-marriage2 input').val(),
                    "area" : $(this).find('.member_area').val(),
                    "area_key" : $(this).find('.member_area').attr('area-index'),
                    "comm" : $(this).find('.comm-cont').val(),
                    "income" : [],
                    "property" : []
                };

                $(this).find('.income-cont .proper-inc-div').each(function(index, el) {
                    var income = {
                            "key" : $(this).attr('code'),
                            "type" : $(this).children('.proper-inc-div-1 option:selected').text(),
                            "value" : $(this).children(".proper-inc-div-2").val(),
                            "m_or_y" : $(this).children(".proper-inc-div-4").val(), 
                            "from" : $(this).children(".proper-inc-div-3").val(),
                            "note" : $(this).children(".proper-inc-div-5").val(),
                            "rate" : $(this).children(".proper-inc-div-7").val() 
                    };
                    member.income.push(income);
                });
                $(this).find('.property-cont .proper-inc-div').each(function(index, el) {
                    var property = {
                    "key" : $(this).attr('code'),
                    "type": $(this).children('.proper-inc-div-1 option:selected').text(),
                    "value" : $(this).children(".proper-inc-div-2").val(),                    
                    "from" : $(this).children(".proper-inc-div-3").val(),
                    "note" : $(this).children(".proper-inc-div-5").val(),
                    "self_use" : $(this).children(".proper-inc-div-4").val()
                }
                    member.property.push(property);
                });
             

                members.push(member);
            }
        });
        //console.log(members);

        file_info = {
                "key" :         $(".people_home").attr('file_id'),      //案件流水號
                "deposits"  :   $("#PH-Deposits").text(),               //存款
                "investment"  : $("#PH-Investment").text(),             //投資
                "securities"  : $("#PH-Securities").text(),             //證券
                "others_pro"  : $("#PH-others-Pro").text(),             //其他動產
                "total_pro"  :  $("#PH-total-pro").text(),  //動產列計總額
                "houses"  :     $("#PH-Houses").text(),     //房屋棟數
                "houses_total"  : $("#PH-Houses-total").text(), //房屋總價
                "houses_num"  : $("#PH-Houses-num").text(), //列計棟數
                "houses_listtotal"  : $("#PH-Houses-listtotal").text(), //列計價值
                "land"  :       $("#PH-Land").text(),   //土地筆數      
                "land_total"  : $("#PH-Land-total").text(),     //土地總值
                "land_num"  :   $("#PH-Land-num").text(),       //列計筆數
                "land_listtotal"  : $("#PH-Land-listtotal").text(),     //列計價值
                "total_imm"  :  $("#PH-Total-imm").text(),     //不動產列計總額
                "salary"  :     $("#PH-Salary").text(),     //薪資
                "profit"  :     $("#PH-Profit").text(),     //營利
                "property_inc"  : $("#PH-Property-inc").text(), //財產所得
                "bank_inc"  :   $("#PH-Bank-int").text(),       //存款利息
                "stock_inc"  :  $("#PH-Stock-int").text(),      //股利
                "others_inc"  : $("#PH-others-int").text(),     //其他所得
                "total_inc"  :  $("#PH-total-inc").text(),      //列計人口
                "members"  :    $("#PH-members").text(),        //生活所需-月
                "need"  :       $("#PH-need").text(),           //月均所得總額
                "level"  :      $("#PH-level").text()           //扶助等級
        };
        //console.log(file_info);
        file_json = JSON.stringify(file_info);
        members_json = JSON.stringify(members);

        //console.log('file_info json = ' + file_json);
        //console.log('members json = ' + members_json);

        $.ajax({
            url: '/family/set_members_file',
            type: 'post',
            dataType: 'json',
            data: {
                file_info        : file_json,
                members          : members_json
            },
        })
        .always(function() {
            console.log("complete");
        })
        .done(function(responsive) {
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        });
    }