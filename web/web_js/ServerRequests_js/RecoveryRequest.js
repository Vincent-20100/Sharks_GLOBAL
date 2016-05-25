
//constuctor
function RecoveryRequest(username, code, password) {
	this.username = username;
	if(typeof code !== "undefined") {this.code = code;}
	if(typeof password !== "undefined") {this.password = password;}
}

module.exports = RecoveryRequest;