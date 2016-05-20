<script language="javascript" type="text/javascript">
	//constuctor
	function RecoveryRequest(username, code, password) {
		this.username = username;
		if(typeof code !== "undefined") {this.code = code;}
		if(typeof password !== "undefined") {this.password = password;}
	}
</script>
<noscript>
	<h3> This web site requires JavaScript</h3>
</noscript>