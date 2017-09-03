/*************************函式庫****************************************/    
    //找出所有img.svg，修改成嵌入式SVG碼，以便著色
    var file_list_refile_pointer = "";
    var CWait_interrupt = 0;

//debugX()
    function debugX(input){
        $.ajax({
            url: '/file/debugX',
            type: 'post',
            dataType: 'json',
            data: {
                debugX        : input,
            },
        });
    }


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

    function date_to_yyy(date_string, trim){ //西元日期轉民國7碼
        trim = typeof trim !== 'undefined' ? trim : 1;
        if(trim == 1){date_string = NTW(date_string);}
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
        date_string = NTW(date_string);
        if(date_string.length == 6){
           var yyyy_date = (parseInt(date_string.substr(0,2))+1911)+"-"+date_string.substr(2,2)+"-"+date_string.substr(4,2);
        }
        else if(date_string.length == 7){
            var yyyy_date = (parseInt(date_string.substr(0,3))+1911)+"-"+date_string.substr(3,2)+"-"+date_string.substr(5,2);
        }
        else{
            console.log("民國日期格式錯誤");
            return false;
        }

        if (Date.parse(yyyy_date)) {
           console.log(yyyy_date);
           return yyyy_date;
        }
        else {
           console.log("非有效日期");
           return false;
        }
        
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

/** 台灣身份證字號格式檢查程式 **/       

    function TW_PersonalCodeCheck(value){
        console.log(value);
        var a = new Array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'W', 'Z', 'I', 'O');
        var b = new Array(1, 9, 8, 7, 6, 5, 4, 3, 2, 1);
        var c = new Array(2);
        var d;
        var e;
        var f;
        var g = 0;
        var h = /^[a-z](1|2)\d{8}$/i;
        if (value.search(h) == -1)
        {
            return false;
        }
        else
        {
            d = value.charAt(0).toUpperCase();
            f = value.charAt(9);
        }
        for (var i = 0; i < 26; i++)
        {
            if (d == a[i])//a==a
            {
                e = i + 10; //10
                c[0] = Math.floor(e / 10); //1
                c[1] = e - (c[0] * 10); //10-(1*10)
                break;
            }
        }
        for (var i = 0; i < b.length; i++)
        {
            if (i < 2)
            {
                g += c[i] * b[i];
            }
            else
            {
                g += parseInt(value.charAt(i - 1)) * b[i];
            }
        }
        if ((g % 10) == f)
        {
            return true;
        }
        if ((10 - (g % 10)) != f)
        {
            return false;
        }
        return true;
    }

    function NTW(value){    //全形轉半形 + 消除空格
        var result = "";
        value = String(value);
        for(i=0; i<value.length; i++){
    　　　　if(value.charCodeAt(i) == 12288 || value.charCodeAt(i) == 32){
    　　　　　　result += "";
    　　　　}else{
    　　　　　　if(value.charCodeAt(i) > 65280 && value.charCodeAt(i) < 65375){
    　　　　　　　　result += String.fromCharCode(value.charCodeAt(i) - 65248);
    　　　　　　}else{
    　　　　　　　　result += String.fromCharCode(value.charCodeAt(i));
    　　　　　　}
    　　　　}
    　　}
    　　return result;
    }

    Date.prototype.yyyymmdd = function() {
      var mm = this.getMonth() + 1; // getMonth() is zero-based
      var dd = this.getDate();

      return [this.getFullYear(),
              "-" + (mm>9 ? '' : '0') + mm,
              "-" + (dd>9 ? '' : '0') + dd
             ].join('');
    };
    function Date_today(year){    //傳回今天日期 2016-05-13 變數調整年
        //為了相容於舊版JS引擎，參數預設值改成在內部定義
          year = typeof year !== 'undefined' ? year : 0;
          //....................................
      var today = new Date();
      // today += (1000 * 60 * 60 * 24) * offsetDay;
      // today = new Date(today);
      var dd = today.getDate();
      var mm = today.getMonth()+1; //January is 0!
      var yyyy = today.getFullYear();
      yyyy = (parseInt(yyyy) + year);
      //console.log(today);
      if(dd<10) {
          dd='0'+dd
      } 
  
      if(mm<10) {
          mm='0'+mm
      } 
  
      today = yyyy+'-'+mm+'-'+dd;
      //console.log(today);
      return today;
    }
    $(document).ready(function() {
        /*$(':input').on('propertychange input', function (e) {
            //console.log(e);
            //console.log(e.target.value);
            var valueChanged = false;

            if (e.type=='propertychange') {
                valueChanged = e.originalEvent.propertyName=='value';
            } else {
                valueChanged = true;
            }
            if (valueChanged) {

                e.target.value=NTW(e.target.value);
            }
        });*/
        $("body").on('change', 'input', function(event) {
            event.preventDefault();
            this.value = NTW(this.value);
            /* Act on the event */
        });
    });



