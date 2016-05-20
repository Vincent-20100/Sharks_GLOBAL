//import SimpleTag onject

<script language="javascript" type="text/javascript">
	var SimpleTag = require('SimpleTag');

	//constuctor
	function TagRequest(token, imageId, tags){
		this.token = token;
		this.imageId = imageId;
		this.tags = tagsInit()
	}


	function tagsInit(){
		// not class variables
		var nonOverlapping = SimpleTag[];
		var tmpArray = SimpleTag[];

		for(shark in tags){
			if(shark.getSharkId() == 0){
				continue;
			}
			this.tmpArray.push(shark.toSimpleTag());
		}

		for(i = 0; i < tmpArray.length; i++){
			var overlaps = false;
			for (k = i + 1; k < tmpArray.length; k++) {
				if(tmpArray[i].overlap(tmpArray[k], 40)){
					overlaps = true;
				}
			}

			if (!overlaps) {
				nonOverlapping.push(tmpArray[i]);
			}
		}

		return nonOverlapping.sort();
	}

	module.exports = TagRequest;
</script>

<noscript>
	<h3> This web site requires JavaScript</h3>
</noscript>