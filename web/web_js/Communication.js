	/*
	this object takes care of the communication between the client and the server
	It also holds all the important variables related to the connection
	*/
	
	function Communication() {
		this.serverURL = "http://povilas.ovh:8080";
		
		this.playerScore = 0;
		this.firstTimer = false;
		this.sessionToken = "";
		
		this.imageId = "";
		
		// a temporary variable for storing server's messages
		this.tmpString = "";
	}
	
	
	/* ============= */
	/* = functions =*/
	/* ============= */
	
	Communication.prototype.getSessionToken = function() {
		return this.sessionToken;
	},
	
	
	Communication.prototype.isFirstTimer = function() {
		return this.firstTimer;
	},
	
	
	//used for initiating the tutorial, regardless of player's history
	Communication.prototype.setFirstTimer = function(flag) {
		this.firstTimer = flag;
	},
	
	
	Communication.prototype.getTmpString = function() {
		return this.tmpString;
	},
	
	
	Communication.prototype.getPlayerScore = function() {
		return playerScore;
	},
	
	
	Communication.prototype.setPlayerScore = function(score) {
		this.playerScore = score;
	}
	
	
	// builds a HttpReauest object from a route and object data
	Communication.prototype.buildRequest = function(route, data) {
		var reqBuilder = new ServerRequestBuilder();
		reqBuilder.newRequest();
		reqBuilder.url(this.serverURL + route);
		reqBuilder.method(HttpMethods.POST);
		reqBuilder.jsonContent(data);
		return reqBuilder.build();
	}
	
	
	/*
	 * Sends a request to authenticate the user
	 * When successful, a session token is received and used to authorise
	 * most requests. This ensures only one instance of the player device
	 * can be logged in.
	 */
	Communication.prototype.logIn = function(username, password){
		var request = this.buildRequest("/login",
									new LoginRequest(username, password));
		var response = new MyHttpResponseListener();
		// TODO Gdx.net.sendHttpRequest(request, response);
		
		while(!response.isResponseReceived());
		
		var serverResponse = -1;
		var status = "";
		
		if(response.getHttpCode() == 200){
			serverResponse = response.getInt("success");
			status = response.getString("message");
			
			if(serverResponse == 1){
				sessionToken = response.getString("token");
				firstTimer = !response.getBoolean("tutorialFinished");
				playerScore = response.getInt("score");
			}
		}
		else{
			status = "Server could not be reached";
		}
		
		return new ServerResponse(serverResponse, status);
	}
	
	/*
	 * Registers a new user in teh database. The user will still not be able to
	 * log in until he activates the account through email
	 */
	Communication.prototype.register = function(username, email, password) {
		var request = this.buildRequest("/register",
								new RegisterRequest(username, email, password));
		var response = new MyHttpResponseListener();
		// TODO Gdx.net.sendHttpRequest(request, response);
		
		while(!response.isResponseReceived());
		
		var serverResponse = -1;
		var status = "";
		
		if(response.getHttpCode() == 200){
			serverResponse = response.getInt("success");
			status = response.getString("message");
		}
		else{
			serverResponse = -1;
			status = "Server could not be reached";
		}
		
		return new ServerResponse(serverResponse, status);
	}
	
	
	/*
	 * This method returns a URL string to the image provided by the server
	 */
	Communication.prototype.requestImage = function() {
		var request = buildRequest("/reqimage",
											new ImageRequest(sessionToken));
		var response = new MyHttpResponseListener();
		// TODO Gdx.net.sendHttpRequest(request, response);
		
		while(!response.isResponseReceived());
		
		var serverStatus = -1;
		var url = "";
		
		if(response.getHttpCode() == 200){
			serverStatus = response.getInt("success");
			if(serverStatus == 1){
				url = response.getString("URL");
				imageId = response.getString("imageId");
			}
		}
		
		return url;
	}
	
	
	/*
	 * Use the image URL to download an image from the server
	 */
	Communication.prototype.fetchImage = function(url){	
		var bucket = null;
		var imageData = [];
		
		var request = new HttpRequest(HttpMethods.GET);
		request.setUrl(url);
		request.setContent(null);
		
		var customListener = new MyHttpResponseListener();
		// TODO Gdx.net.sendHttpRequest(request, customListener);
		
		while(!customListener.isResponseReceived());
		
		imageData = customListener.getData();
		
		// ==TODO== Not supported on HTML platform
		// TODO var pixMap = new Pixmap(imageData, 0, imageData.length);

		// TODO bucket = new Texture(pixMap);
		pixMap.dispose();

		return bucket;
	}
	
	
	/*
	 * Submit all the tags to the server
	 */
	Communication.prototype.uploadTags = function(tags){
		var request = buildRequest("/submittags",
								new TagRequest(sessionToken, imageId, tags));
		var response = new MyHttpResponseListener();
		// TODO Gdx.net.sendHttpRequest(request, response);
		
		while(!response.isResponseReceived());
		
		var success = -1;
		
		if(response.getHttpCode() == 200){
			success = response.getInt("success");
			response.getString("message");
			
			if(success == 1){
				// Synchronize player score with the score on the server
				playerScore = response.getInt("score");
			}
		}
		
		return success == 1;
	}
	
	
	/*
	 * Set a flag on the server,
	 * so that we know the player has gone through the tutorial
	 */
	Communication.prototype.finishTutorial = function(){
		var request = buildRequest("/finishtutorial",
											new SessionRequest(sessionToken));
		var response = new MyHttpResponseListener();
		// TODO Gdx.net.sendHttpRequest(request, response);
		
		while(!response.isResponseReceived());
		
		var success = -1;
		if(response.getHttpCode() == 200){
			success = response.getInt("success");
			response.getString("message");
		}
		
		if(success == 1){
			firstTimer = false;
		}
		
		return success == 1;
	}
	
	
	/*
	 * Auto log in using the session token stored in config file
	 */
	Communication.prototype.autoLogin = function(token){
		var request = buildRequest("/autologin",
											new SessionRequest(token));
		var response = new MyHttpResponseListener();
		// TODO Gdx.net.sendHttpRequest(request, response);
		
		while(!response.isResponseReceived());
		
		var success = -1;
		
		if(response.getHttpCode() == 200){
			success = response.getInt("success");
			
			if(success == 1){
				sessionToken = token;
				playerScore = response.getInt("score");
			}
		}
		
		return success == 1;
	}
	
	
	/*
	 * Log out and remove the session token from the database
	 */
	Communication.prototype.logOut = function(){
		var request = buildRequest("/logout",
											new SessionRequest(sessionToken));
		var response = new MyHttpResponseListener();
		//TODO Gdx.net.sendHttpRequest(request, response);
		
		while(!response.isResponseReceived());
		
		var success = response.getInt("success");
		// TODO Gdx.app.log("debug", response.getString("message"));
		
		if(success == 1){
			sessionToken = "";
		}
		
		return success == 1;
	}
	
	
	/*
	 * Request a recovery code from the server
	 */
	Communication.prototype.recoverPassword = function(username){
		var request = buildRequest("/recoverpassword",
												new RecoveryRequest(username));
		var response = new MyHttpResponseListener();
		// TODO Gdx.net.sendHttpRequest(request, response);
		
		while(!response.isResponseReceived());
		
		var success = -1;
		var message = "";
		
		if(response.getHttpCode() == 200){
			success = response.getInt("success");
			message = response.getString("message");
			if(success == 1){
				tmpString = response.getString("username");
			}
		}
		else{
			success = -1;
			message = "Server could not be reached";
		}
		
		return new ServerResponse(success, message);
	}
	
	
	/*
	 * Use the code to change the password
	 */
	Communication.prototype.recoverPasswordChange = function(username, pass, code){
		var request = buildRequest("/recoverpasswordchange",
									new RecoveryRequest(username, code, pass));
		var response = new MyHttpResponseListener();
		// TODO Gdx.net.sendHttpRequest(request, response);
		
		while(!response.isResponseReceived());
		
		var success = -1;
		var message = "";
		
		if(response.getHttpCode() == 200){
			success = response.getInt("success");
			message = response.getString("message");
		}
		else{
			success = -1;
			message = "Server could not be reached";
		}
		
		return new ServerResponse(success, message);
	}
	
	
	/*
	 * Request a list of top 20 players with their scores
	 */
	Communication.prototype.requestHighscore = function (){
		var request = buildRequest("/leaderboard",
											new SessionRequest(sessionToken));
		var response = new MyHttpResponseListener();
		// TODO Gdx.net.sendHttpRequest(request, response);
		
		while(!response.isResponseReceived());
		
		if(response.getHttpCode() == 200){
			var status = response.getInt("success");
			
			if(status == 1){
				return response.getJsonValue();
			}
		}
		
		return null;
	}
