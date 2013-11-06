<!-- BEGIN: DEVTOOLS -->
<script type="text/javascript">
$(document).ready(function () {
    $("#devtoolbox .hover").draggable({ containment: "html", scroll: true }).click(
  function () {
     $("#devtoolbox ul.file_menu").stop().toggle("fold");
  });
  $("#devtoolbox ul.file_menu button").click(function(e) {
        e.stopPropagation();
   });
});
var devtools_disable_autologin = {PHP.devtools.disable_autologin};
function devtools_ajax(type, setting) 
{
	if(type == 'autologin')
	{
		devtools_disable_autologin = setting;
		ajaxSuccessHandlers = [function(msg) { $('#devtoolbox .status').hide().html(msg).slideDown(500).delay(2000).slideUp(500, function() { $("#devtoolbox .hover").click(); })}];
		ajaxErrorHandlers = [function(msg) { $('#devtoolbox .status').hide().html(msg).slideDown(500).delay(2000).slideUp(500, function() { $("#devtoolbox .hover").click(); })}];
		ajaxSend({
			url: 'index.php?r=devtools&m='+type+'&a='+devtools_disable_autologin,
			nonshowloading: true,
			nonshowfadein: true,
		});
	}
}
</script>
<style>
#devtoolbox {
    height: 32px;
	top: 0;
	right: 0;
	position: fixed;
	z-index:9999;
}

#devtoolbox ul, li {
    margin:0; 
    padding:0; 
    list-style:none;
}

#devtoolbox .status {
	display: none;
	width:323px;
	text-align:center;
	background-color: #000;
	border-top-left-radius: 50px;
	border-top-right-radius: 50px;
}

#devtoolbox .status .success {
	color:green;
}

#devtoolbox .status .error {
	color:red;
}

#devtoolbox .menu_class {
    border:1px solid #1c1c1c;
	float: right;
}

#devtoolbox .file_menu {
	text-align:center;
    display:none;
    width:300px;
	padding:10px;
	position:overlap!important;
    border: 1px solid #1c1c1c;
	z-index: -1;
	float:right!important;
	background-color: #302f2f;
}

#devtoolbox .file_menu li {
    background-color: #302f2f;
}

#devtoolbox .file_menu li a {
    color:#FFFFFF; 
    text-decoration:none; 
    padding:10px; 
    display:block;
}

#devtoolbox .file_menu li a:hover {
    padding:10px;
    font-weight:bold;
    color: #F00880;
}
</style>
<div id="devtoolbox">
	<ul class="hover">
		<li class="status"></li>
		<li class="hoverli">
			<img src="plugins/devtools/devtools.png" width="32" height="32" class="menu_class" />
			<ul class="file_menu">
				<li><button id="devtools_autologin" onclick="devtools_ajax('autologin', 0)">Enable Auto-Login</button> <button id="devtools_autologin" onclick="devtools_ajax('autologin', 1)">Disable Auto-Login</button></li>
				<li><button id="devtools_autologin" onclick="devtools_ajax('autologin')">Auto-Login</button></li>
				<li><button id="devtools_autologin" onclick="devtools_ajax('autologin')">Auto-Login</button></li>
				<li><button id="devtools_autologin" onclick="devtools_ajax('autologin')">Auto-Login</button></li>
				<li><button id="devtools_autologin" onclick="devtools_ajax('autologin')">Auto-Login</button></li>
			</ul>
		</li>
	</ul>
</div>
<!-- END: DEVTOOLS -->