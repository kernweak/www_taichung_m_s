<a type="button" class="btn btn-warning btn-sm" style="margin-bottom: 2em;" href="#" onclick="$('#Add_file').modal('toggle')">新增案件</a>
<table id="table_id" class="table table-condensed table-hover">
    <thead>
        <tr>
            <th style="width: 8em;">入伍日期</th>
            <th style="width: 7em;">行政區</th>
            <th style="width: 7em;">役男姓名</th>
            <th style="width: 7.5em;">役男證號</th>
            <th style="width: 12em;">案件進度</th>
            <th style="width: 8em;">審查結果</th>
            <th style="width: 7em;">立案日期</th>
            <th style="width: 7em;">主要承辦人</th>
            <th>作業類別</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            
            <td>1030000137</td>
            <td>西屯區公所</td>
            <td>歐陽鋒</td>
            <td>A323456789</td>
            <td>
                <div class="progress">
                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
                        <span style="display:none;">20</span>收案
                    </div>
                </div>
            </td>
            <td>審核中</td>
            <td>103/05/29</td>
            <td>朱元璋</td>
            <td>案二弟有大學甄試入學錄取證明，目前為高中生</td>
        </tr>
        <tr>
            
            <td>1030000139</td>
            <td>大里區公所</td>
            <td>廖添丁</td>
            <td>S223456789</td>
            <td>
                <div class="progress">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
                        <span style="display:none;">40</span>公所初審
                    </div>
                </div>
            </td>
            <td>審核中</td>
            <td>103/05/27</td>
            <td>荊軻</td>
            <td></td>
        </tr>
        <tr onclick="$('#myModal').modal('toggle')">
            
            <td>1030000140
            </td>
            <td>豐原區公所</td>
            <td>王大陸</td>
            <td>L123456789</td>
            <td>
                <div class="progress">
                    <div class="progress-bar  progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                        <span style="display:none;">60</span>民政局複審
                    </div>
                </div>
            </td>
            <td>初審-乙級4口</td>
            <td>103/05/25</td>
            <td>張三豐</td>
            <td>案父車禍住院中, 04/13入院, 有附診斷證明</td>
        </tr>
        <tr>
            
            <td>1030000142</td>
            <td>神岡區公所</td>
            <td>林平之</td>
            <td>L323456789</td>
            <td>
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                        <span style="display:none;">100</span>結案
                    </div>
                </div>
            </td>
            <td>甲級4口</td>
            <td>103/05/29</td>
            <td>韋小寶</td>
            <td></td>
        </tr>
        <tr>
            
            <td>1030000145</td>
            <td>潭子區公所</td>
            <td>黃飛鴻</td>
            <td>L328656789</td>
            <td>
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                        <span style="display:none;">100</span>結案
                    </div>
                </div>
            </td>
            <td>丙級6口</td>
            <td>103/06/27</td>
            <td>詹天佑</td>
            <td></td>
        </tr>
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><span>1030000137</span></span><span>初審-乙級4口</span><span>王大陸</span><span>L123456789</span><span class="modal-cite" style="margin: 0; font-size: 0.8em; color: #666;">豐原區公所，承辦：<cite title="Source Title">聶隱娘</cite></span>
                        </h4>
            </div>
            <div class="modal-body">
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">版本紀錄</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">最新詳資</a></li>
                        <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
                        <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <h4><p style="font-size: 0.8em; text-align: right;"><ins>立案時間:103-05-07 10:33:29</ins></p> </h4>
                            <hr>
                            <div style="max-height: 55vh; overflow-y: scroll;">
                                <table id="myModal-table_id" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="">版號</th>
                                            <th style="">開啟</th>
                                            <th style="">源號</th>
                                            <th style="width: 25%;">進度</th>
                                            <th style="">編修日期</th>
                                            <th style="">編修機關/人</th>
                                            <th style="">審查結果</th>
                                            <th style="">備註</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">14</th>
                                            <td>
                                                <button type="button" class="btn btn-sm glyphicon glyphicon-folder-open" style="" />
                                            </td>
                                            <td>11
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar  progress-bar-info" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%;">
                                                        <span style="display:none;">60</span>民政局複審
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2014-03-02
                                                <br>14:23:35</td>
                                            <td>豐原區公所
                                                <br>張三豐</td>
                                            <td>初審-乙級4口</td>
                                            <td>影像上傳</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">13</th>
                                            <td>
                                                <button type="button" class="btn btn-sm glyphicon glyphicon-folder-open" style="" />
                                            </td>
                                            <td>11
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar  progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                        <span style="display:none;">60</span>民政局複審
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2014-03-02
                                                <br>14:23:35</td>
                                            <td>豐原區公所
                                                <br>張三豐</td>
                                            <td>初審-乙級4口</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">12</th>
                                            <td>
                                                <button type="button" class="btn btn-sm glyphicon glyphicon-folder-open" style="" />
                                            </td>
                                            <td>11
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar  progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                        <span style="display:none;">60</span>民政局複審
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2014-03-02
                                                <br>14:23:35</td>
                                            <td>豐原區公所
                                                <br>張三豐</td>
                                            <td>初審-乙級4口</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">11</th>
                                            <td>
                                                <button type="button" class="btn btn-sm glyphicon glyphicon-folder-open" style="" />
                                            </td>
                                            <td>10
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar  progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                        <span style="display:none;">60</span>民政局複審
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2014-03-02
                                                <br>14:23:35</td>
                                            <td>豐原區公所
                                                <br>張三豐</td>
                                            <td>初審-乙級4口</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">10</th>
                                            <td>
                                                <button type="button" class="btn btn-sm glyphicon glyphicon-folder-open" style="" />
                                            </td>
                                            <td>9
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar  progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                        <span style="display:none;">60</span>民政局複審
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2014-03-02
                                                <br>14:23:35</td>
                                            <td>豐原區公所
                                                <br>張三豐</td>
                                            <td>初審-乙級4口</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">9</th>
                                            <td>
                                                <button type="button" class="btn btn-sm glyphicon glyphicon-folder-open" style="" />
                                            </td>
                                            <td>8
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar  progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                        <span style="display:none;">50</span>區所初審
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2014-03-02
                                                <br>14:23:35</td>
                                            <td>豐原區公所
                                                <br>張三豐</td>
                                            <td></td>
                                            <td>補上母親房產資料</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">8</th>
                                            <td>
                                                <button type="button" class="btn btn-sm glyphicon glyphicon-folder-open" style="" />
                                            </td>
                                            <td>5
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar  progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                        <span style="display:none;">50</span>區所初審
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2014-03-02
                                                <br>14:23:35</td>
                                            <td>民政局
                                                <br>張無忌</td>
                                            <td></td>
                                            <td>家屬財產資料請補齊</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">7</th>
                                            <td>
                                                <button type="button" class="btn btn-sm glyphicon glyphicon-folder-open" style="" />
                                            </td>
                                            <td>3
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar  progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                                        <span style="display:none;">50</span>區所初審
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2014-03-02
                                                <br>14:23:35</td>
                                            <td>豐原區公所
                                                <br>張三豐</td>
                                            <td>初審-乙級4口</td>
                                            <td>稅籍資料補上</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">6</th>
                                            <td>
                                                <button type="button" class="btn btn-sm glyphicon glyphicon-folder-open" style="" />
                                            </td>
                                            <td>4
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar  progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
                                                        <span style="display:none;">40</span>區所編案
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2014-03-02
                                                <br>14:23:35</td>
                                            <td>豐原區公所
                                                <br>張三豐</td>
                                            <td>初審-乙級4口</td>
                                            <td>稅籍資料補上</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">5</th>
                                            <td>
                                                <button type="button" class="btn btn-sm glyphicon glyphicon-folder-open" style="" />
                                            </td>
                                            <td>4
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar  progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
                                                        <span style="display:none;">40</span>區所編案
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2014-03-02
                                                <br>14:23:35</td>
                                            <td>豐原區公所
                                                <br>張三豐</td>
                                            <td>初審-乙級4口</td>
                                            <td>稅籍資料補上</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td>
                                                <button type="button" class="btn btn-sm glyphicon glyphicon-folder-open" style="" />
                                            </td>
                                            <td>3
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar  progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
                                                        <span style="display:none;">40</span>區所編案
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2014-03-02
                                                <br>14:23:35</td>
                                            <td>豐原區公所
                                                <br>張三豐</td>
                                            <td>初審-乙級4口</td>
                                            <td>稅籍資料補上</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>
                                                <button type="button" class="btn btn-sm glyphicon glyphicon-folder-open" style="" />
                                            </td>
                                            <td>2
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar  progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
                                                        <span style="display:none;">40</span>區所編案
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2014-03-02
                                                <br>14:23:35</td>
                                            <td>豐原區公所
                                                <br>張三豐</td>
                                            <td>初審-乙級4口</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>
                                                <button type="button" class="btn btn-sm glyphicon glyphicon-folder-open" style="" />
                                            </td>
                                            <td>1
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar  progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
                                                        <span style="display:none;">40</span>區所編案
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2014-02-26
                                                <br>11:13:07</td>
                                            <td>豐原區公所
                                                <br>滅絕師太</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>
                                                <button type="button" class="btn btn-sm glyphicon glyphicon-folder-open" style="" />
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar  progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
                                                        <span style="display:none;">20</span>收件
                                                    </div>
                                                </div>
                                            </td>
                                            <td>2014-02-25
                                                <br>10:05:35</td>
                                            <td>豐原區公所
                                                <br>張三豐</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            <h4>詳細資訊</h4>
                            <table id="myModal-table_id" class="table table-condensed table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 2.8em;">#</th>
                                        <th style="width: 8em;">案件文號</th>
                                        <th style="width: 7em;">承辦機關</th>
                                        <th style="width: 7em;">役男姓名</th>
                                        <th style="width: 7.5em;">役男證號</th>
                                        <th style="width: 8em;">審查結果</th>
                                        <th style="width: 7em;">立案日期</th>
                                        <th style="width: 7em;">主要承辦人</th>
                                        <th>備註</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>1030000137
                                        </td>
                                        <td>豐原區公所</td>
                                        <td>張三豐</td>
                                        <td>L123456789</td>
                                        <td>初審-乙級4口</td>
                                        <td>103/05/25</td>
                                        <td>聶隱娘</td>
                                        <td>@mdo</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="messages">...</div>
                        <div role="tabpanel" class="tab-pane" id="settings">...</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
