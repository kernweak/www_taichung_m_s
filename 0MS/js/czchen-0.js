/*************************函式庫****************************************/    
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
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            });
    }

    function empty_members(){
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
    }
    var File_data = [];
    var File_data_property = [];
    var File_data_income = [];

    function save_file(){
        
        $('.group-div').each(function(index, el) {
            if(!$(this).is('.add-new-button')){
                var members=[];
                members["id"] = $(this).attr('code');
                members["edit"] = $(this).attr('edit');
                members["title"]=$(this).find('.people-title input').val();
                members["name"]=$(this).find('.people-name input').val();




                File_data.push(members);
            }
        });
        console.log(File_data);

    }