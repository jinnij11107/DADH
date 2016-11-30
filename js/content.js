
$(document).on('click', '.dropdown-menu li a', function () {
    var year = "年號:" + this.hash.replace("#", "");
	changeYearName(year);
});

//--	container initialization
$( document ).ready(function() {
    $bookcase = $('.book');
	$checked = [true, false, false, false, false ];
	$scrollValue = [0, 0, 0, 0, 0];
	
	
	$panel = $(".nav-sidebar");
	
	var h = document.body.scrollHeight;
	var t = $($(".nav-sidebar")[0]).offset().top;
	for(var i = 0; i < $panel.length; i ++) {
		$($panel[i]).height(h - t - 5);
	}
});

//--	dropdown bar action listener
$( document ).ready(function() {

	var text = $('.dropdown');
	
	for(var i = 0; i < text.length; i ++) {
		for(var j = 0; j < text[i].lastElementChild.children.length; j ++) {
			
			$( text[i].lastElementChild.children[j].firstElementChild ).click(function () {
				
				findChunqiuByTitle(event.target.hash.replace("#", "") );
				
				for(var i = 0; i < $checked.length; i ++) {
					
					if( $checked[i] == true ) {
						var slider = $( $bookcase[i].lastElementChild )[0];
						var target = slider.getElementsByClassName( this.hash.replace("#", "") )[0];
						$(slider).animate({
							scrollTop: $(slider).scrollTop() + ( $(target).offset().top - $(slider).offset().top )
						}, 600);
					}
				}
			});
		}
	}
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
			var col = 9;
			for(var i = 0; i < $bookcase.length; i ++) {
				if( $checked[i] == true ) {
					changeBook($bookcase[i], col);
					$("#main").append($bookcase[i]);
				} else {
					$( $bookcase[i] ).detach();
				}
			}
			changeBook($bookcase[0], 3);
			break;
		case 3:
			$($bookcase[0]).attr('class', 'book col-sm-12 content hidden');
			var col = 6;
			for(var i = 1; i < $bookcase.length; i ++) {
				if( $checked[i] == true ) {
					changeBook($bookcase[i], col);
					$("#main").append($bookcase[i]);
				} else {
					$( $bookcase[i] ).detach();
				}
			}
			break;
		case 4:
			var col = 4;
			$($bookcase[0]).attr('class', 'book col-sm-12 content hidden');
			for(var i = 1; i < $bookcase.length; i ++) {
				if( $checked[i] == true ) {
					changeBook($bookcase[i], col);
					$("#main").append($bookcase[i]);
				} else {
					$( $bookcase[i] ).detach();
				}
			}
			break;
	}
	setScrollValueAll();
}

function getScrollValueAll(target, i) {
	console.log(target.lastElementChild.scrollTop);
	$scrollValue[i] = target.lastElementChild.scrollTop;
}

function setScrollValueAll() {
	for(var i = 0; i < $bookcase.length; i ++) {
		$bookcase[i].lastElementChild.scrollTop = $scrollValue[i];
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

function findChunqiuByTitle(title) {
	$indexArray = $($bookcase[0]).find("." + title).find('.list-group')[0].children;
	$("#Ctitle").empty();
	$("#Ctitle").append('<li role="presentation" class="dropdown-header">' + title + '</li>');
	$("#Ctitle").append('<li role="presentation" class="divider"></li>');
	for(var i = 0; i < $indexArray.length; i ++) {
		$("#Ctitle").append('<li role="presentation"><a role="menuitem" tabindex="-1" href="#" >' + $indexArray[i].innerText+ '</a></li>');
	}
	$('#spanTitle')[0].innerHTML = "<span class='glyphicon glyphicon-tag' aria-hidden='true'></span>  " + $indexArray[0].innerText;
}

function missChunqiuByTitle(title) {
	$indexArray = $($bookcase[0]).find("." + title).find('.list-group')[0].children;
	$("#Ctitle").empty();
	$("#Ctitle").append('<li role="presentation" class="dropdown-header">' + title + '</li>');
	$("#Ctitle").append('<li role="presentation" class="divider"></li>');
	for(var i = 0; i < $indexArray.length; i ++) {
		$("#Ctitle").append('<li role="presentation"><a role="menuitem" tabindex="-1" href="#" >' + $indexArray[i].innerText+ '</a></li>');
	}
	$('#spanTitle')[0].innerHTML = "<span class='glyphicon glyphicon-tag' aria-hidden='true'></span>  沒有對應的條目";
}

function findCgunqiuByIndex(classSelector, title) {

	$indexArray = $($bookcase[0]).find("." + title).find('.list-group')[0].children;
	var $temp = $( $indexArray ).filter(classSelector);
	
	if( $temp.length == 0) missChunqiuByTitle(title);
	else {
		$("#Ctitle").empty();
		$("#Ctitle").append('<li role="presentation" class="dropdown-header">' + title + '</li>');
		$("#Ctitle").append('<li role="presentation" class="divider"></li>');
		for(var i = 0; i < $indexArray.length; i ++) {
			$("#Ctitle").append('<li role="presentation"><a role="menuitem" tabindex="-1" href="#" >' + $indexArray[i].innerText+ '</a></li>');
		}
		var index = "";
		for(var i = 0; i < $temp.length; i ++) {
			index += "<span class='glyphicon glyphicon-tag' aria-hidden='true'></span>  "
			index += $temp[i].innerText;
			index += " ";
		}
		$('#spanTitle')[0].innerHTML = index;
	}
}

function missAlert(target) {
	for (var i = 1; i < 3; i++) {
		setTimeout(function() {
			target.animate({
				backgroundColor: "rgb(239, 220, 220)"
			}, 'slow', function() {
				target.animate({
					backgroundColor: "white"
				}, 'slow')
			})
		}, i * 1000);
	}
}

function changeYearName(yearName) {
	var yearBlock = $("#year")[0];
	yearBlock.innerHTML = yearName;
}