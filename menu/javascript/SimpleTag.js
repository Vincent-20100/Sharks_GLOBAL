
function SimpleTag(posX, posY){
	this.position = [posX, posY];
	this.size = [50, 50];
	this.sharkId = 0;
}

SimpleTag.prototype.getSharkId = function(){
	return this.sharkId = 0;
}

SimpleTag.prototype.setSharkId = function(id){
	this.sharkId = id;
}

SimpleTag.prototype.getSize = function(){
	return this.size;
}

SimpleTag.prototype.setSize = function(X, Y){
	this.size = [X, Y];
}

/*
 * Return true or false depending if the thresold is bigger than the distance 
 * between the two vectors
 */
SimpleTag.prototype.overlap = function(other, threshold){
	var a1 = (this.position[0]-other.position[0]);
	var b1 = (this.position[1]-other.position[1]);
	var dst1 = Math.sqrt(a1*a1 + b1*b1);
	//var dst1 = dst(this.position, other.position)

	var a2 = (this.position[0]+this.size[0])-(other.position[0]+other.size[0]);
	var b2 = (this.position[1]+this.size[1])-(other.position[1]+other.size[1]);
	var dst2 = Math.sqrt(a2*a2 + b2*b2);
	//var dst2 = dst(this.position+this.size, other.position+other.size )

	// Compare the distance between the the two vectors and vectors + size with the threshold value
	if((dst1 <= threshold) && (dst2 <= threshold)){
		return true;
	}
	else{
		return false;
	}
}

/*
 * Give the distance between two points
 */
function dst(point1, point2){
	var a1 = (point1[0]-point2[0]);
	var b1 = (point1[1]-point2[1]);
	return = Math.sqrt(a1*a1 + b1*b1);
}

module.exports = SimpleTag;