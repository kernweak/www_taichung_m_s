/*************************函式庫****************************************/    
    //找出所有img.svg，修改成嵌入式SVG碼，以便著色
    var file_list_refile_pointer = "";
    var CWait_interrupt = 0;

    function CWait_Start(wait_time, msg){
        //為了相容於舊版JS引擎，參數預設值改成在內部定義
        wait_time = typeof wait_time !== 'undefined' ? wait_time : 1000;
        msg = typeof msg !== 'undefined' ? msg : "與系統連線中...";
        //...........................................
        setTimeout(function(){
            if(!CWait_interrupt){
                $("#cortana_wait").fadeIn();
                $("#cortana_wait_msg").text(msg);
            }
            CWait_interrupt = 0;
        },wait_time);        
    }

    function CWait_End(wait_time){
        //為了相容於舊版JS引擎，參數預設值改成在內部定義
        wait_time = typeof wait_time !== 'undefined' ? wait_time : 0;
        //...........................................
        setTimeout(function(){
            CWait_interrupt = 1;
            $("#cortana_wait").stop().fadeOut();
        },wait_time);
        setTimeout(function(){
            CWait_interrupt = 0;
        },1050);
    }

    function personnel_load(){

        $("#personnel > iframe").attr('src', 'http://mms.taichung.gov.tw/aup654rm6284gj4rm4/');
    }

    //讓JQuery的delay可以接受call back function
    $.fn.delay = function(time, callback) {
        // Empty function:
    jQuery.fx.step.delay = function() { };
        // You can set the second argument as CSS properties
        if (typeof callback == "object")
        {
            var cssObj = callback;
            callback = function() { $(this).css(cssObj); }
        }
        // Return meaningless animation, (will be added to queue)
        return this.animate({ delay: 1 }, time, callback);
    }

    //重繪SVG成內碼以著色--- 準備用CSS內嵌SVG圖檔，以減少讀取
    function svg_redraw(){
        jQuery('img.svg').each(function() {
            var $img = jQuery(this);
            var imgID = $img.attr('id');
            var imgClass = $img.attr('class');
            var imgURL = $img.attr('src');

            jQuery.get(imgURL, function(data) {
                // Get the SVG tag, ignore the rest
                var $svg = jQuery(data).find('svg');

                // Add replaced image's ID to the new SVG
                if (typeof imgID !== 'undefined') {
                    $svg = $svg.attr('id', imgID);
                }
                // Add replaced image's classes to the new SVG
                if (typeof imgClass !== 'undefined') {
                    $svg = $svg.attr('class', imgClass + ' replaced-svg');
                }

                // Remove any invalid XML tags as per http://validator.w3.org
                $svg = $svg.removeAttr('xmlns:a');

                // Replace image with new SVG
                $img.replaceWith($svg);

            }, 'xml');
        });
    }

    function date_to_yyy(date_string){ //西元日期轉民國7碼
        //date_string = "2016-05-03";
        var date_a = date_string.split("-");
        var yyy_date = (parseInt(date_a[0])-1911) + date_a[1] + date_a[2];
        if(yyy_date.length==6){
            yyy_date = "0" + yyy_date;
        }
        //console.log(yyy_date);
        return yyy_date;
    }
    //date_to_yyy();
    //yyy_to_date();

    function yyy_to_date(date_string){  //民國6/7碼轉西元日期
        //date_string = "1040310";
        date_string += "";
        if(date_string.length == 6){
           var yyyy_date = (parseInt(date_string.substr(0,2))+1911)+"-"+date_string.substr(2,2)+"-"+date_string.substr(4,2);
        }
        if(date_string.length == 7){
            var yyyy_date = (parseInt(date_string.substr(0,3))+1911)+"-"+date_string.substr(3,2)+"-"+date_string.substr(5,2);
        }
        //console.log(yyyy_date);
        return yyyy_date;
    }

    function yyy_dash(date_string){  //1050305 -> 105-03-05
        //date_string = "1040310";
        date_string += "";
        date_string = date_string.substring(0,3) + "-" + date_string.substring(3,5) + "-" + date_string.substring(5);
        return date_string;
    }

    function dash_yyy(date_string){  //105-03-05 -> 1050305
        //
        var date_a = date_string.split("-");
        var date_b = ""+date_a[0]+date_a[1]+date_a[2];
        return date_b;
    }

    if (!String.prototype.trimall) {            //去除所有空白
      String.prototype.trimall = function () {
        return this.replace(/\s+/g, "");
      };
    }

    Array.prototype.max = function() {      //取出陣列最大最小值

      return Math.max.apply(null, this);
    };

    Array.prototype.min = function() {

      return Math.min.apply(null, this);
    };

    //將檔案路徑轉換成只有檔名
    function baseName(str){
       var base = new String(str).substring(str.lastIndexOf('/') + 1); 
        if(base.lastIndexOf(".") != -1)       
            base = base.substring(0, base.lastIndexOf("."));
       return base;
    }

    function numberWithCommas(x) {  //numberWithCommas  轉換成有千分號的數字字串
        x = x + "";
        x = x.replace(/,/g , "");
        x = x.replace(/！/g , "");   // 個人面板上的！標記代表強制以最低薪資所得計算
        if((typeof stringValue) != "string"){
            x = parseInt(x);
            x = x.toString();
        }else{
            x = x.replace(/,/g , "");
        }
        return x.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function noCommas(x) {  //消除數字字串的千分號
        x = x + "";
        x = x.replace(/,/g , "");
        return x;
    }



