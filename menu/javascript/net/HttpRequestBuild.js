var httpRequest = new HttpRequestBuilder();

function HttpRequestBuilder() {
	/** Will be added as a prefix to each URL when url(String) is called. Empty by default. */
	this.baseUrl = "";
	
	/** Will be set for each new HttpRequest. By default set to {@code 1000}. Can be overwritten via {@link #timeout(int)}. */
	this.defaultTimeout = 1000;
	
	/** Will be used for the object serialization in case {@link #jsonContent(Object)} is called. */
	this.json = new Json();

	this.HttpRequest = null;
}



/** Initializes the builder and sets it up to build a new {@link HttpRequest} . */
HttpRequestBuilder.prototype.newRequest = function() {
	if (httpRequest != null) {
		throw "A new request has already been started. Call \
				HttpRequestBuilder.build() first.";
	}

	httpRequest = new HttpRequest();
	httpRequest.setTimeOut(defaultTimeout);
	return this;
}

/** @see HttpRequest#setMethod(String) */
HttpRequestBuilder.prototype.method = function(httpMethod) {
	this.validate();
	httpRequest.setMethod(httpMethod);
	return this;
}

/** The {@link #baseUrl} will automatically be added as a prefix to the given URL.
 * 
 * @see HttpRequest#setUrl(String) */
HttpRequestBuilder.prototype.url = function(urlString) {
	this.validate();
	httpRequest.setUrl(baseUrl + urlString);
	return this;
}

/** If this method is not called, the {@link #defaultTimeout} will be used.
 * 
 * @see HttpRequest#setTimeOut(int) */
HttpRequestBuilder.prototype.timeout = function(timeOut) {
	this.validate();
	httpRequest.setTimeOut(timeOut);
	return this;
}

/** @see HttpRequest#setFollowRedirects(boolean) */
HttpRequestBuilder.prototype.followRedirects = function(followRedirectsBool) {
	this.validate();
	httpRequest.setFollowRedirects(followRedirectsBool);
	return this;
}

/** @see HttpRequest#setHeader(String, String) */
HttpRequestBuilder.prototype.header = function(name, value) {
	this.validate();
	httpRequest.setHeader(name, value);
	return this;
}

/** @see HttpRequest#setContent(String) */
HttpRequestBuilder.prototype.content = function(contentString) {
	this.validate();
	httpRequest.setContent(contentString);
	return this;
}

/** @see HttpRequest#setContent(java.io.InputStream, long) */
HttpRequestBuilder.prototype.content = function(contentStream, contentLength) {
	this.validate();
	httpRequest.setContent(contentStream, contentLength);
	return this;
}

/** Sets the correct {@code ContentType} and encodes the given parameter map, then sets it as the content. */
HttpRequestBuilder.prototype.formEncodedContent = function(content) {
	this.validate();
	httpRequest.setHeader(HttpRequestHeader.ContentType, "application/x-www-form-urlencoded");
	httpRequest.setContent(HttpParametersUtils.convertHttpParameters(content));
	return this;
}

/** Sets the correct {@code ContentType} and encodes the given content object via {@link #json}, then sets it as the content. */
HttpRequestBuilder.prototype.jsonContent = function(content) {
	this.validate();
	httpRequest.setHeader(HttpRequestHeader.ContentType, "application/json");
	jsonContentString = json.toJson(content);
	httpRequest.setContent(jsonContentString);
	return this;
}

/** Sets the {@code Authorization} header via the Base64 encoded username and password. */
HttpRequestBuilder.prototype.basicAuthentication = function(username, password) {
	this.validate();
	httpRequest.setHeader(HttpRequestHeader.Authorization,
							"Basic " + utf8_to_b64(username + ":" + password));
	return this;
}

/** Returns the {@link HttpRequest} that has been setup by this builder so far. After using the request, it should be returned
 * to the pool via {@code Pools.free(request)}. */
HttpRequestBuilder.prototype.build = function() {
	this.validate();
	HttpRequest request = httpRequest;
	httpRequest = null;
	return request;
}

HttpRequestBuilder.prototype.validate = function() {
	if (httpRequest == null) {
		throw "A new request has not been started yet. Call \
				HttpRequestBuilder.newRequest() first.";
	}
}




function utf8_to_b64( str ) {
  return window.btoa(unescape(encodeURIComponent( str )));
}

function b64_to_utf8( str ) {
  return decodeURIComponent(escape(window.atob( str )));
}
