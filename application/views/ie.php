<div id="IE_Checn_DIV" style="position: fixed;top: 0;left: 0;right: 0;bottom: 0;z-index: 9999999999990000;background: white;text-align: center;display: none;">
    <div id="status">
        <h1 class="text-light">您的瀏覽器為舊版IE</h1>
            <hr>
            <br />
            <div class="input-control text full-size" data-role="input">
                <h3>請先安裝插件:</h3>
                <br>
                <a href="\0MS\extensions\GoogleChromeframe.msi"><h3>IE插件-Chrome內核</h3></a>
            </div>
            <br />        
    </div>
</div>
<script>
	//console.log(navigator.userAgent);
	if (navigator.userAgent.match(/MSIE ([5-8]+)\./)) {
		//alert("本系統在IE瀏覽器無法以最佳狀況運作運作!");
		document.getElementById('IE_Checn_DIV').style.display = 'block';
		document.write('<script type="text/undefined">');
	}
</script>