$(function() {
    var $context = $(".context");
    var $form = $("form");
    var $button = $form.find("button[name='perform']");
    var $input = $form.find("input[name='keyword']");

    $button.on("click.perform", function() {

        // Determine search term
        var searchTerm = $input.val();

        // Remove old highlights and highlight
        // new search term afterwards
        $context.removeHighlight();
        $context.highlight(searchTerm);

    });
    $button.trigger("click.perform");

    //--  mouse on
    /*
  $('.text').mouseenter(function(){
    var classArray = $(this).attr("class").split(" ");
  console.log(classArray);
    for(var i = 1; i < classArray.length; i++){
      $("." + classArray[i]).css("background-color","yellow");
    }
  })

    $('.text').mouseout(function(){
      var classArray = $(this).attr("class").split(" ");
        for(var i = 1; i < classArray.length; i++){
        $("." + classArray[i]).css("background-color","rgb(240, 240, 240)");
      }
  })*/
    function missAlert(target) {
        for (var i = 1; i < 3; i++) {
            setTimeout(function() {
                target.animate({
                    borderWidth: 4,
                    borderColor: "rgb(220,20,60)"
                }, 500, function() {
                    target.animate({
                        borderWidth: 1,
                        borderColor: 'rgb(211,211,211)'
                    }, 500)
                })
            }, i * 1000);
        }
    }
});
