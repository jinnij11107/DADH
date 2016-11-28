$( document ).ready(function() {
	
	var $yearArray = $('#yearList').find("li");
	for(var i = 0; i < $yearArray.length; i ++) {
		$( $yearArray[i].firstElementChild ).click(function () {
			$("html,body").animate({
				scrollTop: $('.' + this.innerText.split(" ")[0] ).offset().top - 70
			}, 600);
		});
	}
});

$( document ).ready(function() {
	
	var $seasonArray = $('#seasonList').find("li");
	for(var i = 0; i < $seasonArray.length; i ++) {
		
		$( $seasonArray[i].firstElementChild ).click(function () {
			$("html,body").animate({
				scrollTop: $('.' + this.innerText.split(" ")[0] ).offset().top - 70
			}, 600);
		});
	}	
});

$( document ).ready(function() {
	
	var $seasonArray = $('#monthList').find("li");
	for(var i = 0; i < $seasonArray.length; i ++) {
		
		$( $seasonArray[i].firstElementChild ).click(function () {
			$("html,body").animate({
				scrollTop: $('.' + this.innerText.split(" ")[0] ).offset().top - 70
			}, 600);
		});
	}	
});

/*
$( document ).ready(function() {
	
	var $seasonArray = $('#bookList').find("li");
	for(var i = 0; i < $seasonArray.length; i ++) {
		
		$( $seasonArray[i].firstElementChild ).click(function () {
			$("html,body").animate({
				scrollTop: $('.' + this.innerText.split(" ")[0] ).offset().top - 70
			}, 600);
		});
	}	
});
*/