<script language="javascript" type="text/javascript">
	//constuctor
	function TagRequest(token, imageId, tags){
		this.token = token;
		this.imageId = imageId;
		this.tags = SimpleTag[]; //verify if SimpleTag can be accessed

		// not class variables
		this.nonOverlapping = SimpleTag[];
		this.tmpArray = SimpleTag[];

		for(shark in tags){
			if(shark.getSharkId() == 0){
				continue;
			}
			this.tmpArray.push(shark.toSimpleTag());
		}

		for(i = 0; i < tmpArray.length; i++){
			overlaps = false;
			for (k = i + 1; k < tmpArray.length; k++) {
				if(tmpArray[i].overlap(tmpArray[k], 40)){
					overlaps = true;
				}
			}

			if (!overlaps) {
				nonOverlapping.push(tmpArray[i]);
			}
		}

		this.tags = nonOverlapping.sort();
	}
</script>
<noscript>
	<h3> This web site requires JavaScript</h3>
</noscript>