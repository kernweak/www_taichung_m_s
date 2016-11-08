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
                    <input type="text" name="ADF-name" id="ADF-name">
                    <button class="button helper-button clear" onclick="$('#ADF-name').val('')"><span class="mif-cross"></span></button>
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="ADF-code">身份字號:</label>
                    <input type="text" name="ADF-code" id="ADF-code">
                    <button class="button helper-button clear" onclick="$('#ADF-code').val('')"><span class="mif-cross"></span></button>
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="ADF-birthday">役男生日:</label>
                    <input type="text" name="ADF-birthday" id="ADF-birthday" placeholder="7位數民國日期">
                    <button class="button helper-button clear" onclick="$('#ADF-birthday').val('')"><span class="mif-cross"></span></button>
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="ADF-milidate">入伍日期:</label>
                    <input type="text" name="ADF-milidate" id="ADF-milidate" placeholder="7位數民國日期">
                    <button class="button helper-button clear" onclick="$('#ADF-milidate').val('')"><span class="mif-cross"></span></button>
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="ADF-type">服役軍種:</label>
                    <!--<input type="text" name="user_password" id="user_password">-->
                    <select name="ADF-type" id="ADF-type"><option value="陸軍">陸軍</option><option value="海軍">海軍</option><option value="空軍">空軍</option value=""><option value="一般替代役">一般替代役</option><option value="研發替代役">研發替代役</option></select>  
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="ADF-status">服役狀態:</label>
                    <select name="ADF-status" id="ADF-status"><option value="服役中">服役中</option><option value="停役中">停役中</option><option value="已退役">已退役</option></select>
                </div>
                <div class="form-actions">
                    <button type="submit" class="button primary" id="ADF-submit">新增</button>
                    <button type="button" class="button link" id="ADF-clear">清除</button>
                </div>
                <hr class="thin"/>
                <br />
                <span class="mif-spinner2 mif-ani-spin fade" id="ADF-wait-icon"></span><span id="ADF-Msg">填寫資料</span>


                
                
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
        $("#ADF-clear").on('click', function(event) {
            event.preventDefault();
            $("#ADF-name").val("");
            $("#ADF-code").val("");
            $("#ADF-birthday").val("");
            $("#ADF-milidate").val("");
            $("#ADF-type").val("陸軍");
            $("#ADF-status").val("服役中");
            // ADF-name
            // ADF-code
            // ADF-birthday
            // ADF-milidate
            // ADF-type
            // ADF-status
        });








    });
</script>