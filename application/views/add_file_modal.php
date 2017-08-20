<div class="modal fade" id="Add_file" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="modal-title" id="Law_2_Label">新增扶助案件</h1>
            </div>
            <div class="modal-body">
            
                    
                <!--<h1 class="text-light">新增扶助案件</h1>
                <hr class="thin"/>
                <br />-->
                <div class="input-control text full-size" data-role="input">
                    <label for="ADF-name">役男姓名:</label>
                    <input type="text" name="ADF-name" id="ADF-name" placeholder="(必填)">
                    <button class="button helper-button clear" onclick="$('#ADF-name').val('')"><span class="mif-cross"></span></button>
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="ADF-code">身份字號:</label>
                    <input type="text" name="ADF-code" id="ADF-code" placeholder="(必填)">
                    <button class="button helper-button clear" onclick="$('#ADF-code').val('')"><span class="mif-cross"></span></button>
                </div>

                <div id="ADF-toggle" style="display: none;">
                    <div class="input-control password full-size" data-role="input">
                        <label for="ADF-birthday">役男生日:</label>
                        <input type="text" name="ADF-birthday" id="ADF-birthday" placeholder="7位數民國日期(必填)">
                        <button class="button helper-button clear" onclick="$('#ADF-birthday').val('')"><span class="mif-cross"></span></button>
                    </div>
                    <div class="input-control password full-size" data-role="input">
                        <label for="ADF-milidate">入伍日期:</label>
                        <input type="text" name="ADF-milidate" id="ADF-milidate" placeholder="7位數民國日期(必填)">
                        <button class="button helper-button clear" onclick="$('#ADF-milidate').val('')"><span class="mif-cross"></span></button>
                    </div>
                    <div class="input-control password full-size" data-role="input">
                        <label for="ADF-echelon">服役梯次:</label>
                        <input type="text" name="ADF-echelon" id="ADF-echelon" placeholder="(選填)">
                        <button class="button helper-button clear" onclick="$('#ADF-echelon').val('')"><span class="mif-cross"></span></button>
                    </div>
                    <div class="input-control password full-size" data-role="input">
                        <label for="ADF-address">戶籍地址:</label>
                        <select name="ADF-county" id="ADF-county"><option value="66000">臺中市</option></select><select name="ADF-town" id="ADF-town"></select><select name="ADF-village" id="ADF-village" style="width: 5.6em;"></select><input type="text" name="ADF-address" id="ADF-address" style="width:20em" placeholder="(必填)">
                        <button class="button helper-button clear" onclick="$('#ADF-address').val('')"><span class="mif-cross"></span></button>
                    </div>
                    <div class="input-control password full-size" data-role="input">
                        <label for="ADF-type">服役役別:</label>
                        <!--<input type="text" name="user_password" id="user_password">-->
                        <select name="ADF-type" id="ADF-type"></select>
                    </div>
                    <div class="input-control password full-size" data-role="input">
                        <label for="ADF-status">服役狀態:</label>
                        <select name="ADF-status" id="ADF-status"><option value="服役中">服役中</option><option value="停役中">停役中</option><option value="已退役">已退役</option></select>
                    </div>
                    <div class="input-control password full-size" data-role="input">
                        <label for="ADF-phone">家屬電話:</label>
                        <input type="text" name="ADF-phone" id="ADF-phone" placeholder="(可多筆)">
                        <button class="button helper-button clear" onclick="$('#ADF-phone').val('')"><span class="mif-cross"></span></button>
                    </div>
                    <div class="input-control password full-size" data-role="input">
                        <label for="ADF-email">電子信箱:</label>
                        <input type="text" name="ADF-email" id="ADF-email" placeholder="(選填)" style="width: 20em;">
                        <button class="button helper-button clear" onclick="$('#ADF-email').val('')"><span class="mif-cross"></span></button>
                    </div>
                    <div class="form-actions"><br>　　　　:
                        <button type="submit" class="button primary" id="ADF-submit">新增</button>
                        <button type="button" class="button link" id="ADF-clear">清除</button>
                    </div>
                </div>
                <hr class="thin"/>
                <br />
                <span class="mif-spinner2 mif-ani-spin fade" id="ADF-wait-icon"></span><span id="ADF-Msg" style="padding: 0.5em;">填寫資料</span>
                

                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        military_type_list();
        //refresh_village();

        $("#Add_file").on('change', 'input', function(event) {
            event.preventDefault();
            var string = $(this).val();
            $(this).val(string.trimall());
            /* Act on the event */
        });
        $("#ADF-code").on('change', function(event) {   //輸入身分證字號後，連線檢查是否已存在
            if($('#ADF-code').val() == ""){
                alert("請輸入完整身分證字號!");
                return;
            }
            if(TW_PersonalCodeCheck($('#ADF-code').val()) == false){
                //alert("請先輸入身分證字號!");
                $("#ADF-Msg").text('身分證字號有誤!').addClass('btn-warning');
                return;
            }

            $("#ADF-wait-icon").addClass('in');
            $("#ADF-Msg").text('連線檢查中...')
            $.ajax({
                url: '/File/check_boy_exist',
                type: 'post',
                dataType: 'json',
                data: {
                    ADF_code        : $("#ADF-code").val()
                },
            })
            .always(function() {
                //console.log("complete");
                  // remove loading image maybe
            })
            .done(function(responsive) {
                //var result = JSON.parse(responsive);
                console.log(responsive);
                $("#MSG").text(responsive['Msg']);
                $("#MSG").fadeIn('400', function() {        
                });
                if (responsive == "已存在"){
                    $("#ADF-toggle").slideUp('slow');
                    $("#ADF-Msg").text('役男資料已存在，請利用其他功能產生案件')
                }else{
                    $("#ADF-toggle").slideDown('slow');
                    $("#ADF-Msg").text('新增扶助案件').removeClass('btn-warning');
                }
                $("#ADF-wait-icon").removeClass('in');
                refresh_town();
                // setTimeout(function(){            
                //     refresh_village();
                // },1000);
                
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            });






            
            /* Act on the event */
        });
        $("#ADF-birthday").on('change', function(event) {
            if(!yyy_to_date($("#ADF-birthday").val())){
                //alert("請先輸入役男生日!");
                $("#ADF-Msg").text('役男生日有誤!').addClass('btn-warning');
            }else{
                $("#ADF-Msg").text('').removeClass('btn-warning');
            }
        });
        $("#ADF-milidate").on('change', function(event) {
            if(!yyy_to_date($("#ADF-milidate").val())){
                //alert("請先輸入役男生日!");
                $("#ADF-Msg").text('役男入伍日期有誤!').addClass('btn-warning');
            }else{
                $("#ADF-Msg").text('').removeClass('btn-warning');
            }
        });
        

        $("#ADF-clear").on('click', function(event) {
            event.preventDefault();
            $("#ADF-name").val("");
            $("#ADF-code").val("");
            $("#ADF-birthday").val("");
            $("#ADF-milidate").val("");
            $("#ADF-type").val("陸軍");
            $("#ADF-status").val("服役中");
            $("#ADF-address").val("");
        });

        $( "#ADF-submit" ).on( "click", function( event ) {             //新增役男案件
            event.preventDefault();
            $("#ADF-Msg").text('').removeClass('btn-warning');
            //$("#theForm").ajaxForm({url: 'server.php', type: 'post'})
            if($('#ADF-name').val() == ""){
                //alert("請先輸入役男姓名!");
                $("#ADF-Msg").text('請先輸入役男姓名!').addClass('btn-warning');
                return;
            }
            if($('#ADF-code').val() == ""){
                //alert("請先輸入身分證字號!");
                $("#ADF-Msg").text('請先輸入身分證字號!').addClass('btn-warning');
                return;
            }
            if(TW_PersonalCodeCheck($('#ADF-code').val()) == false){
                //alert("請先輸入身分證字號!");
                $("#ADF-Msg").text('身分證字號有誤!').addClass('btn-warning');
                return;
            }
            if($('#ADF-birthday').val() == ""){
                //alert("請先輸入役男生日!");
                $("#ADF-Msg").text('請先輸入役男生日!').addClass('btn-warning');
                return;
            }
            if(!yyy_to_date($("#ADF-birthday").val())){
                //alert("請先輸入役男生日!");
                $("#ADF-Msg").text('役男生日有誤!').addClass('btn-warning');
                return;
            }
            if($('#ADF-milidate').val() == ""){
                //alert("請先輸入役男入伍日期!");
                $("#ADF-Msg").text('請先輸入役男入伍日期!').addClass('btn-warning');
                return;
            }
            if(!yyy_to_date($("#ADF-milidate").val())){
                //alert("請先輸入役男生日!");
                $("#ADF-Msg").text('役男入伍日期有誤!').addClass('btn-warning');
                return;
            }
            if($('#ADF-address').val() == ""){
                //alert("請先輸入役男入伍日期!");
                $("#ADF-Msg").text('地址為必填項目!').addClass('btn-warning');
                return;
            }
            
            

            $("#ADF-Msg").text("連線中...");
            //$("#ADF-wait-icon").addClass('in');
            var ADF__birthday = yyy_to_date($("#ADF-birthday").val());
            var ADF__milidate = yyy_to_date($("#ADF-milidate").val());
            $.ajax({
                url: '/file/add_new_boy_file',
                type: 'post',
                dataType: 'json',
                data: {
                    ADF_name        : $("#ADF-name").val(),
                    ADF_code        : $("#ADF-code").val(),
                    ADF_birthday    : ADF__birthday,
                    ADF_milidate    : ADF__milidate,
                    ADF_county      : $("#ADF-county").val(),
                    ADF_town        : $("#ADF-town").val(),
                    ADF_village     : $("#ADF-village").val(),
                    ADF_address     : $("#ADF-address").val(),
                    ADF_type        : $("#ADF-type").val(),
                    ADF_status      : $("#ADF-status").val(),
                    ADF_echelon     : $("#ADF-echelon").val(),
                    ADF_phone       : $("#ADF-phone").val(),
                    ADF_email       : $("#ADF-email").val()
                },
            })
            .always(function() {
                console.log("complete");
                //$("#ADF-wait-icon").removeClass('in');
                  // remove loading image maybe
            })
            .done(function(responsive) {
                //var result = JSON.parse(responsive);
                console.log(responsive);

                if (responsive['Msg']=="success"){
                    $("#ADF-Msg").text("連線成功，新增案件中...");
                    $("#ADF-clear").trigger('click');
                    //CWait_Start();
                }
                read_file_new(responsive['file_key']);
                
                

                /*$("#MSG").text(responsive['Msg']);
                $("#MSG").fadeIn('400', function() {
                    if (responsive['Code'] == 1){
                        console.log("data_get");
                        setTimeout(function(){
                            
                            window.location.href="/";
                         },1000);
                    }else{

                    }
                });*/
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            });
        });

        $('#ADF-town').on('change', function(event) {//更新村里下拉選單
            refresh_village();
        });

        
        function refresh_town(){
            //$("#theForm").ajaxForm({url: 'server.php', type: 'post'})
            $('#ADF-town').empty();
            $("#MSG").text("連線中...");
            $.ajax({
                url: '/area/get_town_by_county',
                type: 'post',
                dataType: 'json',
                data: {
                    ADF_county        : $("#ADF-county").val()
                },
            })
            .always(function() {
                //console.log("complete");

                  // remove loading image maybe
            })
            .done(function(responsive_) {
                //var result = JSON.parse(responsive);
                var responsive = responsive_['town_list'];
                //console.log(responsive);
                var seloption = "";
                $.each(responsive, function(index, record){
                    seloption += '<option value="'+record.Town_code+'">'+record.Town_name+'</option>'; 
                });

                $('#ADF-town').append(seloption);
                setTimeout(function(){
                    if(User_Level <= 3){
                        //把新增案件的區先選起來
                        $("#ADF-town").val($("#ADF-town option:contains('"+organization+"')").val()).prop('disabled',true).css('background', '#d6d6d6');
                    }
                    setTimeout(function(){
                        refresh_village();
                    },300);


                },300);
                
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            });//更新區鎮下拉選單
        }

        function refresh_village(){
            //$("#theForm").ajaxForm({url: 'server.php', type: 'post'})
            $('#ADF-village').empty();
            $("#MSG").text("連線中...");
            $.ajax({
                url: '/area/get_village_by_town',
                type: 'post',
                dataType: 'json',
                data: {
                    ADF_town        : $("#ADF-town").val()
                },
            })
            .always(function() {
                console.log("complete");
                  // remove loading image maybe
            })
            .done(function(responsive_) {
                //var result = JSON.parse(responsive);
                var responsive = responsive_['village_list'];
                //console.log(responsive);
                var seloption = "";
                $.each(responsive, function(index, record){
                    seloption += '<option value="'+record.Village_id+'">'+record.Village_name+'</option>'; 
                });

                $('#ADF-village').append(seloption);
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            }); //更新村里下拉選單
        }

        function military_type_list(){
            //$("#theForm").ajaxForm({url: 'server.php', type: 'post'})
            //$('#ADF-village').empty();
            //$("#MSG").text("連線中...");
            $.ajax({
                url: '/area/military_type_list',
                type: 'post',
                dataType: 'json',
            })
            .always(function() {
                //console.log("complete");
                  // remove loading image maybe
            })
            .done(function(responsive_) {
                //var result = JSON.parse(responsive);
                var responsive = responsive_['military_type_list'];
                //console.log(responsive);
                var seloption = "";
                $.each(responsive, function(index, record){
                    seloption += '<option value="'+record.name+'">'+record.name+'</option>'; 
                });

                $('#ADF-type').append(seloption);
                $('#CE-New-type').append(seloption);
                
                //console.log("success");
            })
            .fail(function() {
                console.log("error");
            }); //更新村里下拉選單
        }




    });
</script>