<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #eaa47c;border-top-left-radius: 6px;border-top-right-radius: 6px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body" style="overflow: auto;">
                <br>
                <table style="width: 100%;">
                <thead>
                <tr style="border-bottom: 1px solid black;">
                <th>入伍日期</th>
                <th>行政區</th>
                <th>役男姓名</th>
                <th>役男證號</th>
                <th>案件進度</th>
                <th>審查結果</th>
                <th>立案日期</th>
                <th>主要承辦人</th>
                <th>作業類別</th>
                </tr>
                </thead>
                <tbody>
                <tr role="row" class="odd">
                <td class="sorting_1">103-07-05</td>
                <td>中區</td>
                <td>陳韋帆</td>
                <td>S222</td>
                <td></td>
                <td>丙級2口</td><td>105-11-20 15:26:09</td>
                <td>陳宗儒</td>
                <td>初審</td>
                </tr></tbody></table>
                <br>
                <label for="log_comment">意見批註</label>

                <textarea name="log_comment" id="log_comment" style="width: 100%;height: 5em;"></textarea>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary">送出</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="File_list_View_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="min-width: 95%;">
        <div class="modal-content">
            <div class="modal-header"  style="background-color: #eaa47c;border-top-left-radius: 6px;border-top-right-radius: 6px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="File_list_View_ModalLabel"></h4>
            </div>
            <div class="modal-body" style="height: 80vh;overflow: auto;max-height: calc(80vh - 3em);">
                <div class="panel panel-default">
                    <div class="panel-heading">案件基本資訊</div>
                        <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table style="width: 100%;" class="t1">
                            <thead>
                            <tr style="border-bottom: 1px solid #c5c5c5;background: #ebebeb;">
                            <th style="width: 10%;">入伍日期</th>
                            <th style="width: 10%;">行政區</th>
                            <th style="idth: 10%;">役男姓名</th>
                            <th style="width: 10%;">役男證號</th>
                            <th style="width: 15%;">案件進度</th>
                            <th style="width: 10%;">審查結果</th>
                            <th style="width: 15%;">立案日期</th>
                            <th style="width: 10%;">主要承辦人</th>
                            <th style="width: 10%;">作業類別</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr role="row" class="odd">
                            <td class="sorting_1">103-07-05</td>
                            <td>中區</td>
                            <td>陳韋帆</td>
                            <td>S222</td>
                            <td></td>
                            <td>丙級2口</td><td>105-11-20 15:26:09</td>
                            <td>陳宗儒</td>
                            <td>初審</td>
                            </tr></tbody>
                        </table>
                        <br/><br/>
                        <table style="width: 100%;" class="t2">
                            <thead>
                            <tr style="border-bottom: 1px solid #c5c5c5;background: #ebebeb;">
                            <th style="width: 10%;">役男生日</th>
                            <th style="width: 10%;">服役軍種</th>
                            <th style="width: 10%;">服役梯次</th>
                            <th style="width: 10%;">家屬電話</th>
                            <th style="width: 25%;">電子信箱</th>
                            <th style="width: 35%;">戶籍地址</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr role="row" class="odd">
                            <td class="sorting_1">103-07-05</td>
                            <td>中區</td>
                            <td>陳韋帆</td>
                            <td>S222</td>
                            <td>陳宗儒</td>
                            <td>初審</td>
                            </tr></tbody>
                        </table>
                    </div>
                        <!-- /.panel-body -->
                </div>
                <div class="panel panel-warning">
                    <div class="panel-heading">案件批核歷程</div>
                        <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table name="view_log_comment" id="view_log_comment" class="table-striped" style="width: 100%;">
                        <thead>
                        <tr style="border-bottom: 1px solid #c5c5c5;">
                        <th>日期時間</th>
                        <th>批核者</th>
                        <th>動作名稱</th>
                        <th>批核後案件進度</th>
                        <th>批核意見</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                        </table>
                    </div>
                        <!-- /.panel-body -->
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">案件家庭概況</div>
                        <!-- /.panel-heading -->
                    <div class="panel-body">
        <table border="1" bordercolor="DarkGrey" style="text-align: center;width: 100%;">
        <tbody><tr>
        <td colspan="2" class="bg-success" style="border-right: 2px solid #a2a2a2;">動產</td>
        <td colspan="4" class="bg-success" style="border-right: 2px solid #a2a2a2;">不動產</td>
        <td colspan="3" class="bg-success" style="border-right: 2px solid #a2a2a2;">所得</td>
        <td class="bg-success" style="border-right: 2px solid #a2a2a2;">全戶</td>
        </tr>
        <tr>
        <td>存款</td>
        <td style="border-right: 2px solid #a2a2a2;">投資</td>
        <td>房屋棟數</td>
        <td>房屋總價</td>
        <td>列計棟數</td>
        <td style="border-right: 2px solid #a2a2a2;">列計價值</td>
        <td>薪資</td>
        <td>營利</td>
        <td style="border-right: 2px solid #a2a2a2;">財產</td>
        <td>列計人口</td>
        </tr>
        <tr>
        <td>$<span id="FView-PH-Deposits">0</span></td>
        <td style="border-right: 2px solid #a2a2a2;">$<span id="FView-PH-Investment">0</span></td>
        <td><span id="FView-PH-Houses">0</span>棟</td>
        <td>$<span id="FView-PH-Houses-total">0</span></td>
        <td><span id="FView-PH-Houses-num">0</span>棟</td>
        <td style="border-right: 2px solid #a2a2a2;">$<span id="FView-PH-Houses-listtotal">0</span></td>
        <td>$<span id="FView-PH-Salary">0</span></td>
        <td>$<span id="FView-PH-Profit">0</span></td>
        <td style="border-right: 2px solid #a2a2a2;">$<span id="FView-PH-Property-int">0</span></td>
        <td><span id="FView-PH-members">1</span>人</td>
        </tr>
        <tr>
        <td>證券</td>
        <td style="border-right: 2px solid #a2a2a2;">其他</td>
        <td>土地筆數</td>
        <td>土地總值</td>
        <td>列計筆數</td>
        <td style="border-right: 2px solid #a2a2a2;">列計價值</td>
        <td>利息</td>
        <td>股利</td>
        <td style="border-right: 2px solid #a2a2a2;">其他</td>
        <td>生活所需</td>
        </tr>
        <tr>
        <td>$<span id="FView-PH-Securities">0</span></td>
        <td style="border-right: 2px solid #a2a2a2;">$<span id="FView-PH-others-Pro">0</span></td>
        <td><span id="FView-PH-Land">0</span>筆</td>
        <td>$<span id="FView-PH-Land-total">0</span></td>
        <td><span id="FView-PH-Land-num">0</span>筆</td>
        <td style="border-right: 2px solid #a2a2a2;">$<span id="FView-PH-Land-listtotal">0</span></td>
        <td>$<span id="FView-PH-Bank-int">0</span></td>
        <td>$<span id="FView-PH-Stock-int">0</span></td>
        <td style="border-right: 2px solid #a2a2a2;">$<span id="FView-PH-others-int">0</span></td>
        <td>$<span id="FView-PH-need">19626</span></td>
        </tr>
        <tr>
        <td colspan="2" style="border-right: 2px solid #a2a2a2;">動產列計總額</td>
        <td colspan="4" style="border-right: 2px solid #a2a2a2;">不動產列計總額</td>
        <td colspan="3" style="border-right: 2px solid #a2a2a2;">月均所得總額</td>
        <td>扶助等級</td>
        </tr>
        <tr>
        <td colspan="2" style="border-right: 2px solid #a2a2a2;">$<span id="FView-PH-total-pro">0</span></td>
        <td colspan="4" style="border-right: 2px solid #a2a2a2;">$<span id="FView-PH-total-imm">0</span></td>
        <td colspan="3" style="border-right: 2px solid #a2a2a2;">$<span id="FView-PH-total-inc">0</span></td>
        <td><span id="FView-PH-level">甲級1口</span></td></tr>
    </tbody></table> 
                </div>
                        <!-- /.panel-body -->
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">案件家況敘述</div>
                        <!-- /.panel-heading -->
                    <div class="panel-body">
                    <span style="cursor: pointer;" onclick="$('#Law_PDF').modal('toggle')"><span style="color:red;">(新功能)</span>PDF檔太小，閱讀困難嗎?</span>
                    
                <hr class="thin" style="clear: left;"/>    
    <div class="h4-label-btn-group" id="View-att-0" afile="">
        <h4><span class="label label-danger">戶口名簿</span></h4>
        <div class="btn-group" role="group" aria-label="...">
          <button type="button" class="b1 btn btn-danger">直接瀏覽</button>
          <a type="button" class="b2 btn btn-danger" target="_blank">外部開啟</a>
        </div>
    </div>
    <div class="h4-label-btn-group" id="View-att-1" afile="">
        <h4><span class="label label-warning">所得證明</span></h4>
        <div class="btn-group" role="group" aria-label="...">
          <button type="button" class="b1 btn btn-warning">直接瀏覽</button>
          <a type="button" class="b2 btn btn-warning" target="_blank">外部開啟</a>
        </div>
    </div>
    <div class="h4-label-btn-group" id="View-att-2" afile="">
        <h4><span class="label label-info">財產證明</span></h4>
        <div class="btn-group" role="group" aria-label="...">
          <button type="button" class="b1 btn btn-info">直接瀏覽</button>
          <a type="button" class="b2 btn btn-info" target="_blank">外部開啟</a>
        </div>
    </div>
    <div class="h4-label-btn-group" id="View-att-3" afile="">
        <h4><span class="label label-success">在學與就醫證明</span></h4>
        <div class="btn-group" role="group" aria-label="...">
          <button type="button" class="b1 btn btn-success">直接瀏覽</button>
          <a type="button" class="b2 btn btn-success" target="_blank">外部開啟</a>
        </div>
    </div>
    <div class="h4-label-btn-group" id="View-att-4" afile="">
        <h4><span class="label label-primary">其他資料</span></h4>
        <div class="btn-group" role="group" aria-label="...">
          <button type="button" class="b1 btn btn-primary">直接瀏覽</button>
          <a type="button" class="b2 btn btn-primary" target="_blank">外部開啟</a>
        </div>
    </div>
    <hr class="thin" style="clear: left;"/>
    <!--<hr class="thin"/>-->
    <div style="width: 40%; display: inline-block;vertical-align: top;">
        <div style="width: 100%;">
            <label style="width: 20em;"><h3 style="margin-top: 0px;">整體家況敘述-區公所</h3></label>
            <textarea style="width: 96%;height: 30em;" id="FView-PH-file_comm_1" disabled></textarea>
        </div><div style="width: 100%;">
            <label style="width: 20em;"><h3>整體家況敘述確認-市政府</h3></label>
            <textarea  style="width: 96%;height: 30em;"  id="FView-PH-file_comm_2" disabled></textarea>
        </div>
    </div><div style="width: 60%; display: inline-block;vertical-align: top;"><h3 style="margin-top: 0px;margin-bottom: 15px;">PDF檔案</h3><iframe id="pdf_viewer" src="" style="width: 100%;height: 100vh; display: inline-block;"></iframe></div>
                    </div>
                        <!-- /.panel-body -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
                <!--<button type="button" class="btn btn-primary">送出</button>-->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="RefileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="min-width: 80em;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #eaa47c;border-top-left-radius: 6px;border-top-right-radius: 6px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="RefileModalLabel" style="font-weight: 600;"></h4>
            </div>
            <div class="modal-body">
                <br><br><br><br>
                <table style="width: 100%;">
                <thead>
                <tr style="border-bottom: 1px solid black;">
                <th>入伍日期</th>
                <th>行政區</th>
                <th>役男姓名</th>
                <th>役男生日</th>
                <th>身分證號</th>
                <th>審查結果</th>
                <th style="padding-right: 1em;">已服役日數</th>
                <th>主要承辦人</th>
                <th>作業類別</th>
                </tr>
                </thead>
                <tbody>
                <tr role="row" class="odd">
                <td class="sorting_1">103-07-05</td>
                <td>中區</td>
                <td>陳韋帆</td>
                <td>S222</td>
                <td></td>
                <td>丙級2口</td>
                <td style="padding-right: 1em;">105-11-20 15:26:09</td>
                <td>陳宗儒</td>
                <td>初審</td>
                </tr></tbody></table>
                <br><br><br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary">確定新增</button>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .disableS {
        background-color: #ebebe4;
        color: #333333;
        border: 1px solid darkgrey;
        height: 1.75em;
    }
</style>
<div class="modal fade" id="ReEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #eaa47c;border-top-left-radius: 6px;border-top-right-radius: 6px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ReEditModalLabel" style="font-weight: bolder;">案件役男資料修改</h4>
            </div>
            <div class="modal-body" style="overflow: auto;">
            <div style="width: 50%; background-color: #fdebeb; height: 35em; float: left; padding: 1em;">
                <div class="input-control text full-size" data-role="input">
                    <label for="CE-Old-name">役男姓名:</label>
                    <input type="text" name="CE-Old-name" id="CE-Old-name" placeholder="(必填)" disabled="disabled">
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-Old-code">身份字號:</label>
                    <input type="text" name="CE-Old-code" id="CE-Old-code" placeholder="(必填)" disabled="disabled">
                </div>

                <div class="input-control password full-size" data-role="input">
                    <label for="CE-Old-birthday">役男生日:</label>
                    <input type="text" name="CE-Old-birthday" id="CE-Old-birthday" placeholder="7位數民國日期(必填)" disabled="disabled">
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-Old-milidate">入伍日期:</label>
                    <input type="text" name="CE-Old-milidate" id="CE-Old-milidate" placeholder="7位數民國日期(必填)" disabled="disabled">
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-Old-echelon">服役梯次:</label>
                    <input type="text" name="CE-Old-echelon" id="CE-Old-echelon" placeholder="" disabled="disabled">
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-Old-address">戶籍地址:</label>
                    <select name="CE-Old-county" id="CE-Old-county" class="disableS" disabled="disabled"><option value="66000" >臺中市</option></select><select name="CE-Old-town" id="CE-Old-town" class="disableS" disabled="disabled"></select><select name="CE-Old-village" id="CE-Old-village" style="width: 5.6em;" class="disableS"  disabled="disabled"></select><input type="text" name="CE-Old-address" id="CE-Old-address" style="width:20em" placeholder="(必填)" disabled="disabled">
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-Old-type">服役役別:</label>
                    <!--<input type="text" name="user_password" id="user_password">-->
                    <select name="CE-Old-type" id="CE-Old-type"  class="disableS"  disabled="disabled"></select>
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-Old-status">服役狀態:</label>
                    <select name="CE-Old-status" id="CE-Old-status" class="disableS"  disabled="disabled"></select>
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-Old-phone">家屬電話:</label>
                    <input type="text" name="CE-Old-phone" id="CE-Old-phone" placeholder="" disabled="disabled">
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-Old-email">電子信箱:</label>
                    <input type="text" name="CE-Old-email" id="CE-Old-email" placeholder="" style="width: 20em;" disabled="disabled">
                </div>
            </div>
<!--**********************************************************************************************************-->
            <div id= "REM-New" style="width: 50%; background-color: #d1d1ff; height: 35em; float: left; padding: 1em;">
                <div class="input-control text full-size" data-role="input">
                    <label for="CE-New-name">役男姓名:</label>
                    <input type="text" name="CE-New-name" id="CE-New-name" placeholder="(必填)" style="outline-color: #ad00ff;">
                    <button class="button helper-button clear" onclick="$('#CE-New-name').val($('#CE-Old-name').val())"><span class="mif-undo"></span></button>
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-New-code">身份字號:</label>
                    <input type="text" name="CE-New-code" id="CE-New-code" placeholder="(必填)">
                    <button class="button helper-button clear" onclick="$('#CE-New-code').val($('#CE-Old-code').val())"><span class="mif-undo"></span></button>
                </div>
<?php  
//***************************************************************************************************************
if($Browser == "Internet Explorer"){    
?>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-New-birthday">役男生日:</label>
                    <input type="text" name="CE-New-birthday" id="CE-New-birthday" placeholder="(範例)1990-03-05">
                    <button class="button helper-button clear" onclick="$('#CE-New-birthday').val('')"><span class="mif-undo"></span></button>
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-New-milidate">入伍日期:</label>
                    <input type="text" name="CE-New-milidate" id="CE-New-milidate" placeholder="(範例)2017-09-13">
                    <button class="button helper-button clear" onclick="$('#CE-New-milidate').val('')"><span class="mif-undo"></span></button>
                </div>

<?php 
}else{  //**********************************************************************************************************
?>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-New-birthday">役男生日:</label>
                    <input type="date" name="CE-New-birthday" id="CE-New-birthday" placeholder="西元年-月-日" val="1986-5-3" style="width: 11.15em;">
                    <button class="button helper-button clear" onclick="$('#CE-New-birthday').val($('#CE-Old-birthday').val());"><span class="mif-undo"></span></button>
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-New-milidate">入伍日期:</label>
                    <input type="date" name="CE-New-milidate" id="CE-New-milidate" placeholder="西元年-月-日" style="width: 11.15em;">
                    <button class="button helper-button clear" onclick="$('#CE-New-milidate').val($('#CE-Old-milidate').val());"><span class="mif-undo"></span></button>
                </div>
<?php 
}   //***************************************************************************************************************
?>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-New-echelon">服役梯次:</label>
                    <input type="text" name="CE-New-echelon" id="CE-New-echelon" placeholder="(選填)">
                    <button class="button helper-button clear" onclick="$('#CE-New-echelon').val($('#CE-Old-echelon').val());"><span class="mif-undo"></span></button>
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-New-address">戶籍地址:</label>
                    <select name="CE-New-county" id="CE-New-county" style="height: 1.75em;"><option value="66000">臺中市</option></select><select name="CE-New-town" id="CE-New-town" style="height: 1.75em;"></select><select name="CE-New-village" id="CE-New-village" style="width: 5.6em; height: 1.75em;"></select><input type="text" name="CE-New-address" id="CE-New-address" style="width:20em" placeholder="(必填)">
                    <button class="button helper-button clear" onclick="ENAddrCopy();"><span class="mif-undo"></span></button>
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-New-type">服役役別:</label>
                    <!--<input type="text" name="user_password" id="user_password">-->
                    <select name="CE-New-type" id="CE-New-type" style="height: 1.75em; width: 11.15em; margin-right: 0.25em;"></select><button class="button helper-button clear" onclick="$('#CE-New-type').val('')"><span class="mif-undo"></span>
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-New-status">服役狀態:</label>
                    <select name="CE-New-status" id="CE-New-status" style="height: 1.75em; width: 11.15em; margin-right: 0.25em;"><option value="服役中">服役中</option><option value="停役中">停役中</option><option value="已退役">已退役</option></select><button class="button helper-button clear" onclick="$('#CE-New-status').val($('#CE-Old-status').val())"><span class="mif-undo"></span>
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-New-phone">家屬電話:</label>
                    <input type="text" name="CE-New-phone" id="CE-New-phone" placeholder="(可多筆)">
                    <button class="button helper-button clear" onclick="$('#CE-New-phone').val($('#CE-Old-phone').val());"><span class="mif-undo"></span></button>
                </div>
                <div class="input-control password full-size" data-role="input">
                    <label for="CE-New-email">電子信箱:</label>
                    <input type="text" name="CE-New-email" id="CE-New-email" placeholder="(選填)" style="width: 20em;">
                    <button class="button helper-button clear" onclick="$('#CE-New-email').val($('#CE-Old-email').val());"><span class="mif-undo"></span></button>
                </div>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary">更新</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //檢視案件資訊面板，開啟時先把IFRAME的PDF清除
    $(".b1").on('click', function(event) {
        event.preventDefault();
        var afile_name = $(this).parents(".h4-label-btn-group").attr('afile');
        $("#pdf_viewer").attr('src', '/uploads/'+afile_name);
    });



    //**************************************************
    $(document).ready(function(){
        ENfresh_town();
    });


    
    $('#CE-New-town').on('change', function(event) {//更新村里下拉選單
        ENfresh_village();
    });

    function ENfresh_town(){
            $('#CE-New-town').empty();
            $.ajax({
                url: '/area/get_town_by_county',
                type: 'post',
                dataType: 'json',
                data: {
                    ADF_county        : $("#CE-New-county").val()
                },
            })
            .done(function(responsive_) {
                var responsive = responsive_['town_list'];
                var seloption = "";
                console.log(responsive.length);
                var i=0;
                $.each(responsive, function(index, record){
                    seloption += '<option value="'+record.Town_code+'">'+record.Town_name+'</option>';
                    i++;
                    if(i == responsive.length){
                        $('#CE-New-town').append(seloption);
                        setTimeout(function(){
                            if(User_Level <= 3){
                                $("#ADF-town").val($("#CE-New-town option:contains('"+organization+"')").val()).prop('disabled',true).css('background', '#d6d6d6');
                                setTimeout(function(){
                                    $('#CE-New-town').trigger('change');
                                },500);
                            }else{
                                $('#CE-New-town').trigger('change');
                            }
                        },500);
                    }

                });
                
                
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            });//更新區鎮下拉選單
    }

    function ENfresh_village(){
        //$("#theForm").ajaxForm({url: 'server.php', type: 'post'})
        $('#CE-New-village').empty();
        //$("#MSG").text("連線中...");
        $.ajax({
            url: '/area/get_village_by_town',
            type: 'post',
            dataType: 'json',
            data: {
                ADF_town        : $("#CE-New-town").val()
            },
        })
        .always(function() {
            console.log("complete");
        })
        .done(function(responsive_) {
            var responsive = responsive_['village_list'];
            var seloption = "";
            var i=0;
            $.each(responsive, function(index, record){
                seloption += '<option value="'+record.Village_id+'">'+record.Village_name+'</option>';
                i++;
                if(i == responsive.length){
                    setTimeout(function(){
                        $('#CE-New-village').val($('#CE-Old-village').val()).trigger('change');
                    },500);
                }
            });

            $('#CE-New-village').append(seloption);
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        }); //更新村里下拉選單
    }

    function ENAddrCopy(){
        $('#CE-New-town').val($('#CE-Old-town').val()).trigger('change');
    }
    function ENAllReset(){
        $("#REM-New button").each(function(index, el) {
            $(this).trigger('click');
        });
    }
</script>