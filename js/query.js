$( document ).ready(function() {
	var $yearArray = $('#yearList').find("li");
	for(var i = 0; i < $yearArray.length; i ++) {
		$( $yearArray[i] ).click(function () {		
			$("html,body").animate({
				scrollTop: $('.' + this.innerText).offset().top 
			}, 600);
		});
	}
});
