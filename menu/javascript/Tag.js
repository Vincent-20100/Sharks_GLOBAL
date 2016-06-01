
var SimpleTag = require('SimpleTag');

function Tag(x, y, imgSize, imgScale){
	super(x, y); // TODO change

	this.active = true;
	
	this.resizing = false;
	this.moving = false;
	
	this.text = "";
	this.textLayout  = new GlyphLayout(); // TODO change
	
	this.imgSize = imgSize;
	this.imgScale = imgScale;
	
	//where the image ends on the screen
	this.leftBoundary = (854 / 2) - (imgSize.x / 2);
	this.rightBoundary = (854 / 2) + (imgSize.x / 2);
	this.bottomBoundary = 50;

}

// TODO make Tag inherit SimpleTag and see how to do the compareTo
Tag.inherits(SimpleTag);
Tag.constructor = SimpleTag()
Tag.prototype.method = function ('toString', func) {
    this.prototype['toString'] = func;
    return this;
}

Tag.prototype.compareTo = function(obj){
	if(obj instanceof Tag){
		return  parseInt(getArea() - obj.getArea());
	}
	else{
		//TODO log 
		//Gdx.app.log("debug", obj.getClass().toString());
		return 0;
	}
	
}


Tag.prototype.toString = function(){
	return position.toString() + " " + size.toString() + " " + getArea();
}

Tag.prototype.update = function(point){
	if(this.active){
		if(this.resizing){
			if(point[0] < this.leftBoundary){
				point[0] = this.leftBoundary;
			}
			if(point[0] > this.rightBoundary){
				point[0] = this.rightBoundary;
			}
			
			if(point[1] < this.bottomBoundary){
				point[1] = 50;
			}
			if(point[1] > 480){
				point[1] = 480;
			}
			
			var tmp = point - this.position; // TODO check if this.position is accessible (super class attribute)
			
			if(tmp[0] >= 0 && tmp[0] <= 50){
				tmp[0] = 50;
			}
			if(tmp[0] < 0 && tmp[0] >= -50){
				tmp[0] = -50;
			}
			
			if(tmp[1] >= 0 && tmp[1] <= 50){
				tmp[1] = 50;
			}
			if(tmp[1] < 0 && tmp[1] >= -50){
				tmp[1] = -50;
			}
			
			this.size = tmp;
		}

		else if(this.moving){
			
			var tmp = point;
			
			if(tmp[0] < (854 / 2) - (this.imgSize[0] / 2) + Math.abs(Math.min(this.size[0], 0))){
				tmp[0] = (854 / 2) - (this.imgSize[0] / 2) + Math.abs(Math.min(this.size[0], 0));
			}
			if(tmp[0] > (854 / 2) + (this.imgSize[0] / 2) - Math.abs(Math.max(this.size[0], 0))){
				tmp[0] = (854 / 2) + (this.imgSize[0] / 2) - Math.abs(Math.max(this.size[0], 0));
			}
			
			if(tmp[1] < 50 + Math.abs(Math.min(this.size[1], 0))){
				tmp[1] = 50 + Math.abs(Math.min(this.size[1], 0));
			}
			if(tmp[1] > 480 - Math.abs(Math.max(this.size[1], 0))){
				tmp[1] = 480 - Math.abs(Math.max(this.size[1], 0));
			}
			
			this.position = tmp;
		}
	}
}

Tag.prototype.render = function(shapeRenderer){
	// TODO check how to do it
}

Tag.prototype.renderText = function(batch, bitmapFont){
	// TODO check how to do it
}

Tag.prototype.contains = function(point){
	var x, y, w, h;
	
	if(size[0] < 0){
		x = position[0] + size[0];
	}
	else{
		x = position[0];
	}
	
	if(size[1] < 0){
		y = position[1] + size[1];
	}
	else{
		y = position[1];
	}
	
	w = Math.abs(size[0]);
	h = Math.abs(size[1]);
	
	return (point[0] >= x) && (point[0] <= x + w) &&
			(point[1] >= y) && (point[1] <= y + h);
}

Tag.prototype.grabHandles = function(point){
	var tmp = this.position;

	var a1 = (point[0]-tmp[0]);
	var b1 = (point[1]-tmp[1]);
	var dst_Point_Position = Math.sqrt(a1*a1 + b1*b1);
	//var dst_Point_Position = dst(point, tmp)

	var a2 = (this.position[0]+this.size[0])-point[0];
	var b2 = (this.position[1]+this.size[1])-point[1];
	var dst_Point_PositionSize = Math.sqrt(a2*a2 + b2*b2);
	//var dst_Point_PositionSize = dst(this.position+this.size, point)

	if(dst_Point_PositionSize < 25 && !this.moving){
		this.resizing = true;
	}
	
	if(dst_Point_Position < 25 && !this.resizing){
		this.moving = true;
	}
}

function dst(point1, point2){
	var a1 = (point1[0]-point2[0]);
	var b1 = (point1[1]-point2[1]);
	return = Math.sqrt(a1*a1 + b1*b1);
}

Tag.prototype.handleGrabbed = function (){
	return this.moving || this.resizing;
}

Tag.prototype.releaseHandles = function (){
	this.moving = false;
	this.resizing = false;
}

Tag.prototype.setActive = function (flag){
	this.active = flag;
}

Tag.prototype.isActive = function (){
	return this.active;
}

Tag.prototype.getArea = function (){
	return this.size.x * this.size.y;
}

Tag.prototype.setSharkId = function (id, text){
	super.setSharkId(id);
	this.text = text;
}

Tag.prototype.getText = function (){
	return this.text;
}

Tag.prototype.toSimpleTag = function(){
	var t = new SimpleTag(0, 0);
	t.position = getOriginalPosition(this.position);
	t.size = getOriginalSize(this.size);
	t.sharkId = this.sharkId;
	
	// Convert so that position is in the top-left corner of the tag
	// and size is always positive going bottom-right
	if(t.size[1] > 0){
		t.position[1] += t.size[1];
	}
	else{
		t.size[1] *= -1;	// change to positive
	}
	
	if(t.size[0] < 0){
		t.position[0] += t.size[0];
		t.size[0] *= -1;
	}
	t.position[1] = imgSize[1] * imgScale - t.position[1];	// invert Y axis
	return t;
}

Tag.prototype.getOriginalPosition = function(point){
	var tmp = point;
	tmp[0] = (tmp[0] - leftBoundary) * imgScale;
	tmp[1] = (tmp[1] - bottomBoundary) * imgScale;
	return tmp;
}

Tag.prototype.getOriginalSize = function(point){
	var tmp[size]
	tmp[0] = tmp[0] * imgScale;
	tmp[1] = tmp[1] * imgScale;
	
	return tmp;
}

module.exports = Tag;