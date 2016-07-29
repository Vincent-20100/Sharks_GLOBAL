

$( function() {

	var modalOpen = false;
	
	$(".btn-openModal").click( function () {
		$( $(".btn-openModal").attr('data-target') ).removeClass("hide");
	});
	
	$(".close").click( closeModal );
	
	$(document).click( function (event) {
		if($(event.target).is(".modal")) {
			closeModal();
		}
	});
	
	function closeModal() {
		$('.modal').addClass("hide");
	}
});
