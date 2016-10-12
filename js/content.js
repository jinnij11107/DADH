/*
$(document).on('click', '.dropdown-toggle', function () {
    //console.log("Selected Option:"+$(this).text());
    var el = document.getElementById('age');
    var h = el.getElementsByTagName("h4");
    var old = "年號：";
    h[1].innerHTML = old + $(this).text();
});

$(document).on('click', '.dropdown-menu li a', function () {
    //console.log("Selected Option:"+$(this).text());
    var el = document.getElementById('age');
    var h = el.getElementsByTagName("h4");
    var old = h[1].innerHTML;
    h[1].innerHTML = old + $(this).text();
    h[0].innerHTML = h[1].innerHTML;
});*/

//--	container initialization
$( document ).ready(function() {
    $bookcase = $('.book');
	$checked = [true, false, false, false, false ];
	
	$panel = $(".nav-sidebar");
	var h = document.body.scrollHeight;
	var t = $($(".nav-sidebar")[0]).offset().top;
	for(var i = 0; i < $panel.length; i ++) {
		$($panel[i]).height(h - t - 5);
	}
});

//--	dropdown bar action listener
$( document ).ready(function() {
	
	var window_gap = $($(".nav-sidebar")[0]).offset().top;
	var text = $('.dropdown');
	
	for(var i = 0; i < text.length; i ++) {
		for(var j = 0; j < text[i].lastElementChild.children.length; j ++) {
			
			$( text[i].lastElementChild.children[j].firstElementChild ) .click(function () {
				
				for(var i = 0; i < $checked.length; i ++) {
					if( $checked[i] == true ) {
						var slider = $( $bookcase[i].lastElementChild )[0];
						var target = slider.getElementsByClassName( this.hash.replace("#", "") )[0];
						$(slider).animate({
							scrollTop: $(slider).scrollTop() + ( $(target).offset().top - window_gap )
						}, 600);
					}
				}
			});
		}
	}
});

//--	anchor listener
$( document ).ready(function() {
	/*
	for( var i = 0; i < $bookcase.length; i ++) {
		for( var j = 0; j < $bookcase[i].lastElementChild.childNodes.length -1; j ++) {
			for(var k = 0; k < $bookcase[i].lastElementChild.childNodes[j].lastElementChild.childNodes.length; k ++) {
				
			}
		}
	}*/
	
	
	
});

//--	mouse listener

$( document ).ready(function() {
	var timeoutId;
	
	$('.text').mouseenter(function(){
		var targetDiv = this.parentElement.parentElement.parentElement;

		var targetIndex = $(this);
		 if (!timeoutId) {
			timeoutId = window.setTimeout(function() {

				timeoutId = null; 
				var title = targetDiv.className.split(" ")[3];
				var $classArray = targetIndex.attr("class").split(" ");
				var $blockArray = $("." + title);
				$blockArray.splice($blockArray.index(targetDiv), 1);
				for(var i = 0; i < $blockArray.length; i ++) {
					fadeBlockIndex( findSibling($blockArray[i]) );
					fadeTargetClass($blockArray[i].lastElementChild, $classArray);
				}

		   }, 500);
		}
	});

	$('.text').mouseout(function(){
		
		if (timeoutId) {
			window.clearTimeout(timeoutId);
			timeoutId = null;
		}
		else {
			$(this).css("background-color","rgb(255, 255, 255)");
		   	var targetDiv = this.parentElement.parentElement.parentElement;
			var title = targetDiv.className.split(" ")[3];
			var $blockArray = $("." + title);
			for(var i = 0; i < $blockArray.length; i ++) {
				showBlockIndex( findSibling($blockArray[i]) );
				showTargetClass($blockArray[i]);
			}
		}
	});
});

//--	detach other
$( document ).ready(function() {
	for(var i = 1; i < $bookcase.length; i ++) {
		$( $bookcase[i] ).detach();
	}
});







//--	function
function show_page(span) {

	$label = span.children;
	var count = 1;
	for(var i = 1; i < $label.length; i ++) {
		var flag = $label[i].children[0].checked;
		if( flag == true) {
			$checked[i] = true;
			count ++;
		} else {
			$checked[i] = false;
		}
	}
	
	switch(count) {
		case 1:
			var col = 12;
			for(var i = 1; i < $bookcase.length; i ++) {
				$( $bookcase[i] ).detach();
			}
			changeBook($bookcase[0], col);
			break;
		case 2:
			var col = 8;
			for(var i = 0; i < $bookcase.length; i ++) {
				if( $checked[i] == true ) {
					changeBook($bookcase[i], col);
					$("#main").append($bookcase[i]);
				} else {
					$( $bookcase[i] ).detach();
				}
			}
			changeBook($bookcase[0], 4);
			break;
		case 3:
			var col = 4;
			for(var i = 0; i < $bookcase.length; i ++) {
				if( $checked[i] == true ) {
					changeBook($bookcase[i], col);
					$("#main").append($bookcase[i]);
				} else {
					$( $bookcase[i] ).detach();
				}
			}
			break;
		
	}
	
}

function changeBook(book, number) {
	$( book ).attr("class","book col-sm-" + number + " content");
}

function findSibling(targetDiv) {
	var array = new Array();
	var temp = targetDiv;
	if( targetDiv.previousElementSibling ) {
		for(var count = 2, targetDiv = targetDiv.previousElementSibling; targetDiv && count > 0 ; targetDiv = targetDiv.previousElementSibling, count --) {
			array.push(targetDiv);
		}
	}
	targetDiv = temp;
	if( targetDiv.nextElementSibling ) {
		for(var count = 2, targetDiv = targetDiv.nextElementSibling; targetDiv && count > 0 ; targetDiv = targetDiv.nextElementSibling, count --) {
			array.push(targetDiv);
		}
	}
	return array;
}

function fadeBlockIndex(divArray) {
	for(var j = 0; j < divArray.length; j ++)
		$(divArray[j].lastChild).fadeTo("fast", 0.2);
}

function showBlockIndex(divArray) {
	for(var j = 0; j < divArray.length; j ++)
		$(divArray[j].lastChild).fadeTo("fast", 1);
}

function fadeTargetClass(blockQuote, $classArray) {
	var indexContainer = new Array();
	for(var i = 0; i < blockQuote.childNodes.length; i ++) 
		indexContainer.push( blockQuote.childNodes[i] );
	
	for(var i = 1; i < $classArray.length; i ++) {
		for(var j = 0; j < indexContainer.length; j ++) {
			var index = indexContainer[j].lastChild;
			if( index.className.includes($classArray[i]) ) {
				indexContainer.splice(indexContainer.indexOf(index.parentElement), 1);
				j --;
			}
		}
	}
	for(var i = 0; i < indexContainer.length; i ++)
		$( indexContainer[i] ).fadeTo("fast", 0.2);
}

function showTargetClass(targetDiv) {
	for(var i = 0; i < targetDiv.lastChild.childNodes.length; i ++) 
		$( targetDiv.lastChild.childNodes[i] ).fadeTo("fast", 1);
}


