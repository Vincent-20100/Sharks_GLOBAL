<script language="javascript" type="text/javascript">
	//This object must extends/ HttpRequestBuilder class
	function ServeurRequestBuilder(){
		//both function must override HttpRequestBuilder fonctionName

		newRequest = function(){
			json.setOutputType();
			// Allow zero valued properties to be outputted
			json.setUsePrototypes(false);
			return super.newRequest();
		};

		jsonContent = function(content){
			// Uncomment this line to print each JSON object sent to the server
			//Gdx.app.log("debug", json.prettyPrint(content));
			return super.jsonContent(content);
		};
	}
</script>