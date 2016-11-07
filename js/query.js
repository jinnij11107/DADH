$( document ).ready(function() {
	
	var $yearArray = $('#yearList').find("li");
	for(var i = 0; i < $yearArray.length; i ++) {
		
		var targetBlock =  $("." + $yearArray[i].firstElementChild.innerHTML) ;
		var count = $(targetBlock).find("li").length;
		$yearArray[i].innerHTML = $yearArray[i].innerHTML + " (" + count + ")";
		$( $yearArray[i].firstElementChild ).click(function () {
			$("html,body").animate({
				scrollTop: $('.' + this.innerText).offset().top 
			}, 600);
		});
	}
});

$( document ).ready(function() {
	
	var $seasonArray = $('#seasonList').find("li");
	for(var i = 0; i < $seasonArray.length; i ++) {
		
		$( $seasonArray[i].firstElementChild ).click(function () {
			$("html,body").animate({
				scrollTop: $('.' + this.innerText).offset().top 
			}, 600);
		});
	}	
});
