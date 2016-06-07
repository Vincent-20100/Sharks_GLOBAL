<!DOCTYPE html>
<html>
<head>
	<title>test AJAX</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
</head>
<body>
	<script>
	/*
		window.onload = function() {
			document.getElementById("abc").onclick = function() {
				alert("Salut les patates !!");
			};
		}
		
		
		
		
		$.cliquer = function() {
			alert("Salut les patates !!");
		};
		$("#abc").attr("onclick", $.cliquer);
		
	*/
		
	</script>




	<!--
	<div>
		<input id="abc" name="abcButton" type="button" value="test jquery">
		<input type="button" onclick="request('/login', readData_connectVincent, 'POST', new LoginRequest('20100', '123'));" value="connectVincent">
		<span id="resultConnectVincent"></span>
	</div>
	
	-->
	<div>
		<input type="button" onclick="request('/SharksTag/getAnImage.php');" value="getImage">
		<div id="resultGetImage"></div>
	</div>
	<!--
	<script src="web_js/ServerRequests_js/LoginRequest.js"></script>
	<script src="web_js/Communication.js"></script>
	<script src="web_js/ServerRequests_js/ServerRequestBuilder.js"></script>
		-->
	<script src="web_js/net/XmlHttpRequest.js"></script>

	<noscript>
		<h3> This web site requires JavaScript</h3>
	</noscript>
</body>
</html>
