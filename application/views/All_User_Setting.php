<div style="overflow-y: scroll;overflow-x: hidden;height: calc(100% + -5px);width: calc(100% + 1.35em);">
    <style type="text/css">
        .table_C01 th{
            background-color: #ea6153;
            color: white;
            font-weight: 500;
            font-size: 1.5rem;
        }
        .table_C01 td{
            vertical-align: middle !important;
            border-right: 1px solid #2b2b2b;
        }
        .table_C01 tr td:nth-last-child(1){
            border-right: 0px;
            text-align: center;
        }
        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: #f6f6f6;
        }
        .table-striped>tbody>tr:nth-of-type(even) {
            background-color: #d6d6d6;
        }

        #All_User_List > tbody > tr > td:nth-child(8){
            cursor: pointer;
        }
        #All_User_List > tbody {
            font-size: 1.65rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #d0d0d0 !important;
        }
        /*
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
            color: #d0d0d0 !important;
        }*/

        #All_User_List_filter > label > input[type="search"], #Test1_length > label > select{
            color: #333 !important;
        }

        #All_User_Setting .dataTables_wrapper .dataTables_processing {
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(0, 0, 0, 0.9) 25%, rgba(0, 0, 0, 0.9) 75%, rgba(255,255,255,0) 100%);
            line-height: 0em;
        }

        #All_User_Setting tr td:nth-child(5), #All_User_Setting tr td:nth-child(6), #All_User_Setting tr td:nth-child(7) {
            text-align: center;
        }

        .seal{
            border: 1px solid red;
            padding: 1px 5px;
            border-radius: 5px;
            color: red;
        }

    </style>
<div class="container">
    <div class="row" style="margin-top: 100px;">
        <div class="col-md-12">
            <table id = "All_User_List" class="table table-hover table-striped table_C01" style="width: 100%;">
                <thead>
                    <tr>
                        <th>機關</th>
                        <th>單位</th>
                        <th>帳號</th>
                        <th>姓名</th>
                        <th>職稱</th>
                        <th>等級</th>
                        <th>啟用</th>
                        <th>上次登入</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>機關</td>
                        <td>單位</td>
                        <td>帳號</td>
                        <td>姓名</td>
                        <td>職稱</td>
                        <td>等級</td>
                        <td>啟用</td>
                        <td>上次登入</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var t = $('#All_User_List').dataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "/Euser/SQL_basic",
                data: function(data) {
                     data.seprate = $('.btn-group label.active').text().trim();
                     data.dtEnd = "002";
                     data.provincia = "003";
                     data.tipo = "004";
                }
            },
            "columns": [
                { "data": "機關" },
                { "data": "單位" },
                { "data": "User_account" },
                { "data": "User_name" },
                { "data": "User_OU_Title" },
                { "data": "系統等級" },
                { "data": "帳號啟用" },
                { "data": "User_login_time" }
            ],
            "columnDefs": [ 
                {
                    "targets": -2,
                    "data": null,
                    "defaultContent": '<input class="Qswitch" type="checkbox" data-toggle="toggle">',
                    "render": function( data, type, row ) {
                        if( data == 1){
                            return  '<input class="Qswitch" type="checkbox" checked data-toggle="toggle">';    
                        }else{
                            return  '<input class="Qswitch" type="checkbox" data-toggle="toggle">';
                        }
                        
                    }
                },
                {
                    "targets": -3,
                    "data": null,
                    "render": function( data, type, row ) {
                        return '<input value="' + data + '" class="user_level" style="width: 40px;">';                        
                    }
                },
            ],
            createdRow: function( row, data, dataIndex ) {
                $(row).attr('User_id', data.User_id);
            },
            "drawCallback": function(settings, json) {
                $('#All_User_List input.Qswitch').bootstrapToggle();
            },
            "language": {
                "paginate": {
                    "previous": "前頁",
                    "next": "後頁"
                },
                "lengthMenu": "每頁顯示 _MENU_ 筆",
                "info": "第 _PAGE_ / _PAGES_ 頁",
                "search": "粗搜索:",
                "infoFiltered": "(從 _MAX_ 筆資料中過濾出)"
            }
        } );

        $("#seprate_btn label").on('click', '', function(event) {
            console.log($(this).text().trim());
            var t = $('#Test1').DataTable();
            setTimeout(function(){ 
                t.ajax.reload(null, false);
            }, 1000);
        });

        $('#All_User_List').on('change', 'input.Qswitch', function(event) {
            All_User_List_Switch($(this).parents("tr").attr('User_id'), $(this).prop('checked'));
        });

        $('#All_User_List').on('change', 'input.user_level', function(event) {
            All_User_List_Level($(this).parents("tr").attr('User_id'), $(this).val());
        });

        function All_User_List_Level(User_id, User_level){
            $.ajax({
                url: '/Euser/User_Level',
                type: 'post',
                dataType: 'json',
                data: {
                    User_id     : User_id,
                    User_level  : User_level,
                },
            });
        }

        function All_User_List_Switch(User_id, type){
            $.ajax({
                url: '/Euser/User_Switch',
                type: 'post',
                dataType: 'json',
                data: {
                    User_id : User_id,
                    type    : type,
                },
            });
        }
    } );
</script>