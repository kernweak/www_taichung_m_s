    <style>
        .login-form {
            width: 25em;
            height: 27.75em;
            position: fixed;
            top: 50%;
            margin-top: -16.375em;
            left: 50%;
            margin-left: -12.5em;
            background-color: #fbd8bc;
            opacity: 0;
            -webkit-transform: scale(.8);
            transform: scale(.8);
            padding: 1em;
        }
        .login-form input{
            width: 100%;
        }
    </style>

    <script>
        $(function(){
            var form = $(".login-form");
            form.css({
                opacity: 1,
                "-webkit-transform": "scale(1)",
                "transform": "scale(1)",
                "-webkit-transition": "1.5s",
                "transition": "1.5s",
                "box-shadow": "2px 2px 15px",
                "border-radius": "10px"
            });
        });
    </script>
<div class="bg-darkTeal">
    <div class="login-form padding20 block-shadow">
        <form>
            <h1 class="text-light">修改密碼</h1>
            <hr class="thin"/>
            <br />
            <div class="input-control text full-size" data-role="input">
                <label for="user_password0">原密碼:</label>
                <br />
                <input type="password" name="user_password0" id="user_password0">
            </div>
            <br />
            <div class="input-control password full-size" data-role="input">
                <label for="user_password">新密碼:</label>
                <br />
                <input type="password" name="user_password" id="user_password">
            </div>
            <br />
            <div class="input-control password full-size" data-role="input">
                <label for="user_password2">再次輸入新密碼:</label>
                <br />
                <input type="password" name="user_password2" id="user_password2">
            </div>
            <br />
            <br />
            <div class="form-actions">
                <button type="submit" class="button primary">登入</button>
                <button type="button" class="button link">取消</button>
            </div>
        </form>
    </div>
    <div id="MSG" class="login-form padding20 block-shadow" style="height: 4em; top: calc(50% + 29em); display: none;background-color: rgb(102, 200, 158);"></div>
</div>
<script type="text/javascript">
    $( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        //$("#theForm").ajaxForm({url: 'server.php', type: 'post'})
        if($('#user_password0').val() == ""){
            alert("請先輸入舊密碼!");
            return;
        }
        if($('#user_password').val() == ""){
            alert("請先輸入新密碼!");
            return;
        }
        if($('#user_password2').val() == ""){
            alert("請再次輸入新密碼!");
            return;
        }
        if($('#user_password').val() != $('#user_password2').val()){
            alert("兩次輸入的新密碼不一樣唷!");
            return;
        }
        $("#MSG").text("連線中...");
//console.log( $( this ).serialize() );
        $.ajax({
            url: '/welcome/User_changePW',
            type: 'post',
            dataType: 'json',
            data: {
                Login_PW0: $("#user_password0").val(),
                Login_PW1: $("#user_password").val(),
                Login_PW2: $("#user_password2").val()
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
            setTimeout(function(){
                window.location.href="/";
            },2500);

            /*if (responsive['Code'] == 1){
                console.log("data_get");
                setTimeout(function(){
                    
                    window.location.href="/";
                },3000);
            }else{

            }*/
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        });
    });
</script>
