    //案件審核頁面 進度操作與呼叫檢視

    var file_list_pointer = 0;
    var file_list_action_pointer = "";

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
            //console.log("complete");
        })
        .done(function(responsive) {
            //console.log("success");
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
            //console.log("error");
        });
    }

    function progress_receive(file_key){
        $.ajax({
            url: '/file/recive_new_boy_file',//------------------------------
            type: 'post',
            dataType: 'json',
            data: {
                file_key        : file_key,
            },
        })
        .always(function() {
            
        })
        .done(function(responsive) {
            //console.log("success");
            read_file_list_pending();
        })
        .fail(function() {
            //console.log("error");
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
            //console.log("complete");
        })
        .done(function(responsive) {
            //console.log("success");
            read_file_list_pending();
        })
        .fail(function() {
            //console.log("error");
        });
    }
    function progress_batch_next(){
        $.ajax({
            url: '/file/progress_batch_next',
            type: 'post',
            dataType: 'json',
            data: {
                User_Level        : User_Level,
                log_comment     : $("#log_comment").val()
            },
        })
        .always(function() {
            //console.log("complete");
        })
        .done(function(responsive) {
            //console.log("success");
            read_file_list_pending();
        })
        .fail(function() {
            //console.log("error");
        });
    }
    var file_transfer_target = "";  //要轉移到哪個區?(代碼)
    function progress_transfer(file_key){
        $.ajax({
            url: '/file/progress_transfer',
            type: 'post',
            dataType: 'json',
            data: {
                file_key        : file_key,
                target_code     : file_transfer_target,
                log_comment     : $("#log_comment").val()
            },
        })
        .always(function() {
            //console.log("complete");
        })
        .done(function(responsive) {
            //console.log("success");
            read_file_list_pending();
        })
        .fail(function() {
            //console.log("error");
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
            //console.log("complete");
        })
        .done(function(responsive) {
            //console.log("success");
            read_file_list_pending();
        })
        .fail(function() {
            //console.log("error");
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
            //console.log("complete");
        })
        .done(function(responsive) {
            //console.log("success");
            read_file_list_pending();
        })
        .fail(function() {
            //console.log("error");
        });
    }

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
            //console.log("complete");
        })
        .done(function(responsive) {
            //console.log("success");
            read_file_list_pending();
        })
        .fail(function() {
            //console.log("error");
        });
    }
    function progress_reborn(file_key){
        $.ajax({
            url: '/file/progress_reborn',
            type: 'post',
            dataType: 'json',
            data: {
                file_key        : file_key,
                log_comment     : $("#log_comment").val()
            },
        })
        .always(function() {
            //console.log("complete");
        })
        .done(function(responsive) {
            //console.log("success");
            read_file_list_fail();
        })
        .fail(function() {
            //console.log("error");
        });
    }

    function progress_directly_close(file_key){
        $.ajax({
            url: '/file/progress_directly_close',
            type: 'post',
            dataType: 'json',
            data: {
                file_key        : file_key,
                log_comment     : $("#log_comment").val()
            },
        })
        .always(function() {
            //console.log("complete");
        })
        .done(function(responsive) {
            //console.log("success");
            read_file_list_pending();
        })
        .fail(function() {
            //console.log("error");
        });
    }

    function progress_get_back(file_key){
        $.ajax({
            url: '/file/progress_get_back',
            type: 'post',
            dataType: 'json',
            data: {
                file_key        : file_key,
                log_comment     : $("#log_comment").val()
            },
        })
        .always(function() {
            //console.log("complete");
        })
        .done(function(responsive) {
            //console.log("success");
            read_file_list_pending();
        })
        .fail(function() {
            //console.log("error");
        });
    }

    function progress_delete(file_key){
        $.ajax({
            url: '/file/progress_delete',
            type: 'post',
            dataType: 'json',
            data: {
                file_key        : file_key,
                log_comment     : $("#log_comment").val()
            },
        })
        .always(function() {
            //console.log("complete");
        })
        .done(function(responsive) {
            //console.log("success");
            read_file_list_pending();
        })
        .fail(function() {
            //console.log("error");
        });
    }

    function progress_review(file_key){
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
            //console.log("complete");
        })
        .done(function(responsive) {
            //console.log("success");
            read_file_list_supporting();
            //read_file_list_progress();
            read_file_list_pending();
            read_file_list_fail();
            //CWait_End(1500);

        })
        .fail(function() {
            //console.log("error");
        });
    }

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
    var REditBoyKey = 0;
    function update_ReEditModal(tr){
        CWait_Start();
        //console.log(tr);
        var trkey = $(tr).attr("trkey");    //案件流水號,
        var boykey = $(tr).attr("boykey"); REditBoyKey = boykey;  //役男系統編號
        var PLV = $(tr).attr("PLV");        //審批階段
        var FNum = $(tr).attr("FNum");      //案件數
        //console.log(FNum);
        //讀檔
        $.ajax({
            url: '/file/read_boy_file_by_id',
            type: 'post',
            dataType: 'json',
            data: {
                boyid        : boykey,
            },
        })
        .done(function(responsive) {
            var file = responsive[0];
            //console.log(responsive);
            $("#CE-Old-name").val(file.役男姓名);
            $("#CE-Old-code").val(file.身分證字號);
            $("#CE-Old-birthday").val(file.役男生日);
            $("#CE-Old-milidate").val(file.入伍日期);
            $("#CE-Old-echelon").val(file.梯次);
            $("#CE-Old-type").val(file.服役軍種);
            $("#CE-Old-address").val(file.戶籍地址);
            $("#CE-Old-town").empty().append($('<option>', { value: file.Town_code, text : file.Town_name }));
            $("#CE-Old-village").empty().append($('<option>', { value: file.Village_id, text : file.Village_name }));
            $("#CE-Old-type").empty().append($('<option>', { value: file.服役軍種, text : file.服役軍種 }));
            $("#CE-Old-status").empty().append($('<option>', { value: file.服役狀態, text : file.服役狀態 }));
            $("#CE-Old-phone").val(file.聯絡電話1);
            $("#CE-Old-email").val(file.email);
            setTimeout(function(){
               ENAllReset();
               CWait_End();
            },500);
            

            
        })
    }




    function progress_p_edit_boyfile(file_key,e){
        file_list_pointer = file_key;
        file_list_action_pointer = "EditB";
        $('#ReEditModal').modal('show');
        //$('#myModalLabel').text('明顯資格不符，區公所承辦人逕行結案');
        //var tr = $(e).parents("tr").get(0);
        update_ReEditModal(e);
    }

    function progress_p_directly_close(file_key,event,key){
        file_list_pointer = file_key;
        file_list_action_pointer = "DClose";
        $('#myModal').modal('show');
        $('#myModalLabel').text('明顯資格不符，區公所承辦人逕行結案');
        var tr = $(event).parents("tr").get(0);
        update_myModal(tr);
    }

    function progress_p_delete(file_key,event,key){
        file_list_pointer = file_key;
        file_list_action_pointer = "Delete";
        $('#myModal').modal('show');
        $('#myModalLabel').text('刪除/封存此案件');
        var tr = $(event).parents("tr").get(0);
        update_myModal(tr);
    }

    function progress_p_back(file_key,event){
        file_list_pointer = file_key;
        file_list_action_pointer = "back";
        $('#myModal').modal('show');
        $('#myModalLabel').text('退回給承辦人');
        var tr = $(event).parents("tr").get(0);
        update_myModal(tr);
    }

    function progress_p_reborn(file_key,event){
        file_list_pointer = file_key;
        file_list_action_pointer = "reborn";
        $('#myModal').modal('show');
        $('#myModalLabel').text('取消結案狀態，發還公所承辦人');
        var tr = $(event).parents("tr").get(0);
        update_myModal(tr);
    }

    function progress_p_get_back(file_key,event){
        file_list_pointer = file_key;
        file_list_action_pointer = "get_back";
        $('#myModal').modal('show');
        $('#myModalLabel').text('撤回簽呈');
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
        batch_p_next();
        update_myModal(tr);
    }

    function batch_p_next(){
        if (User_Level >= BatchPro){   //等級6以上有此功能
            $('<button id="BatchAgree" type="button" class="btn btn-warning" onclick="batch_next()">主管專用-批核全部案件</button>').insertAfter( "#myModal .btn-primary" );

        }
    }

    function batch_next(){
        console.log("123");
        $('#myModal').modal('hide');
        progress_batch_next();
    }

    $(document).ready(function() {


    
        $('#myModal').on('hide.bs.modal', function (e) {
            $("#BatchAgree").remove();
        })
    })
    

    function progress_p_transfer(file_key,event,key){
        file_list_pointer = file_key;
        file_list_action_pointer = "transfer";
        console.log(key);
        file_transfer_target = key;
        $('#myModal').modal('show');
        $('#myModalLabel').html('將案件轉移至 ['+TArea_code_list[key]+']');
        update_myModal($(event));
    }

    function progress_p_review(file_key,event,act){
        file_list_pointer = file_key;
        file_list_action_pointer = act;
        //console.log(file_list_action_pointer);
        $('#RefileModal').modal('show');
        $('#RefileModalLabel').text("新增複查案："+act);
        if(act == "退役"){
           $('#RefileModalLabel').text("役男退役登錄"); 
        }
        var tr = $(event).parents("tr").get(0);
        update_RefileModal(tr);
    }

    function progress_view(file_key,event){
        CWait_Start();
        $("#pdf_viewer").attr("src","");
        file_list_pointer = file_key;
        file_list_action_pointer = "next";
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
            //console.log("complete");
        })
        .done(function(responsive) {
            CWait_End();
            //console.log("success");
            $.each(responsive.members, function(index, member) {
            });

            progress_view_rf_file_info(responsive.file_info);
            
            $('#File_list_View_Modal').modal('show');
            $("#File_list_View_Modal .modal-body").scrollTop(0);
            $('#File_list_View_ModalLabel').html('案件檢視');
        })
        .fail(function() {
            //console.log("error");
        });
    }

    function progress_view_rf_file_info(responsive){
        //console.log(responsive);

        $('#File_list_View_Modal .modal-body .t2 tbody tr').children('td').eq(0).html(responsive['役男生日']);//役男生日
        $('#File_list_View_Modal .modal-body .t2 tbody tr').children('td').eq(1).html(responsive['服役軍種']);//服役軍種
        $('#File_list_View_Modal .modal-body .t2 tbody tr').children('td').eq(2).html(responsive['梯次']);//服役梯次
        $('#File_list_View_Modal .modal-body .t2 tbody tr').children('td').eq(3).html(responsive['聯絡電話1']);//家屬電話
        $('#File_list_View_Modal .modal-body .t2 tbody tr').children('td').eq(4).html(responsive['email']);//電子信箱
        $('#File_list_View_Modal .modal-body .t2 tbody tr').children('td').eq(5).html(responsive['戶籍地址']);//戶籍地址






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
        $("#FView-PH-level").text(responsive['扶助級別']);
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
        $('#File_list_View_Modal .modal-body .t1 tbody tr').children('td').eq(0).html($(tr).children('td').eq(0).text());
        $('#File_list_View_Modal .modal-body .t1 tbody tr').children('td').eq(1).html($(tr).children('td').eq(1).text());
        $('#File_list_View_Modal .modal-body .t1 tbody tr').children('td').eq(2).html($(tr).children('td').eq(2).text());
        $('#File_list_View_Modal .modal-body .t1 tbody tr').children('td').eq(3).html($(tr).children('td').eq(3).text());
        $('#File_list_View_Modal .modal-body .t1 tbody tr').children('td').eq(4).html($(tr).children('td').eq(4).text());
        $('#File_list_View_Modal .modal-body .t1 tbody tr').children('td').eq(5).html($(tr).children('td').eq(5).text());
        $('#File_list_View_Modal .modal-body .t1 tbody tr').children('td').eq(6).html($(tr).children('td').eq(6).text());
        $('#File_list_View_Modal .modal-body .t1 tbody tr').children('td').eq(7).html($(tr).children('td').eq(7).text());
        $('#File_list_View_Modal .modal-body .t1 tbody tr').children('td').eq(8).html($(tr).children('td').eq(8).text());
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

    $(document).ready(function() {       
        $("#Home_root").on('click', '#myModal button.btn.btn-primary',function(event) {
            event.preventDefault();
            var FP = file_list_pointer;
            var FA = file_list_action_pointer;
            switch(FA) {
                case "DClose":
                    progress_directly_close(FP);
                    break;
                case "back":
                    progress_back(FP);
                    break;
                case "get_back":
                    progress_get_back(FP);
                    break;
                case "reborn":
                    progress_reborn(FP);
                    break;
                case "next":
                    progress_next(FP);
                    break;
                case "patch":
                    progress_patch(FP);
                    break;
                case "patch_re":
                    progress_patch_re(FP);
                    break;
                case "transfer":
                    progress_transfer(FP);
                    break;
                case "Delete":
                    progress_delete(FP);
                    break;
                default: 
            }
            $('#myModal').modal('hide');
        });

        $("#Home_root").on('click', '#RefileModal button.btn.btn-primary',function(event) {
            event.preventDefault();
            progress_review(file_list_pointer);
            $('#RefileModal').modal('hide');
        });

        $("#Home_root").on('click', '#ReEditModal button.btn.btn-primary',function(event) {
            ENsubmitCheck();
        });
    });