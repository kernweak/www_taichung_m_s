<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head lang="zh-TW">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=IE8,chrome=IE7">
    <meta name="viewport" content="">
    <!-- <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' /> -->
    <title>役男家屬生活扶助系統</title>
    <!-- 最新編譯和最佳化的 CSS -->
    <link rel="stylesheet" href="/0MS/css/bootstrap.min.css">
    <!-- 選擇性佈景主題 -->
    <link rel="stylesheet" href="/0MS/css/bootstrap-theme.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="css/metro-icons.css"> -->
    <!--<link rel="stylesheet" href="/0MS/fonts/notosanstc.css">-->
    <link rel="stylesheet" type="text/css" href="/0MS/extensions/ContextMenu/jquery.contextMenu.min.css">

    <link rel="stylesheet" type="text/css" href="/0MS/extensions/DataTables/dataTables.bootstrap.min.css">
    <!--<link rel="stylesheet" type="text/css" href="/0MS/images/people/font/flaticon.css">-->
    <link href="/0MS/css/metro-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/0MS/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="/0MS/css/czchen-2017-02-07.css?<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="/0MS/css/czchen-metro.css">
    <link rel="stylesheet" type="text/css" href="/0MS/css/bootstrap-toggle.min.css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="/0MS/js/czchen-0.js?<?php echo time(); ?>"></script>
    <script src="/0MS/js/cz-progress.js?<?php echo time(); ?>"></script>
    <script src="/0MS/js/cz-pre-edit-file.js?<?php echo time(); ?>"></script>
    <script src="/0MS/js/cz-ReadFiles-list.js?<?php echo time(); ?>"></script>
    <script src="/0MS/js/cz-Fmenu.js?<?php echo time(); ?>"></script>
    <script src="/0MS/js/bootstrap-toggle.min.js"></script>
    <script>
        var User_Level = <?php echo $User_Level ?>;
        var organization = '<?php echo $organization ?>';
        var FullName = '<?php echo $FullName ?>';
    </script>
</head>

<body style="overflow: hidden;">
<?php include('ie.php');?>
<div id="preloader">
    <div id="status">
        <img /><div id = "Floading"></div><h1 class="noSubtitle">系統載入中</h1>
    </div>
</div>

<div id="cortana_wait" style="display: none;">
    <div id="cortana_wait_cont">
        <div id="cortana_wait_icon"></div><div id="cortana_wait_msg">與系統連線中...</div>
    </div>
</div>

    <div role="tabpanel">
        <div>
            <nav class="navbar navbar-brown navbar-fixed-top">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#" style="width: 152px;"><img src="/0MS/images/Taichung_White_no_text.svg" style=""><span>役男家屬<br>生活扶助</span></a>
                        <span class="navbar-brand"><?php echo $organization."-".$FullName ?></span>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" role="tablist">
                        <ul class="nav navbar-nav" style="width: calc(98.5% - 280px);">

                            <li class="dropdown" id="file-list-nav">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="mif-files-empty icon"></span>案件 <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#filelist-navcon" role="tab" data-toggle="tab" onclick="">待辦案件</a></li>
                                    <li><a href="#filelist-progress" role="tab" data-toggle="tab" onclick="read_file_list_progress()">呈核中案件</a></li>
                                    <li><a href="#filelist-supporting" role="tab" data-toggle="tab" onclick="read_file_list_supporting()">補助中案件</a></li>
                                    <li><a href="#filelist-Fail" role="tab" data-toggle="tab" onclick="read_file_list_fail()">資格不符案件</a></li>
                                    <li><a href="#filelist-Delete" role="tab" data-toggle="tab" onclick="read_file_list_delete()">已刪除之案件</a></li>
                                    
                                    <!--<li><a href="#">已結案案件</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">進階查詢</a></li>-->
                                </ul>
                            </li>
                            <!--<li><a href="#filelist-navcon" role="tab" data-toggle="tab">案件列表 <span class="sr-only">(current)</span></a></li>-->
                            <li class="dropdown" id="family-edit-nav" style="display: none;">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="mif-users icon"></span>案件編修 <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                    <li><a href="#edit-home" role="tab" data-toggle="tab">整體家況</a></li>
                                    <li><a href="#edit-navcon" role="tab" data-toggle="tab">家屬編修</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#" onclick="save_file()">儲存案件</a></li>
                                    <li><a id="reload_file_button" href="#" onclick="reload_file()">放棄修改-重新載入</a></li>
                                    <li><a href="#" onclick="close_file()">放棄修改-關閉案件</a></li>
                                    <li role="separator" class="divider"></li>
                                    <!--<li><a href="#" onclick="add_miliboy()">家屬編修-加入役男</a></li>-->
                                    <?php if($User_Level == 1 || $User_Level >= 4 ){  ?>
                                    <li><a id="Access_Print_botton" href="/Report/Access_Print_Form/" target="_blank">紙本簽核單</a></li>
                                    <?php }  ?>

                                </ul>
                            </li>
                            <li><a href="#statistics" role="tab" data-toggle="tab"><span class="mif-chart-bars icon"></span>統計分析 </a></li>




                        <!--</ul>-->
                        <!--<form class="navbar-form navbar-left">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="快速搜尋">
                            </div>
                            <button type="submit" class="btn btn-default">送出</button>
                        </form>-->
                        <!--<ul class="nav navbar-nav navbar-right">-->
                            <li class="navbar-right"><a href="/Welcome/User_Logout"><span class="mif-security icon"></span>登出</a></li>
                            <li class="dropdown navbar-right">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="mif-apps icon"></span>參考資料 <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#" onclick="$('#Law_1').modal('toggle')">法條參照</a></li>
                                    <!--<li><a href="#" onclick="$('#Law_2').modal('toggle')">地號查地址</a></li>-->
                                    <li><a href="http://easymap.land.moi.gov.tw/R02/Index" target="_blank">地號查地址</a></li>
                                    <li><a href="https://pswst.mol.gov.tw/psdn/" target="_blank">職類薪資</a></li>
                                    <li><a href="#" onclick="$('#Law_3').modal('toggle')">農林漁牧技藝</a></li>
                                    <li><a href="#" onclick="$('#Law_4').modal('toggle')">股票查詢</a></li>
                                    <li><a href="#" onclick="$('#Law_5').modal('toggle')">106年度各縣市低收入戶限制</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#" onclick="$('#Law_PDF').modal('toggle')">PDF設定教學</a></li>
                                    
                                    <!--<li role="separator" class="divider"></li>
                                    <li><a href="#">Separated link</a></li>-->
                                </ul>
                            </li>
                            <!--<form class="navbar-form navbar-right">
                                <div class="form-group">
                                    <input id="body-zoom" type="number" step= 0.05 class="form-control" placeholder="縮放倍率" value="1.0" style="width: 5em;margin-right: 1em;">
                                </div>
                            </form>-->
                            <?php if($SSO == 0 || $User_Level >= 4){  ?>
                            <li class="dropdown navbar-right">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="mif-security icon"></span>人事權限 <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php if($SSO == 0){  ?>
                                    <li><a href="#personnel" role="tab" data-toggle="tab">修改密碼</a></li>
                                    <?php }  ?>
                                    <?php if($User_Level >= 4){  ?>
                                    <li><a href="#All_User_Setting" role="tab" data-toggle="tab">帳號權限設定</a></li>
                                    <?php }  ?>
                                    <!--<li role="separator" class="divider"></li>
                                    <li><a href="#">Separated link</a></li>-->
                                </ul>
                            </li>
                            <?php }  ?>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav>
        </div>
        <div class="tab-content" id="Home_root">
            <div id="filelist-navcon"       role="tabpanel" class="tab-pane active fade in nav-container"><h2>我目前的待辦辦案件</h2>
                <?php include('filelist.php');?>
            </div>
            <div id="filelist-progress"     role="tabpanel" class="tab-pane fade nav-container"><h2>流程進行中之案件</h2>
                <?php include('filelist_in_progress.php');?>
            </div>
            <div id="filelist-supporting"   role="tabpanel" class="tab-pane fade nav-container"><h2>審核通過之案件</h2>
                <?php include('filelist_supporting.php');?>
            </div>
            <div id="filelist-Fail"         role="tabpanel" class="tab-pane fade nav-container"><h2>資格不符之案件</h2>
                <?php include('filelist_fail.php');?>
            </div>
            <div id="filelist-Delete"         role="tabpanel" class="tab-pane fade nav-container"><h2>已刪除之案件</h2>
                <?php include('filelist_delete.php');?>
            </div>
            <div id="edit-home" role="tabpanel" class="tab-pane fade nav-container" style="overflow-y: scroll;height: 100vh;">
                <?php include('people_home.php');?>
            </div>
            <div id="edit-navcon" role="tabpanel" class="tab-pane fade nav-container">
                <?php include('people_basic.php');?>
            </div>
            <div id="statistics" role="tabpanel" class="tab-pane fade nav-container" style="overflow-y: scroll;height: 100vh;background-color: #4280bf;padding-bottom: 10vh;">
                <?php include('statistics.php');?>
            </div>
            <div id="personnel" role="tabpanel" class="tab-pane fade nav-container" style="overflow-y: scroll;height: 100vh;">
                <?php include('changePW.php');?>
            </div>
            <?php if($User_Level >= 4){  ?>
             <div id="All_User_Setting" role="tabpanel" class="tab-pane fade nav-container" style="height: 100vh;">
                <?php include('All_User_Setting.php');?>
            </div>
            <?php }  ?>
            <div role="tabpanel" class="tab-pane fade" id="project_edit">編輯</div>
            <div role="tabpanel" class="tab-pane fade" id="project_progress">進度</div>
            <div role="tabpanel" class="tab-pane fade" id="project_search">進階搜尋</div>
            <?php include('filelist_modal.php');?>
        </div>
    </div>
    
    <?php include('Law_1.php');?>
    <?php //include('Law_2.php');?>
    <?php include('Law_3.php');?>
    <?php include('Stock.php');?>
    <?php include('Law_5.php');?>
    <?php //include('Law_PDF.php');?>
    
    <?php include('add_file_modal.php');?>
    
</body>
<!-- 最新編譯和最佳化的 JavaScript -->

<script src="/0MS/js/bootstrap.min.js"></script>
<script src="/0MS/extensions/DataTables/jquery.dataTables.min.js"></script>
<script src="/0MS/extensions/DataTables/dataTables.bootstrap.js"></script>
<script src="/0MS/js/moment-with-locales.min.js"></script>
<script src="/0MS/js/cz-rmenu.js?<?php echo time(); ?>"></script>
<script src="/0MS/js/czchen.js?<?php echo time(); ?>"></script>
<!--<script src="/0MS/js/czchen-2.js?<?php echo time(); ?>"></script>-->
<script type="text/javascript" src="/0MS/js/bootstrap-datetimepicker.js"></script>
<script src="/0MS/extensions/ContextMenu/jquery.contextMenu.min.js"></script>
<script src="/0MS/extensions/ContextMenu/jquery.ui.position.min.js"></script>
<!--<script type="text/javascript" src="js/bootstrap-datetimepicker.zh-TW.js"></script>-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.bundle.js"></script>
<script type="text/javascript">
//隔一段時間後，會自動登出
$(document).ready(function () {
    //Increment the idle time counter every minute.

    var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
});
var idleTime = 0;
function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime >= <?php echo $Auto_Logout_Time ?>) { // 20 minutes 發呆->登出  
        window.location.href = "/Welcome/User_Logout";
    }
}
</script>
