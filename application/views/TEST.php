<!DOCTYPE html>
<html>

<head lang="zh-TW">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' /> -->
    <title>役男家屬生活扶助系統</title>
    <!-- 最新編譯和最佳化的 CSS -->
    <link rel="stylesheet" href="/0MS/css/bootstrap.css">
    <!-- 選擇性佈景主題 -->
    <link rel="stylesheet" href="/0MS/css/bootstrap-theme.css">
    <!-- <link rel="stylesheet" type="text/css" href="css/metro-icons.css"> -->
    <link rel="stylesheet" href="/0MS/fonts/notosanstc.css">
    <link rel="stylesheet" type="text/css" href="/0MS/extensions/DataTables/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/0MS/images/people/font/flaticon.css">
    <link href="/0MS/css/metro-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/0MS/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="/0MS/css/czchen.css">
    <link rel="stylesheet" type="text/css" href="/0MS/css/czchen-metro.css">
    <script src="/0MS/js/jquery-3.1.0.min.js"></script>
    <script src="/0MS/js/czchen-0.js"></script>
</head>

<body style="overflow: hidden;">
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
                        <a class="navbar-brand" href="#"><img src="/0MS/images/Taichung_White_no_text.svg" style="height: 100%;display: inline-block;position: relative;top: -0.2em;">役男家屬生活扶助</a>
                        <span class="navbar-brand"><?php echo $FullName ?></span>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav" role="tablist">

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="mif-files-empty icon"></span>案件 <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#filelist-navcon" role="tab" data-toggle="tab">待辦案件</a></li>
                                    <li><a href="#">補助中</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">進階查詢</a></li>
                                </ul>
                            </li>
                            <!--<li><a href="#filelist-navcon" role="tab" data-toggle="tab">案件列表 <span class="sr-only">(current)</span></a></li>-->
                            <li class="dropdown" id="family-edit-nav">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="mif-users icon"></span>案件編修 <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                    <li><a href="#edit-home" role="tab" data-toggle="tab">整體家況</a></li>
                                    <li><a href="#edit-navcon" role="tab" data-toggle="tab">家屬編修</a></li>
                                    <li><a href="#" onclick="empty_members()">清空</a></li>
                                    <li><a href="#" onclick="save_file()">儲存</a></li>
                                    <li><a href="#" onclick="read_file(16)">讀取檔案</a></li>
                                    <li><a href="#">不儲存關閉</a></li>
                                </ul>
                            </li>
                            <li><a href="#statistics" role="tab" data-toggle="tab"><span class="mif-chart-bars icon"></span>統計分析 </a></li>
                        </ul>
                        <!--<form class="navbar-form navbar-left">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="快速搜尋">
                            </div>
                            <button type="submit" class="btn btn-default">送出</button>
                        </form>-->
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#" role="tab" data-toggle="tab"><span class="mif-security icon"></span>人事權限</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="mif-apps icon"></span>參考資料 <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#" onclick="$('#Law_1').modal('toggle')">法條參照</a></li>
                                    <li><a href="#" onclick="$('#Law_2').modal('toggle')">地號查地址</a></li>
                                    <li><a href="https://pswst.mol.gov.tw/psdn/" target="_blank">職類薪資</a></li>
                                    <li><a href="#" onclick="$('#Law_3').modal('toggle')">農林漁牧技藝</a></li>
                                    <li><a href="#" onclick="$('#Law_4').modal('toggle')">股票查詢</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </li>
                            <form class="navbar-form navbar-right">
                                <div class="form-group">
                                    <input id="body-zoom" type="number" step= 0.05 class="form-control" placeholder="縮放倍率" value="1.0" style="width: 5em;margin-right: 1em;">
                                </div>
                            </form>
                            <li><a href="/Welcome/User_Logout"><span class="mif-security icon"></span>登出</a></li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav>
        </div>
        <div class="tab-content" id="Home_root">
            <div id="filelist-navcon" role="tabpanel" class="tab-pane active fade in nav-container">
                <?php include('filelist.php');?>
            </div>
            <div id="edit-home" role="tabpanel" class="tab-pane fade nav-container">
                <?php include('people_home.php');?>
            </div>
            <div id="edit-navcon" role="tabpanel" class="tab-pane fade nav-container">
                <?php include('people_basic.php');?>
            </div>
            <div id="statistics" role="tabpanel" class="tab-pane fade nav-container" >
                <?php include('statistics.php');?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="project_edit">編輯</div>
            <div role="tabpanel" class="tab-pane fade" id="project_progress">進度</div>
            <div role="tabpanel" class="tab-pane fade" id="project_search">進階搜尋</div>
        </div>
    </div>
    
    <?php include('Law_1.php');?>
    <?php include('Law_2.php');?>
    <?php include('Law_3.php');?>
    <?php include('Stock.php');?>
    <?php include('add_file_modal.php');?>
    
</body>
<!-- 最新編譯和最佳化的 JavaScript -->

<script src="/0MS/js/bootstrap.min.js"></script>
<script src="/0MS/extensions/DataTables/jquery.dataTables.js"></script>
<script src="/0MS/extensions/DataTables/dataTables.bootstrap.js"></script>
<script src="/0MS/js/moment-with-locales.js"></script>
<script src="/0MS/js/czchen.js"></script>
<script src="/0MS/js/czchen-2.js"></script>
<script type="text/javascript" src="/0MS/js/bootstrap-datetimepicker.js"></script>
<!--<script type="text/javascript" src="js/bootstrap-datetimepicker.zh-TW.js"></script>-->


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.bundle.js"></script>


</html>
