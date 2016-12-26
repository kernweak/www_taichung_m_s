<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="min-width: 95%;width: 99%;height: 100%;margin: 10px auto;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #eaa47c;border-top-left-radius: 6px;border-top-right-radius: 6px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body" style="height: 86vh;overflow: auto;">
                <br><br><br><br>
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
                <br><br><br>
                <label for="log_comment">意見批註</label>

                <textarea name="log_comment" id="log_comment" style="width: 100%;height: 15em;"></textarea>



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
            <div class="modal-body" style="height: 80vh;overflow: auto;">
                <table style="width: 80%;">
                <thead>
                <tr style="border-bottom: 1px solid #c5c5c5;">
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
                <label for="view_log_comment"><h3>批核歷程</h3></label>
                <table name="view_log_comment" id="view_log_comment" style="width: 80%;">
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
        <br>
        <label for="view_log_comment"><h3>家庭概況</h3></label>
        <table border="1" style="text-align: center;width: 80%;">
        <tbody><tr>
        <td colspan="2" style="background-color: #ced790;">動產</td>
        <td colspan="4" style="background-color: #90c5d7;">不動產</td>
        <td colspan="3" style="background-color: #d79b90;">所得</td>
        <td style="background-color: #d490d7;">全戶</td>
        </tr>
        <tr>
        <td>存款</td>
        <td>投資</td>
        <td>房屋棟數</td>
        <td>房屋總價</td>
        <td>列計棟數</td>
        <td>列計價值</td>
        <td>薪資</td>
        <td>營利</td>
        <td>財產</td>
        <td>列計人口</td>
        </tr>
        <tr>
        <td>$<span id="FView-PH-Deposits">0</span></td>
        <td>$<span id="FView-PH-Investment">0</span></td>
        <td><span id="FView-PH-Houses">0</span>棟</td>
        <td>$<span id="FView-PH-Houses-total">0</span></td>
        <td><span id="FView-PH-Houses-num">0</span>棟</td>
        <td>$<span id="FView-PH-Houses-listtotal">0</span></td>
        <td>$<span id="FView-PH-Salary">0</span></td>
        <td>$<span id="FView-PH-Profit">0</span></td>
        <td>$<span id="FView-PH-Property-int">0</span></td>
        <td><span id="FView-PH-members">1</span>人</td>
        </tr>
        <tr>
        <td>證券</td>
        <td>其他</td>
        <td>土地筆數</td>
        <td>土地總值</td>
        <td>列計筆數</td>
        <td>列計價值</td>
        <td>利息</td>
        <td>股利</td>
        <td>其他</td>
        <td>生活所需</td>
        </tr>
        <tr>
        <td>$<span id="FView-PH-Securities">0</span></td>
        <td>$<span id="FView-PH-others-Pro">0</span></td>
        <td><span id="FView-PH-Land">0</span>筆</td>
        <td>$<span id="FView-PH-Land-total">0</span></td>
        <td><span id="FView-PH-Land-num">0</span>筆</td>
        <td>$<span id="FView-PH-Land-listtotal">0</span></td>
        <td>$<span id="FView-PH-Bank-int">0</span></td>
        <td>$<span id="FView-PH-Stock-int">0</span></td>
        <td>$<span id="FView-PH-others-int">0</span></td>
        <td>$<span id="FView-PH-need">19626</span></td>
        </tr>
        <tr>
        <td colspan="2">動產列計總額</td>
        <td colspan="4">不動產列計總額</td>
        <td colspan="3">月均所得總額</td>
        <td>扶助等級</td>
        </tr>
        <tr>
        <td colspan="2">$<span id="FView-PH-total-pro">0</span></td>
        <td colspan="4">$<span id="FView-PH-total-imm">0</span></td>
        <td colspan="3">$<span id="FView-PH-total-inc">0</span></td>
        <td><span id="FView-PH-level">甲級1口</span></td></tr>
    </tbody></table>
    <br><br><br>
    <hr class="thin"/>
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
    </div><div style="width: 60%; display: inline-block;vertical-align: top;"><h3 style="margin-top: 0px;margin-bottom: 15px;">PDF測試</h3><iframe id="pdf_viewer" src="" style="width: 100%;height: 100vh; display: inline-block;"></iframe></div>
    <br/>
    <hr class="thin"/>
    




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
<script type="text/javascript">
    $(".b1").on('click', function(event) {
        event.preventDefault();
        var afile_name = $(this).parents(".h4-label-btn-group").attr('afile');
        $("#pdf_viewer").attr('src', '/uploads/'+afile_name);
    });
</script>