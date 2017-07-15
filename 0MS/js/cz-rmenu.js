//定義案件列表右鍵功能選單的項目和點選後的處理 

    var TArea_code_list = {};       //台中29區列表
    var file_transfer_target = "";  //要轉移到哪個區?(代碼)
  
    //用AJAX更新待處理案件列表右鍵選單的臺中市各區區列表
    $(function() {
        $.ajax({
            url: '/file/get_area_group_list',//------------------------------
            type: 'post',
            dataType: 'json',
        })
        .done(function(responsive) {
            TArea_code_list = responsive[3];
            RMenu_1_set(responsive);
        });
    });

    //設定待處理案件列表右鍵選單項目
    function RMenu_1_set(GG){
        $.contextMenu({
            selector: '#table_id > tbody > tr.LV1-Rmenu', 
            callback: function(key, options) {
                // var m = "clicked: " + key + name;
                // window.console && console.log(m) || alert(m); 
                RMenu_set_1_handl(key,this);
            },
            items: {
                "edit": {name: "修改役男資料", icon: "edit", disabled: function(key, options) { 
                        return parseInt($(this).attr("fnum")) == 1 ? false : true;
                    }},
                "paste": {name: "逕行結案", icon: "paste"
                },
                "delete": {name: "刪除-封存", icon: "delete"},
                "sep1": "---------",
                "transfer1": {
                    name: "案件移交(山)",
                    items: GG[0]
                },
                "transfer2": {
                    name: "案件移交(海)",
                    items: GG[1]
                },
                "transfer3": {
                    name: "案件移交(市屯原)",
                    items: GG[2]
                },
                "sep2": "---------",
                "quit": {name: "關閉", icon: function(){
                    return 'context-menu-icon context-menu-icon-quit';
                }}
            }
        });     
    }

    //設定待處理案件列表右鍵選單點選後的事件處理

    function RMenu_set_1_handl(key,e){
        var file_key = $(e).attr('trkey');
        switch(key) {
            case "edit":
                progress_p_edit_boyfile(file_key,e);
                break;
            case "paste":
                progress_p_directly_close(file_key,e,key);
                break;
            case "delete":
                //code block
                break;
            default:
                //code block
                var isnum = /^\d+$/.test(key);
                if(isnum){
                    //console.log('純數字'); //表示為各區代碼
                    progress_p_transfer(file_key,e,key);
                }
                else{
                //console.log('非純數字');
                }
        }
    }