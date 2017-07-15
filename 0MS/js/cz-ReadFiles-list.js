
    //待辦案件
    function read_file_list_pending(){  
        $.ajax({
            url: '/file/read_file_list_pending',
            type: 'post',
            dataType: 'json',
        })
        .always(function() {
            //console.log("complete");
        })
        .done(function(responsive) {
            CWait_End();
            $("#table_id tbody").empty();
            var table = $('#table_id').DataTable();     //DataTable
            table.clear();                              //DataTable 清空

            tbody = "";
            $.each(responsive, function(index, file) {
                var edit_button = "";
                if(file.審批階段 == 1 || file.審批階段 == 8 || file.審批階段 == 4 || (User_Level >= 8 && file.審批階段 != 0)){
                    edit_button = "<div class='btn-group' role='group'>"+
                    "<button type='button' class='btn btn-success' onclick='read_file_test("+file.案件流水號+",this)'>編輯</button>"+
                  "</div>";
                }else if(file.審批階段 == 0){
                    edit_button = "<div class='btn-group' role='group'>"+
                    "<button type='button' class='btn btn-success' onclick='progress_receive("+file.案件流水號+")'>受理</button>"+
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
                  edit_button;

                  if(file.審批階段 != 0){
                    Button_str += "<div class='btn-group' role='group'>"+
                    "<button type='button' class='btn btn-warning' onclick='progress_p_back("+file.案件流水號+",this)'>退回</button>"+
                  "</div>";
                  }
                  

                  if(file.審批階段 == 8){
                    edit_button3 = "<div class='btn-group' role='group'>"+
                    "<button type='button' class='btn btn-info' onclick='progress_p_patch_re("+file.案件流水號+",this)'>補件</button>"+
                  "</div>";
                  }else if(file.審批階段 == 6){
                    edit_button3 = "<div class='btn-group' role='group'>"+
                    "<button type='button' class='btn btn-info' onclick='progress_p_next("+file.案件流水號+",this)'>結案</button>"+
                  "</div>";
                  }else if(file.審批階段 == 0){
                    edit_button3 = "";
                  }else{
                    edit_button3 = 
                    "<div class='btn-group' role='group'>"+
                        "<button type='button' class='btn btn-danger' onclick='progress_p_next("+file.案件流水號+",this)'>呈核</button>"+
                    "</div>";
                  }

                  Button_str = Button_str + edit_button3 + edit_button2 +
                "</div>";

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

                $(row).attr('trkey', file.案件流水號).attr({
                    'trkey' : file.案件流水號,
                    'boykey': file.役男系統編號,
                    'PLV'   : file.審批階段,
                    'FNum': file.案件數,
                });;
                if(file.審批階段 <= 1){
                    $(row).addClass('LV1-Rmenu');
                }
                
                //table.draw(false);
            });
            table.draw(false);
            $("a[href='#filelist-navcon']").tab('show');
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

    //流程進行中的案件
    function read_file_list_progress(){
        CWait_Start();
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
            CWait_End();
            $("#table_progress tbody").empty();
            var table = $('#table_progress').DataTable();     //DataTable
            table.clear(); 
            tbody = "";
            $.each(responsive, function(index, file) {
                //檢視.編輯.意見.退回.呈核
                var Button_str = "";
                if(User_Level == file.審批階段 - 1){
                    Button_str = 
                        '<div class="btn-group" role="group" aria-label="...">'+
                            '<div class="btn-group" role="group">'+
                                '<button type="button" class="btn btn-primary" onclick="progress_view('+file.案件流水號+',this)">檢視</button>'+
                                '<button type="button" class="btn btn-warning" onclick="progress_p_get_back('+file.案件流水號+',this)">撤回</button>'+
                        '</div></div>';
                }else{
                    Button_str = 
                        '<div class="btn-group" role="group" aria-label="...">'+
                            '<div class="btn-group" role="group">'+
                                '<button type="button" class="btn btn-primary" onclick="progress_view('+file.案件流水號+',this)">檢視</button>'+
                        '</div></div>';
                }
                 var progress = (file.審批階段/6)*100;


                var data = [
                    yyy_dash(date_to_yyy(file.入伍日期)),
                    file.Town_name,
                    file.役男姓名,
                    file.身分證字號,
                    '<div class="progress">' +
                                '<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">' +
                                    '<span style="display:none;">20</span>'+file.案件階段名稱+'</div>' +
                            '</div>',
                    file.扶助級別,
                    yyy_dash(date_to_yyy(file.建案日期)),
                    file.修改人姓名,
                    file.作業類別名稱,
                    Button_str
                ];

                var row = table.row.add(data).node();
                $(row).attr('trkey', file.案件流水號);






            });
            table.draw(false);
           // $("#table_progress tbody").html(tbody);
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

    //扶助中案件
    function read_file_list_supporting(){
        CWait_Start();
        $.ajax({
            url: '/file/read_file_list_supporting',
            type: 'post',
            dataType: 'json',
        })
        .always(function() {
            console.log("complete");
        })
        .done(function(responsive) {
            CWait_End();
            $("#table_supporting tbody").empty();
            var table = $('#table_supporting').DataTable();     //DataTable
            table.clear();    
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
                    '<button type="button" class="btn btn-info" onclick="progress_p_review('+file.案件流水號+',this,\'春節複查\')">春節</button>'+
                  '</div>'+
                  '<div class="btn-group" role="group">'+
                    '<button type="button" class="btn btn-info" onclick="progress_p_review('+file.案件流水號+',this,\'端午複查\')">端午</button>'+
                  '</div>'+
                  '<div class="btn-group" role="group">'+
                    '<button type="button" class="btn btn-info" onclick="progress_p_review('+file.案件流水號+',this,\'中秋複查\')">中秋</button>'+
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
                            '<button type="button" class="btn btn-warning" onclick="progress_p_review('+file.案件流水號+',this,\'複查\')">複查</button>'+
                          '</div>'+
                          '<div class="btn-group" role="group">'+
                            '<button type="button" class="btn btn-danger" onclick="progress_p_review('+file.案件流水號+',this,\'退役\')">退役</button>'+
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
                if(progress>100) progress = 100;
                //console.log(diffDays);
                 /*tbody += "" +

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

                    '</tr>';*/
                /*
                    Datable 的寫法
                */

                var data = [
                    yyy_dash(date_to_yyy(file.入伍日期)),
                    file.Town_name,
                    file.役男姓名,
                    yyy_dash(date_to_yyy(file.役男生日)),
                    file.身分證字號,
                    file.扶助級別,
                    '<div class="progress">' +
                                '<div class="progress-bar progress-bar-'+bar_color+'" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: '+progress+'%;">' +
                                    +diffDays+'</div>',
                    file.修改人姓名,
                    file.作業類別名稱,
                    Button_str
                ];

                var row = table.row.add(data).node();
                $(row).attr('trkey', file.案件流水號);
                //table.draw(false);
            });
            table.draw(false);
            //$("#table_supporting tbody").html(tbody);

        })
        .fail(function() {
            console.log("error");
        });
    }

    //資格不符案件
    function read_file_list_fail(){ //table_fail
        $.ajax({
            url: '/file/read_file_list_fail',
            type: 'post',
            dataType: 'json',
        })
        .always(function() {
            console.log("complete");
        })
        .done(function(responsive) {
            CWait_End();
            $("#table_fail tbody").empty();
            var table = $('#table_fail').DataTable();     //DataTable
            table.clear();                              //DataTable 清空

            tbody = "";
            
            $.each(responsive, function(index, file) {
                
                

                //console.log(file.審批階段);
                var Button_reb = "";
                var Button_rev = "";
                if(parseInt(file.審批階段) == 8 && User_Level >= 2 ){   //8:逕行結案
                    //console.log(file.審批階段);
                    Button_reb = 
                          "<div class='btn-group' role='group'>" +
                            "<button type='button' class='btn btn-warning' onclick='progress_p_reborn(" + file.案件流水號 + ",this)'>重啟</button>" +
                          "</div>";
                    //console.log(Button_reb);
                }
                if(file.案件流水號 == file.最新案件流水號){
                    Button_rev = 
                          '<div class="btn-group" role="group">'+
                            '<button type="button" class="btn btn-info" onclick="progress_p_review('+file.案件流水號+',this,\'複查\')">複查</button>'+
                          '</div>'
                }else{
                    Button_rev = '<span style="position: relative;top: 0.2em;">　有複查案進行中</span>';
                }

                if(1){
                    var Button_str = 
                        '<div class="btn-group" role="group" aria-label="...">'+
                          '<div class="btn-group" role="group">'+
                            '<button type="button" class="btn btn-primary" onclick="progress_view('+file.案件流水號+',this)">檢視</button>'+
                          '</div>'+
                          Button_reb +
                          Button_rev + 
                        '</div>';
                }
                  

                  Button_str = Button_str + "</div>" ; 
                //"";

                var data = [
                    yyy_dash(date_to_yyy(file.入伍日期)),
                    file.Town_name,
                    file.役男姓名,
                    file.身分證字號,
                    file.役男生日,
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
            //$("#table_supporting tbody").html(tbody);

        })
        .fail(function() {
            console.log("error");
        });
    }

    