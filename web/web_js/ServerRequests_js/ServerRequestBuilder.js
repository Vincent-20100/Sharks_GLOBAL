//This object must extends/ HttpRequestBuilder class
//constuctor
function ServeurRequestBuilder(){

}

//Methods
//Both function must extends HttpRequestBuilder
ServeurRequestBuilder.prototype.newRequest = function(){
	json.setOutputType();
	// Allow zero valued properties to be outputted
	json.setUsePrototypes(false);
	return super.newRequest();
}

ServeurRequestBuilder.prototype.jsonContent = function(content){
	// Uncomment this line to print each JSON object sent to the server
	//Gdx.app.log("debug", json.prettyPrint(content));
	if(typeof content != "undefined")
		return super.jsonContent(content);
	else
		return super.jsonContent();
}
