<!DOCTYPE html>
<html>
<head lang="zh-TW">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' /> -->
    <title>Login</title>
    <!-- 最新編譯和最佳化的 CSS -->
    <!-- <link rel="stylesheet" type="text/css" href="css/metro-icons.css"> -->
    <link href="/0MS/css/metro.css" rel="stylesheet">
    <link href="/0MS/css/metro-icons.css" rel="stylesheet">
    <link href="/0MS/css/metro-responsive.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="/0MS/js/metro.js"></script>
 
    <style>
        .login-form {
            width: 25rem;
            height: 18.75rem;
            position: fixed;
            top: 50%;
            margin-top: -9.375rem;
            left: 50%;
            margin-left: -12.5rem;
            background-color: #ffffff;
            opacity: 0;
            -webkit-transform: scale(.8);
            transform: scale(.8);
        }
    </style>

    <script>

        /*
        * Do not use this is a google analytics fro Metro UI CSS
        * */
        // if (window.location.hostname !== 'localhost') {

        //     (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        //         (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        //             m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        //     })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        //     ga('create', 'UA-58849249-3', 'auto');
        //     ga('send', 'pageview');

        // }


        $(function(){
            var form = $(".login-form");

            form.css({
                opacity: 1,
                "-webkit-transform": "scale(1)",
                "transform": "scale(1)",
                "-webkit-transition": ".5s",
                "transition": ".5s"
            });
        });
    </script>
</head>
<body class="bg-darkTeal">
    <div class="login-form padding20 block-shadow">
        <form>
            <h1 class="text-light">登入系統</h1>
            <hr class="thin"/>
            <br />
            <div class="input-control text full-size" data-role="input">
                <label for="user_login">帳號:</label>
                <input type="text" name="user_login" id="user_login">
            </div>
            <br />
            <br />
            <div class="input-control password full-size" data-role="input">
                <label for="user_password">密碼:</label>
                <input type="password" name="user_password" id="user_password">
            </div>
            <br />
            <br />
            <div class="form-actions">
                <button type="submit" class="button primary">登入</button>
                <button type="button" class="button link">取消</button>
            </div>
        </form>
    </div>
    <div id="MSG" class="login-form padding20 block-shadow" style="height: 4em; top: calc(50% + 20rem); display: none;"></div>
</body>
<script type="text/javascript">
    $( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        //$("#theForm").ajaxForm({url: 'server.php', type: 'post'})
        if($('#user_login').val() == ""){
            alert("請先輸入帳號!");
            return;
        }
        if($('#user_password').val() == ""){
            alert("請先輸入密碼!");
            return;
        }
        $("#MSG").text("連線中...");
//console.log( $( this ).serialize() );
        $.ajax({
            url: '/welcome/User_Login',
            type: 'post',
            dataType: 'json',
            data: {
                Login_ID: $("#user_login").val(),
                Login_PW: $("#user_password").val()
            },
        })
        .always(function() {
            console.log("complete");
              // remove loading image maybe
        })
        .done(function(responsive) {
            //var result = JSON.parse(responsive);
            console.log(responsive);
            $("#MSG").text(responsive['Msg']);
            $("#MSG").fadeIn('400', function() {        
            });
            if (responsive['Code'] == 1){
                console.log("data_get");
                setTimeout(function(){
                    
                    window.location.href="/";
                 },1000);
            }else{

            }

            console.log("success");
        })
        .fail(function() {
            console.log("error");
        });
      
      

    });


</script>


</html>
