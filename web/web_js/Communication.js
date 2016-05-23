	/*
	this object takes care of the communication between the client and the server
	It also holds all the important variables related to the connection
	*/
	
	function Communication() {
		this.serverURL: "http://povilas.ovh:8080";
		
		this.playerScore: 0;
		this.fisrtTimer: false;
		this.sessionToken: "";
		
		this.imageId: "";
		
		// a temporary variable for storing server's messages
		this.tmpString: "";
	}
	
	
	/* ============= */
	/* = functions =*/
	/* ============= */
	
	Communication.prototype.getSessionToken: function() {
		return this.sessionToken;
	},
	
	
	Communication.prototype.isFirstTimer: function() {
		return this.firstTimer;
	},
	
	
	//used for initiating the tutorial, regardless of player's history
	Communication.prototype.setFirstTimer: function(flag) {
		this.firstTimer = flag;
	},
	
	
	Communication.prototype.getTmpString: function() {
		return this.tmpString;
	},
	
	
	Communication.prototype.getPlayerScore: function() {
		return playerScore;
	},
	
	
	Communication.prototype.setPlayerScore: function(score) {
		this.playerScore = score;
	}
	
	
	// builds a HttpReauest object from a route and object data
	Communication.prototype.buildRequest: function(route, data) {
		var reqBuilder = new ServerRequestBuilder();
		reqBuilder.newRequest();
		reqBuilder.url(this.serverURL + route);
		reqBuilder.method(HttpMethods.POST);
		reqBuilderjsonContent(data);
		return reqBuilder.build();
	}
	
	
	/*
	 * Sends a request to authenticate the user
	 * When successful, a session token is received and used to authorise
	 * most requests. This ensures only one instance of the player device
	 * can be logged in.
	 */
	Communication.prototype.logIn(username, password){
		var request = this.buildRequest("/login",
									new LoginRequest(username, password));
		var response = new MyHttpResponseListener();
		/* TODO TODO TODO */
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
