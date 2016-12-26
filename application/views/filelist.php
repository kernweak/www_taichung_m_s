<a type="button" class="btn btn-warning btn-sm" style="margin-bottom: 2em;" href="#" onclick="$('#Add_file').modal('toggle')">新增案件</a>
<table id="table_id" class="table table-condensed table-hover">
    <thead>
        <tr>
            <th>入伍日期</th>
            <th>行政區</th>
            <th>役男姓名</th>
            <th>役男證號</th>
            <th>案件進度</th>
            <th>審查結果</th>
            <th>立案日期</th>
            <th>主要承辦人</th>
            <th>作業類別</th>
            <th style="width: 18em; min-width: 17em;">可選用操作</th>
        </tr>
    </thead>
    <tbody>
        <tr trkey="1"><td>090-10-10</td><td>中區</td><td>pp</td><td>s122895</td><td><div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 16.6667%;">公所-承辦人處理</div></div></td><td>甲級1口</td><td>105-11-11 10:05:28</td><td>陳霈曦</td><td>初審</td><td style="min-width: 190px;"><div class="btn-group" role="group" aria-label="..."><div class="btn-group" role="group"><button type="button" class="btn btn-primary" onclick="progress_view(1,this)">檢視</button></div><div class="btn-group" role="group"><button type="button" class="btn btn-success" onclick="read_file_test(1)">編輯</button></div><div class="btn-group" role="group"><button type="button" class="btn btn-warning" onclick="progress_p_back(1,this)">退回</button></div><div class="btn-group" role="group"><button type="button" class="btn btn-danger" onclick="progress_p_next(1,this)">呈核</button></div><div class="btn-group" role="group"><button type="button" class="btn btn-info" onclick="progress_p_patch(1,this)">補件</button></div></div></td></tr>
    </tbody>
</table>