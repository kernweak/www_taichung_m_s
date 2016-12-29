/*************************函式庫****************************************/    
    //找出所有img.svg，修改成嵌入式SVG碼，以便著色
    var file_list_refile_pointer = "";

    function rebuildfile(file_key){
        $.ajax({
            url: '/file/rebuildfile',
            type: 'post',
            dataType: 'json',
            data: {
                file_key        : file_key,
                act             : file_list_action_pointer,
                log_comment     : "啟動複查程序，新增複查案："+file_list_refile_pointer
            },
        })
        .always(function() {
            console.log("complete");
        })
        .done(function(responsive) {
            console.log("success");
            read_file_list_supporting();
            read_file_list_progress();
            read_file_list_pending();
        })
        .fail(function() {
            console.log("error");
        });
    }

    function personnel_load(){
        $("#personnel > iframe").attr('src', 'http://mms.taichung.gov.tw/aup654rm6284gj4rm4/');
    }

    function refile(file_key,event,act){
        file_list_pointer = file_key;
        file_list_action_pointer = act;
        //console.log(file_list_action_pointer);
        $('#RefileModal').modal('show');
        $('#RefileModalLabel').text("新增複查案："+act);
        var tr = $(event).parents("tr").get(0);
        update_RefileModal(tr);
    }

    function update_RefileModal(tr){
        $(tr).children('td').eq(0).text();
        $('#RefileModal .modal-body tbody tr').children('td').eq(0).html($(tr).children('td').eq(0).html());
        $('#RefileModal .modal-body tbody tr').children('td').eq(1).html($(tr).children('td').eq(1).html());
        $('#RefileModal .modal-body tbody tr').children('td').eq(2).html($(tr).children('td').eq(2).html());
        $('#RefileModal .modal-body tbody tr').children('td').eq(3).html($(tr).children('td').eq(3).html());
        $('#RefileModal .modal-body tbody tr').children('td').eq(4).html($(tr).children('td').eq(4).html());
        $('#RefileModal .modal-body tbody tr').children('td').eq(5).html($(tr).children('td').eq(5).html());
        $('#RefileModal .modal-body tbody tr').children('td').eq(6).html($(tr).children('td').eq(6).html());
        $('#RefileModal .modal-body tbody tr').children('td').eq(7).html($(tr).children('td').eq(7).html());
        $('#RefileModal .modal-body tbody tr').children('td').eq(8).html($(tr).children('td').eq(8).html());
    }

    function read_file_list_supporting() {
        $.ajax({
            url: '/file/read_file_list_supporting',
            type: 'post',
            dataType: 'json',
        })
        .always(function() {
            console.log("complete");
        })
        .done(function(responsive) {
            $("#table_supporting tbody").empty();
            tbody = "";
            $.each(responsive, function(index, file) {
                var oneDay = 24*60*60*1000;
                var firstDate = new Date(file.入伍日期);
                var secondDate = new Date();
                var birthDay = new Date(file.役男生日);
                var birthDay83 = new Date("1994-01-01");
                var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay))); //已服役天數
                var period = 365;
                var color = "";
                var bar_color = "";
                var Button_mid = "";
                if((birthDay - birthDay83) >= 0){
                    period = 120;
                    bar_color = "success";
                    color = "green";

                }else{
                    period = 365;
                    bar_color = "danger";
                    color = "black";
                    Button_mid = '<div class="btn-group" role="group">'+
                    '<button type="button" class="btn btn-info" onclick="refile('+file.案件流水號+',this,\'春節複查\')">春節</button>'+
                  '</div>'+
                  '<div class="btn-group" role="group">'+
                    '<button type="button" class="btn btn-info" onclick="refile('+file.案件流水號+',this,\'端午複查\')">端午</button>'+
                  '</div>'+
                  '<div class="btn-group" role="group">'+
                    '<button type="button" class="btn btn-info" onclick="refile('+file.案件流水號+',this,\'中秋複查\')">中秋</button>'+
                  '</div>';

                }

                console.log(file.複查進行中);
                if(file.複查進行中 == "0"){
                    var Button_str = 
                        '<div class="btn-group" role="group" aria-label="...">'+
                          '<div class="btn-group" role="group">'+
                            '<button type="button" class="btn btn-primary" onclick="progress_view('+file.案件流水號+',this)">檢視</button>'+
                          '</div>'+
                          Button_mid
                          +
                          '<div class="btn-group" role="group">'+
                            '<button type="button" class="btn btn-warning" onclick="refile('+file.案件流水號+',this,\'複查\')">複查</button>'+
                          '</div>'+
                          '<div class="btn-group" role="group">'+
                            '<button type="button" class="btn btn-danger" onclick="refile('+file.案件流水號+',this,\'退役\')">退役</button>'+
                          '</div>'+
                        '</div>';
                }else{
                    var Button_str = 
                        '<div class="btn-group" role="group" aria-label="...">'+
                          '<div class="btn-group" role="group">'+
                            '<button type="button" class="btn btn-primary" onclick="progress_view('+file.案件流水號+',this)">檢視</button>'+
                          '</div>'+
                        '</div><span style="position: relative;top: 0.2em;">　有複查案進行中</span>';
                }

                



                progress = diffDays/period*100;
                //console.log(diffDays);
                 tbody += "" +

                    '<tr>' +   
                        '<td>'+ yyy_dash(date_to_yyy(file.入伍日期)) +'</td>' +
                        '<td>'+file.Town_name+'</td>' +
                        '<td>'+file.役男姓名+'</td>' +
                        '<td style="color: '+color+';">'+ yyy_dash(date_to_yyy(file.役男生日)) + '</td>' +
                        '<td>'+file.身分證字號+'</td>' +
                        '<td>'+file.扶助級別+'</td>' +
                        '<td style="padding-right: 1em;">'+
                            '<div class="progress">' +
                                '<div class="progress-bar progress-bar-'+bar_color+'" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: '+progress+'%;">' +
                                    +diffDays+'</div>' +
                            '</div>' +
                        '</td>' +
                        '<td>'+file.修改人姓名+'</td>' +
                        '<td>'+file.作業類別名稱+'</td>' +
                        '<td>'+Button_str+'</td>' +

                    '</tr>';
            });
            $("#table_supporting tbody").html(tbody);

        })
        .fail(function() {
            console.log("error");
        });
    }

    function read_file_list_progress() {
        $.ajax({
            url: '/file/read_file_list_progress',
            type: 'post',
            dataType: 'json',
        })
        .always(function() {
            console.log("complete");
        })
        .done(function(responsive) {
            // console.log("success");
            // miliboy_table.入伍日期// <th style="width: 8em;">入伍日期</th>
            // area_town.Town_name//    <th style="width: 7em;">行政區</th>
            // miliboy_table.役男姓名 //    <th style="width: 7em;">役男姓名</th>
            // miliboy_table.身分證字號//    <th style="width: 7.5em;">役男證號</th>
            // files_info_table.審批階段//      <th style="width: 12em;">案件進度</th>
            // files_info_table.扶助級別//      <th style="width: 8em;">審查結果</th>
            // files_info_table.建案日期//      <th style="width: 7em;">立案日期</th>
            // files_info_table.修改人姓名//     <th style="width: 7em;">主要承辦人</th>
            // files_info_table.案件流水號//    案件流水號
            // files_info_table.可否編修//      可否編輯    --可編輯者要多個編輯按鈕--   檢視-編輯-同意&呈核
            // files_status_code.案件階段名稱//       作業類別

            $("#table_progress tbody").empty();
            tbody = "";
            $.each(responsive, function(index, file) {
                //檢視.編輯.意見.退回.呈核
                var Button_str = 
                '<div class="btn-group" role="group" aria-label="...">'+
                  '<div class="btn-group" role="group">'+
                    '<button type="button" class="btn btn-primary" onclick="progress_view('+file.案件流水號+',this)">檢視</button>'+
                  '</div></div>';

                //console.log(file.審批階段);
                 var progress = (file.審批階段/6)*100;
                 tbody += "" +

                    '<tr trkey="'+file.案件流水號+'">' +   
                        '<td>'+ yyy_dash(date_to_yyy(file.入伍日期)) +'</td>' +
                        '<td>'+file.Town_name+'</td>' +
                        '<td>'+file.役男姓名+'</td>' +
                        '<td>'+file.身分證字號+'</td>' +
                        '<td>' +
                            '<div class="progress">' +
                                '<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">' +
                                    '<span style="display:none;">20</span>'+file.案件階段名稱+'</div>' +
                            '</div>' +
                        '</td>' +
                        '<td>'+file.扶助級別+'</td>' +
                        '<td>'+yyy_dash(date_to_yyy(file.建案日期))+'</td>' +
                        '<td>'+file.修改人姓名+'</td>' +
                        '<td>'+file.作業類別名稱+'</td>' +
                        '<td style="min-width: 190px;">'+Button_str+'</td>' +

                    '</tr>';
            });
            $("#table_progress tbody").html(tbody);
            setTimeout(function(){
                $.each(responsive, function(index, file) {
                    var progress = (file.審批階段/6)*100;
                    $("#table_progress tbody").find("tr[trkey="+file.案件流水號+"] .progress-bar").css('width', progress+'%');
                });
            },1000);

        })
        .fail(function() {
            console.log("error");
        });
    }

    function read_file_list_pending() {
        $.ajax({
            url: '/file/read_file_list_pending',
            type: 'post',
            dataType: 'json',
        })
        .always(function() {
            console.log("complete");
        })
        .done(function(responsive) {

            $("#table_id tbody").empty();
            var table = $('#table_id').DataTable();     //DataTable
            table.clear();                              //DataTable 清空

            tbody = "";
            $.each(responsive, function(index, file) {
                var edit_button = "";
                if(file.審批階段 <= 1 || file.審批階段 == 8 || file.審批階段 == 4){
                    edit_button = "<div class='btn-group' role='group'>"+
                    "<button type='button' class='btn btn-success' onclick='read_file_test("+file.案件流水號+")'>編輯</button>"+
                  "</div>";
                }
                else{
                    edit_button = '';
                }
                if(User_Level >= 4 && file.審批階段 != 8){
                    edit_button2 = "<div class='btn-group' role='group'>"+
                    "<button type='button' class='btn btn-info' onclick='progress_p_patch("+file.案件流水號+",this)'>補件</button>"+
                  "</div>";
                }else{
                    edit_button2 = '';
                }

                //檢視.編輯.意見.退回.呈核
                var Button_str = 
                "<div class='btn-group' role='group' aria-label='...'>"+
                  "<div class='btn-group' role='group'>"+
                    "<button type='button' class='btn btn-primary' onclick='progress_view("+file.案件流水號+",this)'>檢視</button>"+
                  "</div>"+
                  edit_button+
                  // "<div class='btn-group' role='group'>"+
                  //   "<button type='button' class='btn btn-info'>意見</button>"+
                  // "</div>"+
                  "<div class='btn-group' role='group'>"+
                    "<button type='button' class='btn btn-warning' onclick='progress_p_back("+file.案件流水號+",this)'>退回</button>"+
                  "</div>";
                  if(file.審批階段 == 8){
                    edit_button3 = "<div class='btn-group' role='group'>"+
                    "<button type='button' class='btn btn-info' onclick='progress_p_patch_re("+file.案件流水號+",this)'>補件</button>"+
                  "</div>";
                  }else if(file.審批階段 == 5){
                    edit_button3 = "<div class='btn-group' role='group'>"+
                    "<button type='button' class='btn btn-info' onclick='progress_p_next("+file.案件流水號+",this)'>結案</button>"+
                  "</div>";
                  }else{
                    edit_button3 = 
                    "<div class='btn-group' role='group'>"+
                        "<button type='button' class='btn btn-danger' onclick='progress_p_next("+file.案件流水號+",this)'>呈核</button>"+
                    "</div>";
                  }

                  Button_str = Button_str + edit_button3 + edit_button2 +
                "</div>";
                /*
                var progress_temp = file.審批階段;
                if (progress_temp == 8){progress_temp = 6;}
                var progress = (progress_temp/6)*100;

                 tbody += "" +

                    '<tr trkey="'+file.案件流水號+'">' +   
                        '<td>'+ yyy_dash(date_to_yyy(file.入伍日期)) +'</td>' +
                        '<td>'+file.Town_name+'</td>' +
                        '<td>'+file.役男姓名+'</td>' +
                        '<td>'+file.身分證字號+'</td>' +
                        '<td>' +
                            '<div class="progress">' +
                                '<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: '+progress+'%;">' +
                                    ''+file.案件階段名稱+'</div>' +
                            '</div>' +
                        '</td>' +
                        '<td>'+file.扶助級別+'</td>' +
                        '<td>'+yyy_dash(date_to_yyy(file.建案日期))+'</td>' +
                        '<td>'+file.修改人姓名+'</td>' +
                        '<td>'+file.作業類別名稱+'</td>' +
                        '<td style="min-width: 190px;">'+Button_str+'</td>' +

                    '</tr>';*/
                /*
                    Datable 的寫法
                */

                var data = [
                    yyy_dash(date_to_yyy(file.入伍日期)),
                    file.Town_name,
                    file.役男姓名,
                    file.身分證字號,
                    '<div class="progress">' +
                                '<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: '+"0"+'%;">' +
                                    ''+file.案件階段名稱+'</div>' +
                            '</div>',
                    file.扶助級別,
                    yyy_dash(date_to_yyy(file.建案日期)),
                    file.修改人姓名,
                    file.作業類別名稱,
                    Button_str
                ];

                var row = table.row.add(data).node();
                $(row).attr('trkey', file.案件流水號);
                //table.draw(false);
            });
            table.draw(false);
            setTimeout(function(){
                $.each(responsive, function(index, file) {
                    var progress_temp = file.審批階段;
                    if (progress_temp == 8){progress_temp = 6;}
                    //console.log(file.審批階段);
                    var progress = (progress_temp/6)*100;
                    $("#table_id tbody").find("tr[trkey="+file.案件流水號+"] .progress-bar").css('width', progress+'%');
                });
            },1500);

        })
        .fail(function() {
            console.log("error");
        });
    }

    function close_file(){
                    $("#family-edit-nav").fadeOut('400');
                    $("#file-list-nav > ul > li:nth-child(1) > a").tab('show');
                    read_file_list_pending();
                    setTimeout(function(){
                        empty_members();
                    },1000);
    }


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

    function yyy_dash(date_string){  //1050305 -> 105-03-05
        //date_string = "1040310";
        date_string += "";
        date_string = date_string.substring(0,3) + "-" + date_string.substring(3,5) + "-" + date_string.substring(5);
        return date_string;
    }

    function dash_yyy(date_string){  //105-03-05 -> 1050305
        //
        var date_a = date_string.split("-");
        var date_b = ""+date_a[0]+date_a[1]+date_a[2];
        return date_b;
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

    //計算目前歲數
    function _calculateAge(birthday) { // birthday is a date
        var ageDifMs = Date.now() - birthday.getTime();
        var ageDate = new Date(ageDifMs); // miliseconds from epoch
        return Math.abs(ageDate.getUTCFullYear() - 1970);
    }

    //將檔案路徑轉換成只有檔名
    function baseName(str)
    {
       var base = new String(str).substring(str.lastIndexOf('/') + 1); 
        if(base.lastIndexOf(".") != -1)       
            base = base.substring(0, base.lastIndexOf("."));
       return base;
    }

    function numberWithCommas(x) {  //numberWithCommas  轉換成有千分號的數字字串
        x = x + "";
        x = x.replace(/,/g , "");
        if((typeof stringValue) != "string"){
            x = parseInt(x);
            x = x.toString();
        }else{
            x = x.replace(/,/g , "");
        }
        return x.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function noCommas(x) {  //消除數字字串的千分號
        x = x + "";
        x = x.replace(/,/g , "");
        return x;
    }

    function recount_member_inc(MDIV){      //重新計算成員面板上的所得數字
        var IGContiv = $(MDIV).find('.income-cont').eq(0);     //income-cont -> property-cont
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
            // console.log(Inc_Title);
            // console.log(Inc_Value);
            // console.log(Inc_from);
            // console.log(Inc_Cycle);
        }
        Income = parseInt(Income);
        // console.log(Income);
        $(MDIV).find('.people-income-total-value').html(numberWithCommas(Income) + '<img class="svg social-link NTD" src="/0MS/images/NTD.svg">');
        svg_redraw();
    }
    function update_Access_Print_botton(file_key){
        $("#Access_Print_botton").attr('href', '/Report/Access_Print_Form/'+file_key);
    }
    function recount_member_pro(MDIV){      //重新計算成員面板上的財產數字
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


    function read_file_test(file_key){
        $('.right-total-count').hide();//隱藏右面板


        $.ajax({
            url: '/family/get_members_file',
            type: 'post',
            dataType: 'json',
            data: {
                file_key        : file_key,
            },
        })
        .always(function() {
            console.log("complete");
        })
        .done(function(responsive) {
            console.log("success");
            update_Access_Print_botton(file_key);
            setTimeout(function(){
                    $("#family-edit-nav").fadeIn('400');
                    //$('#Add_file').modal('hide');
                    $("#family-edit-nav > ul > li:nth-child(1) > a").tab('show');
                    //read_file(responsive['file_key']);
            },300);
            empty_members();
            //console.log(responsive);
            $.each(responsive.members, function(index, member) {
                 /* iterate through array or object */
                // console.log(member);
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
            });

            rf_file_info(responsive.file_info);


        })
        .fail(function() {
            console.log("error");
        });

        //ajax read data
        //read file_info
        //read members
        //          read property
        //          read income
        

        //console.log(rf_mem_property(propertys));
        //console.log(rf_mem_income(incomes));

        // var GROUP_DIV = rf_member();

        // $(GROUP_DIV).insertBefore($(".group-div.add-new-button"));
        // svg_redraw();

        // property.type
        // property.value                
        // property.from
        // property.note
        // property.self_use
    }

    function rf_file_info(responsive){
        console.log(responsive);
        $("#PH-filetype").text(responsive['作業類別名稱']);
        $("#PH-name").text(responsive['役男姓名']);
        $("#PH-code").text(responsive['身分證字號']);
        $("#PH-birthday").text(yyy_dash(date_to_yyy(responsive['役男生日'])));
        $("#PH-milidate").text(yyy_dash(date_to_yyy(responsive['入伍日期'])));
        $("#PH-type").text(responsive['服役軍種']);
        $("#PH-status").text(responsive['服役狀態']);
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
        
        //File_data = [];
        
    }

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
            '<div class="people-id"><input class="people-input-left" value="' + member.code + '"></div>' +
            '<div class="people-id-address"><input class="people-input-left" value="' + member.address + '"></div>' +
            '<div class="people-marriage"><input style="width: 5em;" class="people-input-left" placeholder="配偶姓名" value="' + member.marriage + '"></div>' +
            '<div class="people-marriage2"><input style="width: 5em;" class="people-input-left" value="" placeholder="' + member.marriage_ex + '"></div>' +
            '<div class="people-birthday"><span>生日：</span><input placeholder="7位數民國生日" class="people-input-left birthday" value="' + date_to_yyy(member.birthday) + '" style="width: 7em;">　　<span></span></div>' +
            '<div class="people-special">身分：<span style="color: #a47523;">一般</span>' +
                '<div style="width: 7.5em;position: relative;left: 1em;display: inline-block;">' +
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
                                '<option value="臺北市"	'+ a0 +'>臺北市</option>' +
                                '<option value="新北市"	'+ a1 +'>新北市</option>' +
                                '<option value="桃園縣"	'+ a2 +'>桃園縣</option>' +
                                '<option value="臺中市"	'+ a3 +'>臺中市</option>' +
                                '<option value="臺南市"	'+ a4 +'>臺南市</option>' +
                                '<option value="高雄市"	'+ a5 +'>高雄市</option>' +
                                '<option value="基隆市"	'+ a6 +'>基隆市</option>' +
                                '<option value="新竹縣"	'+ a7 +'>新竹縣</option>' +
                                '<option value="苗栗縣"	'+ a8 +'>苗栗縣</option>' +
                                '<option value="彰化縣"	'+ a9 +'>彰化縣</option>' +
                                '<option value="雲林縣"	'+ a10 +'>雲林縣</option>' +
                                '<option value="嘉義縣"	'+ a11 +'>嘉義縣</option>' +
                                '<option value="屏東縣"	'+ a12 +'>屏東縣</option>' +
                                '<option value="宜蘭縣"	'+ a13 +'>宜蘭縣</option>' +
                                '<option value="花蓮縣"	'+ a14 +'>花蓮縣</option>' +
                                '<option value="臺東縣"	'+ a15 +'>臺東縣</option>' +
                                '<option value="金門縣"	'+ a16 +'>金門縣</option>' +
                                '<option value="連江縣"	'+ a17 +'>連江縣</option>' +
                            '</select>' +
                        '</div>';
        });
        property_str += '</div>';
        return property_str;
    }

    function rf_mem_income(incomes){
        var incomes_str = '<div class="income-cont">';
        $.each(incomes, function(index, income) {
            var D_none = "", SS = "" , ST = "", SP = "", SB = "", SO = "", SY = "", SM = "";
            if (income.type == "股票配息" || income.type == "存款利息"){
                D_none = 'in';
            }
            if(income.type == "薪資"){ SS = 'selected="selected"'; };
            if(income.type == "股票配息"){ ST = 'selected="selected"'; };
            if(income.type == "營利"){ SP = 'selected="selected"'; };
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
                            '<input placeholder="備註欄" class="people-input-left proper-inc-div-5" value="'+income.note+'">' +
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
                $("#PH-need").text(responsive['月所需']);


                $("#PH-Deposits").text(responsive['存款本金總額']);
                $("#PH-Investment").text(responsive['投資總額']);
                $("#PH-Securities").text(responsive['有價證券總額']);
                $("#PH-others-Pro").text(responsive['其他動產總額']);
                $("#PH-total-pro").text(responsive['總動產']);

                $("#PH-Salary").text(responsive['薪資月所得']);
                $("#PH-Profit").text(responsive['營利月所得']);
                $("#PH-Property-int").text(responsive['財產月所得']);
                $("#PH-Bank-int").text(responsive['利息月所得']);
                $("#PH-Stock-int").text(responsive['股利月所得']);
                $("#PH-others-int").text(responsive['其他月所得']);
                $("#PH-total-inc").text(responsive['月總所得']);
                
                $("#PH-Houses").text(responsive['房屋棟數']);
                $("#PH-Houses-total").text(responsive['房屋總價']);
                $("#PH-Houses-num").text(responsive['房屋列計棟數']);
                $("#PH-Houses-listtotal").text(responsive['房屋列計總價']);
                $("#PH-Land").text(responsive['土地筆數']);
                $("#PH-Land-total").text(responsive['土地總價']);
                $("#PH-Land-num").text(responsive['土地列計筆數']);
                $("#PH-Land-listtotal").text(responsive['土地列計總價']);
                $("#PH-total-imm").text(responsive['不動產列計總額']);

                $(".people_home").attr('file_id', file_key);
                $(".people_home").attr('boy_id', responsive['役男系統編號']);
                
                //File_data = [];
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
        //console.log($("#PH-birthday").text());
        //console.log(date_to_yyy($("#PH-birthday").text()));
        
    }

    function add_miliboy(){
        var GROUP_DIV = '<div class="group-div" code=new edit=new><div style="width: 8em;height: 8em;"><img id="Picon-man" class="svg social-link svg-people" src="/0MS/images/captain.svg" /></div><div class="income-total"><div>所得</div><div class="people-income-total-value">0<img class="svg social-link NTD" src="/0MS/images/NTD.svg"></div></div><div class="property-total"><div>財產</div><div class="people-property-total-value">0<img class="svg social-link NTD" src="/0MS/images/NTD.svg"></div></div><div class="people-job"><input class="people-input-left" placeholder="所得職業" value=""></div><div class="people-title"><input class="people-input-center" placeholder="稱謂" value="役男"></div><div class="people-name"><input class="people-input-left" placeholder="姓名" value="'+$("#PH-name").text()+'"></div><div class="people-id"><input class="people-input-left" placeholder="身份證字號" value="'+$("#PH-code").text()+'"></div><div class="people-id-address"><input class="people-input-left" placeholder="戶籍地址" value="'+ $("#PH-fulladdress").text() +'"></div><div class="people-marriage"><input style="width: 5em;" class="people-input-left" placeholder="配偶姓名" value="未婚"></div><div class="people-marriage2"><input style="width: 5em;" class="people-input-left" value="" placeholder="前配偶"></div><div class="people-birthday"><span>生日：</span><input placeholder="7位數民國生日" class="people-input-left birthday" value="'+dash_yyy($("#PH-birthday").text())+'" style="width: 7em;">　　<span>(0歲)</span></div><div class="people-special">身分：<span style="color: #a47523;">不列口數</span><div style="width: 7.5em;position: relative;left: 1em;display: inline-block;"><select class="people-input-left"><option value="0,0">一般</option><option value="0,2">產業訓儲或第3階段替代</option><option value="1,15">歿</option><option value="1,1" selected>服役中</option><option value="1,3">榮民領有生活費</option><option value="1,4">就學領有公費</option><option value="1,5">通緝或服刑</option><option value="1,6">失蹤有案</option><option value="1,7">災難失蹤</option><option value="1,8">政府安置</option><option value="1,9">無設籍外、陸配</option><option value="1,10">無扶養事實之直系尊親屬</option><option value="1,11">未盡照顧職責之父母</option><option value="1,12">父母離異而分離之兄弟姊妹</option><option value="1,13">無國籍</option><option value="1,14">不列口數：其他</option><option value="3,30">55歲以上,16歲以下無收入</option><option value="3,31">身心障礙、重大傷病</option><option value="3,32">3個月內之重大傷病</option><option value="3,33">學生</option><option value="3,34">孕婦</option><option value="3,35">獨自照顧直系老幼親屬</option><option value="3,36">獨自照顧重大傷病親屬</option><option value="3,37">不計收入：其他</option><option value="2,38">不計收入：其他</option></select></div></div><div class=hidden-info><input type="hidden" name="" class="member_area" value="" area-index><div class=income-cont></div><div class=property-cont></div><textarea class=comm-cont></textarea></div></div>';
        $(GROUP_DIV).insertBefore($(".group-div.add-new-button"));
        svg_redraw();
        //console.log($("#PH-birthday").text());
        //console.log(dash_yyy($("#PH-birthday").text()));
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
                            "type" : $(this).find('.proper-inc-div-1 option:selected').text(),
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
                    "key" :         $(this).attr('code'),
                    "type":         $(this).find('.proper-inc-div-1 option:selected').text(),
                    "value" :       $(this).children(".proper-inc-div-2").val(),                    
                    "from" :        $(this).children(".proper-inc-div-3").val(),
                    "note" :        $(this).children(".proper-inc-div-5").val(),
                    "self_use" :    $(this).children(".proper-inc-div-4").val(),
                    "area" :        $(this).children(".proper-inc-div-6").val()
                }
                    member.property.push(property);
                });
             

                members.push(member);
            }
        });
        //console.log(members);

        file_info = {
                "key" :         $(".people_home").attr('file_id'),      //案件流水號
                "deposits"  :   noCommas($("#PH-Deposits").text()),               //存款
                "investment"  : noCommas($("#PH-Investment").text()),             //投資
                "securities"  : noCommas($("#PH-Securities").text()),             //證券
                "others_pro"  : noCommas($("#PH-others-Pro").text()),             //其他動產
                "total_pro"  :  noCommas($("#PH-total-pro").text()),  //動產列計總額
                "houses"  :     noCommas($("#PH-Houses").text()),     //房屋棟數
                "houses_total"  : noCommas($("#PH-Houses-total").text()), //房屋總價
                "houses_num"  : noCommas($("#PH-Houses-num").text()), //列計棟數
                "houses_listtotal"  : noCommas($("#PH-Houses-listtotal").text()), //列計價值
                "land"  :       noCommas($("#PH-Land").text()),   //土地筆數      
                "land_total"  : noCommas($("#PH-Land-total").text()),     //土地總值
                "land_num"  :   noCommas($("#PH-Land-num").text()),       //列計筆數
                "land_listtotal"  : noCommas($("#PH-Land-listtotal").text()),     //列計價值
                "total_imm"  :  noCommas($("#PH-total-imm").text()),     //不動產列計總額
                "salary"  :     noCommas($("#PH-Salary").text()),     //薪資
                "profit"  :     noCommas($("#PH-Profit").text()),     //營利
                "property_inc"  : noCommas($("#PH-Property-inc").text()), //財產所得
                "bank_inc"  :   noCommas($("#PH-Bank-int").text()),       //存款利息
                "stock_inc"  :  noCommas($("#PH-Stock-int").text()),      //股利
                "others_inc"  : noCommas($("#PH-others-int").text()),     //其他所得 
                "total_inc"  :  noCommas($("#PH-total-inc").text()),      //月均所得總額
                "members"  :    $("#PH-members").text(),        //列計人口 
                "need"  :       noCommas($("#PH-need").text()),           //生活所需-月
                "level"  :      $("#PH-level").text(),           //扶助等級
                "file_comm_1"  :$("#PH-file_comm_1").val(),           //整體家況敘述-公所
                "file_comm_2"  :$("#PH-file_comm_2").val()           //整體家況敘述-局處
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
            read_file_test($(".people_home").attr('file_id'));
        })
        .fail(function() {
            console.log("error");
        });
    }

    function read_file_progerss_log(file_key){
        $.ajax({
            url: '/file/read_file_progerss_log',
            type: 'post',
            dataType: 'json',
            data: {
                file_key        : file_key
            },
        })
        .always(function() {
            console.log("complete");
        })
        .done(function(responsive) {
            console.log("success");
            //console.log(responsive);
            $("#view_log_comment tbody").empty();
            tbody = "";
            $.each(responsive, function(index, file) {
                tbody += "<tr>" +
                "<td>"+file.日期時間+"</td>" +
                "<td>"+ file.動作者機關 + "-" + file.動作者單位 + "-" + file.動作者 + "(" + file.動作者職級 + ")</td>" +
                "<td>"+file.動作名稱+"</td>" +
                "<td>"+file.動作後案件流程層級+"</td>" +
                "<td>"+file.動作者意見+"</td>" + 
                "</tr>";
            });
            $("#view_log_comment tbody").html(tbody);
        })
        .fail(function() {
            console.log("error");
        });
    }

    function progress_next(file_key){
        $.ajax({
            url: '/file/progress_next',
            type: 'post',
            dataType: 'json',
            data: {
                file_key        : file_key,
                log_comment     : $("#log_comment").val()
            },
        })
        .always(function() {
            console.log("complete");
        })
        .done(function(responsive) {
            console.log("success");
            read_file_list_pending();
        })
        .fail(function() {
            console.log("error");
        });
    }

    function progress_patch(file_key){
        $.ajax({
            url: '/file/progress_patch',
            type: 'post',
            dataType: 'json',
            data: {
                file_key        : file_key,
                log_comment     : $("#log_comment").val()
            },
        })
        .always(function() {
            console.log("complete");
        })
        .done(function(responsive) {
            console.log("success");
            read_file_list_pending();
        })
        .fail(function() {
            console.log("error");
        });
    }

    function progress_patch_re(file_key){
        $.ajax({
            url: '/file/progress_patch_re',
            type: 'post',
            dataType: 'json',
            data: {
                file_key        : file_key,
                log_comment     : $("#log_comment").val()
            },
        })
        .always(function() {
            console.log("complete");
        })
        .done(function(responsive) {
            console.log("success");
            read_file_list_pending();
        })
        .fail(function() {
            console.log("error");
        });
    }

    //onclick="$('#myModal').modal('toggle')"

    var file_list_pointer = 0;
    var file_list_action_pointer = "";
            // 日期</th>
            // <th>行政區</th>
            // <th>役男姓名</th>
            // <th>役男證號</th>
            // <th>案件進度</th>
            // <th>審查結果</th>
            // <th>立案日期</th>
            // <th>主要承辦人</th>
            // <th>作業類別</th>
    function update_myModal(tr){
        $(tr).children('td').eq(0).text();
        $('#myModal .modal-body tbody tr').children('td').eq(0).html($(tr).children('td').eq(0).text());
        $('#myModal .modal-body tbody tr').children('td').eq(1).html($(tr).children('td').eq(1).text());
        $('#myModal .modal-body tbody tr').children('td').eq(2).html($(tr).children('td').eq(2).text());
        $('#myModal .modal-body tbody tr').children('td').eq(3).html($(tr).children('td').eq(3).text());
        $('#myModal .modal-body tbody tr').children('td').eq(4).html($(tr).children('td').eq(4).text());
        $('#myModal .modal-body tbody tr').children('td').eq(5).html($(tr).children('td').eq(5).text());
        $('#myModal .modal-body tbody tr').children('td').eq(6).html($(tr).children('td').eq(6).text());
        $('#myModal .modal-body tbody tr').children('td').eq(7).html($(tr).children('td').eq(7).text());
        $('#myModal .modal-body tbody tr').children('td').eq(8).html($(tr).children('td').eq(8).text());
    }

    function progress_p_back(file_key,event){
        file_list_pointer = file_key;
        file_list_action_pointer = "back";
        $('#myModal').modal('show');
        $('#myModalLabel').text('退回給承辦人');
        var tr = $(event).parents("tr").get(0);
        update_myModal(tr);
    }
    function progress_p_patch_re(file_key,event){
        file_list_pointer = file_key;
        file_list_action_pointer = "patch_re";
        $('#myModal').modal('show');
        $('#myModalLabel').text('補件後重送');
        var tr = $(event).parents("tr").get(0);
        update_myModal(tr);

    }
    function progress_p_patch(file_key,event){
        file_list_pointer = file_key;
        file_list_action_pointer = "patch";
        $('#myModal').modal('show');
        $('#myModalLabel').text('補件要求-給承辦人');
        var tr = $(event).parents("tr").get(0);
        update_myModal(tr);

    }
    function progress_p_next(file_key,event){
        file_list_pointer = file_key;
        file_list_action_pointer = "next";
        $('#myModal').modal('show');
        $('#myModalLabel').text('向上級呈核');
        var tr = $(event).parents("tr").get(0);
        update_myModal(tr);
    }

    function progress_view(file_key,event){
        file_list_pointer = file_key;
        file_list_action_pointer = "next";
        $('#File_list_View_Modal').modal('show');
        $('#File_list_View_ModalLabel').html('案件檢視');
        var tr = $(event).parents("tr").get(0);
        update_File_list_View_Modal(tr);
        read_file_progerss_log(file_key);

        //讀檔




        $.ajax({
            url: '/family/get_members_file',
            type: 'post',
            dataType: 'json',
            data: {
                file_key        : file_key,
            },
        })
        .always(function() {
            console.log("complete");
        })
        .done(function(responsive) {
            console.log("success");
            //console.log(responsive);
            $.each(responsive.members, function(index, member) {
                 /* iterate through array or object */
                // console.log(member);
                // var GROUP_DIV = rf_member(member);
                // $(GROUP_DIV).insertBefore($(".group-div.add-new-button"));
                // svg_redraw();
                // var this_index = $(".group-div").length - 2 ;
                // var MDIV = $(".group-div").eq(this_index);
                // $(MDIV).find('.people-special select').val(member.specials).trigger('change');
                // $(MDIV).find('.people-birthday input').trigger('change');
                // $(MDIV).find('.people-marriage input').trigger('change');
                // $(MDIV).find('.people-marriage2 input').trigger('change');
                // recount_member_pro($(MDIV));
                // recount_member_inc($(MDIV));
            });

            progress_view_rf_file_info(responsive.file_info);
            //console.log(responsive.file_info);


        })
        .fail(function() {
            console.log("error");
        });

        //ajax read data
        //read file_info
        //read members
        //          read property
        //          read income
        

        //console.log(rf_mem_property(propertys));
        //console.log(rf_mem_income(incomes));

        // var GROUP_DIV = rf_member();

        // $(GROUP_DIV).insertBefore($(".group-div.add-new-button"));
        // svg_redraw();

        // property.type
        // property.value                
        // property.from
        // property.note
        // property.self_use
    }

    function progress_view_rf_file_info(responsive){
        console.log(responsive);
        $("#FView-PH-filetype").text(responsive['作業類別名稱']);
        $("#FView-PH-name").text(responsive['役男姓名']);
        $("#FView-PH-code").text(responsive['身分證字號']);
        $("#FView-PH-birthday").text(yyy_dash(date_to_yyy(responsive['役男生日'])));
        $("#FView-PH-milidate").text(yyy_dash(date_to_yyy(responsive['入伍日期'])));
        $("#FView-PH-type").text(responsive['服役軍種']);
        $("#FView-PH-status").text(responsive['服役狀態']);
        $("#FView-PH-fulladdress").text(responsive['County_name']+responsive['Town_name']+responsive['Village_name']+responsive['戶籍地址']);
        
        $("#FView-PH-members").text(numberWithCommas(responsive['總列計人口']));
        $("#FView-PH-need").text(numberWithCommas(responsive['月所需']));


        $("#FView-PH-Deposits").text(numberWithCommas(responsive['存款本金總額']));
        $("#FView-PH-Investment").text(numberWithCommas(responsive['投資總額']));
        $("#FView-PH-Securities").text(numberWithCommas(responsive['有價證券總額']));
        $("#FView-PH-others-Pro").text(numberWithCommas(responsive['其他動產總額']));
        $("#FView-PH-total-pro").text(numberWithCommas(responsive['總動產']));

        $("#FView-PH-Salary").text(numberWithCommas(responsive['薪資月所得']));
        $("#FView-PH-Profit").text(numberWithCommas(responsive['營利月所得']));
        $("#FView-PH-Property-int").text(numberWithCommas(responsive['財產月所得']));
        $("#FView-PH-Bank-int").text(numberWithCommas(responsive['利息月所得']));
        $("#FView-PH-Stock-int").text(numberWithCommas(responsive['股利月所得']));
        $("#FView-PH-others-int").text(numberWithCommas(responsive['其他月所得']));
        $("#FView-PH-total-inc").text(numberWithCommas(responsive['月總所得']));
        
        $("#FView-PH-Houses").text(numberWithCommas(responsive['房屋棟數']));
        $("#FView-PH-Houses-total").text(numberWithCommas(responsive['房屋總價']));
        $("#FView-PH-Houses-num").text(numberWithCommas(responsive['房屋列計棟數']));
        $("#FView-PH-Houses-listtotal").text(numberWithCommas(responsive['房屋列計總價']));
        $("#FView-PH-Land").text(numberWithCommas(responsive['土地筆數']));
        $("#FView-PH-Land-total").text(numberWithCommas(responsive['土地總價']));
        $("#FView-PH-Land-num").text(numberWithCommas(responsive['土地列計筆數']));
        $("#FView-PH-Land-listtotal").text(numberWithCommas(responsive['土地列計總價']));
        $("#FView-PH-total-imm").text(numberWithCommas(responsive['不動產列計總額']));
        $("#FView-PH-file_comm_1").val("");
        $("#FView-PH-file_comm_2").val("");
        $("#FView-PH-file_comm_1").val(responsive['整體家況敘述-公所']);
        $("#FView-PH-file_comm_2").val(responsive['整體家況敘述-局處']);

        //有附件檔就傳檔名+顯示，不然就隱藏起來
        if(responsive['attach_household'] != ""){
            $("#View-att-0").attr('afile', responsive['attach_household']);
            $("#View-att-0 .b2").attr('href', '/uploads/'+responsive['attach_household']);
            $("#View-att-0").show();
        }else{
            $("#View-att-0").hide();
        }
        if(responsive['attach_income'] != ""){
            $("#View-att-1").attr('afile', responsive['attach_income']);
            $("#View-att-1 .b2").attr('href', '/uploads/'+responsive['attach_income']);
            $("#View-att-1").show();
        }else{
            $("#View-att-1").hide();
        }
        if(responsive['attach_property'] != ""){
            $("#View-att-2").attr('afile', responsive['attach_property']);
            $("#View-att-2 .b2").attr('href', '/uploads/'+responsive['attach_property']);
            $("#View-att-2").show();
        }else{
            $("#View-att-2").hide();
        }
        if(responsive['attach_statusprove'] != ""){
            $("#View-att-3").attr('afile', responsive['attach_statusprove']);
            $("#View-att-3 .b2").attr('href', '/uploads/'+responsive['attach_statusprove']);
            $("#View-att-3").show();
        }else{
            $("#View-att-3").hide();
        }
        if(responsive['attach_others'] != ""){
            $("#View-att-4").attr('afile', responsive['attach_others']);
            $("#View-att-4 .b2").attr('href', '/uploads/'+responsive['attach_others']);
            $("#View-att-4").show();
        }else{
            $("#View-att-4").hide();
        }
        //$(".people_home").attr('file_id', responsive['案件流水號']);
        //$(".people_home").attr('boy_id', responsive['役男系統編號']);
    }

    function update_File_list_View_Modal(tr){
        $(tr).children('td').eq(0).text();
        $('#File_list_View_Modal .modal-body tbody tr').children('td').eq(0).html($(tr).children('td').eq(0).text());
        $('#File_list_View_Modal .modal-body tbody tr').children('td').eq(1).html($(tr).children('td').eq(1).text());
        $('#File_list_View_Modal .modal-body tbody tr').children('td').eq(2).html($(tr).children('td').eq(2).text());
        $('#File_list_View_Modal .modal-body tbody tr').children('td').eq(3).html($(tr).children('td').eq(3).text());
        $('#File_list_View_Modal .modal-body tbody tr').children('td').eq(4).html($(tr).children('td').eq(4).text());
        $('#File_list_View_Modal .modal-body tbody tr').children('td').eq(5).html($(tr).children('td').eq(5).text());
        $('#File_list_View_Modal .modal-body tbody tr').children('td').eq(6).html($(tr).children('td').eq(6).text());
        $('#File_list_View_Modal .modal-body tbody tr').children('td').eq(7).html($(tr).children('td').eq(7).text());
        $('#File_list_View_Modal .modal-body tbody tr').children('td').eq(8).html($(tr).children('td').eq(8).text());
    }


$(document).ready(function() {

    $("#Home_root").on('click', '#myModal button.btn.btn-primary',function(event) {
        event.preventDefault();
        //console.log("click");

        if (file_list_action_pointer == "back"){
            progress_back(file_list_pointer);
        }else if(file_list_action_pointer == "next"){
            progress_next(file_list_pointer);
        }else if(file_list_action_pointer == "patch"){
            progress_patch(file_list_pointer);
        }else if(file_list_action_pointer == "patch_re"){
            progress_patch_re(file_list_pointer);
        }
        $('#myModal').modal('hide');
        /* Act on the event */
    });

    $("#Home_root").on('click', '#RefileModal button.btn.btn-primary',function(event) {
        event.preventDefault();
        //console.log("click");
        rebuildfile(file_list_pointer);
        // if (file_list_action_pointer == "back"){
        //     progress_back(file_list_pointer);
        // }else if(file_list_action_pointer == "next"){
        //     progress_next(file_list_pointer);
        // }else if(file_list_action_pointer == "patch"){
        //     progress_patch(file_list_pointer);
        // }else if(file_list_action_pointer == "patch_re"){
        //     progress_patch_re(file_list_pointer);
        // }
        $('#RefileModal').modal('hide');
        /* Act on the event */
    });

    $("#PH-file_comm_1_button").on('click', function(event) {
        //User_Level
        event.preventDefault();
        //console.log("帶入自動家況");
        var HomeStr = "";
        HomeStr = "本戶扶助等級擬列為" + $("#PH-level").text() + "，查其動產總額為" + numberWithCommas($("#PH-total-pro").text()) + "元整，不動產列計總額為" + numberWithCommas($("#PH-total-imm").text()) + "元整；全戶月均所得為" + numberWithCommas($("#PH-total-inc").text()) + "元整，所得支出比為" + (parseInt($("#PH-total-inc").text())/parseInt($("#PH-need").text())*100).toFixed(4) + "%。\n";



        $('.group-div').find(".comm-cont").each(function(index, el) {
            HomeStr += ($(this).val()).replace(/\n/g , "") + "\n";
        });

        $("#PH-file_comm_1").val(HomeStr);
        //console.log(HomeStr);
        
        /* Act on the event */
    });

    $("#PH-file_comm_2_button").on('click', function(event) {
        //User_Level
        event.preventDefault();
        //console.log("帶入自動家況");

        $("#PH-file_comm_2").val($("#PH-file_comm_1").val());
        //console.log(HomeStr);
        
        /* Act on the event */
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




    function progress_back(file_key){
        $.ajax({
            url: '/file/progress_back',
            type: 'post',
            dataType: 'json',
            data: {
                file_key        : file_key,
                log_comment     : $("#log_comment").val()
            },
        })
        .always(function() {
            console.log("complete");
        })
        .done(function(responsive) {
            console.log("success");
            read_file_list_pending();
        })
        .fail(function() {
            console.log("error");
        });
    }