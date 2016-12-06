<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="min-width: 80em;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
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
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="File_list_View_ModalLabel"></h4>
            </div>
            <div class="modal-body" style="height: 70vh;overflow: auto;">
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
        <table border="1" style="text-align: center;">
        <tbody><tr>
        <td colspan="2" style="background-color: #ced790;">動產</td>
        <td colspan="4" style="background-color: #90c5d7;">不動產</td>
        <td colspan="3" style="background-color: #d79b90;">所得</td>
        <td style="background-color: #d490d7;">全戶</td>
        </tr>
        <tr>
        <td>存款Deposits</td>
        <td>投資Investment</td>
        <td>房屋棟數Houses</td>
        <td>房屋總價Houses-total</td>
        <td>列計棟數Houses-num</td>
        <td>列計價值Houses-listtotal</td>
        <td>薪資Salary</td>
        <td>營利Profit</td>
        <td>財產Property-int</td>
        <td>列計人口members</td>
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
        <td>證券Securities</td>
        <td>其他others-Pro</td>
        <td>土地筆數Land</td>
        <td>土地總值Land-total</td>
        <td>列計筆數Land-num</td>
        <td>列計價值Land-listtotal</td>
        <td>利息Bank-int</td>
        <td>股利Stock-int</td>
        <td>其他others-int</td>
        <td>生活所需need</td>
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
        <td colspan="2">動產列計總額total-pro</td>
        <td colspan="4">不動產列計總額total-imm</td>
        <td colspan="3">月均所得總額total-inc</td>
        <td>扶助等級</td>
        </tr>
        <tr>
        <td colspan="2">$<span id="FView-PH-total-pro">0</span></td>
        <td colspan="4">$<span id="FView-PH-total-imm">0</span></td>
        <td colspan="3">$<span id="FView-PH-total-inc">0</span></td>
        <td><span id="FView-PH-level">甲級1口</span></td></tr>
    </tbody></table>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary">送出</button>
            </div>
        </div>
    </div>
</div>

