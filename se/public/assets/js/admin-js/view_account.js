<<<<<<< HEAD
var main = function(){
	$(".account-row").click( function(){
		if($(this).parent().find("p").hasClass("selected_account")){
			$(this).parent().find("p").removeClass("selected_account");
		}
		else{
			$(this).parent().find("p").addClass("selected_account");
		}
		if($(this).parent().next().hasClass("hide")){
			$(this).parent().next().fadeIn(400).removeClass("hide");
		}
		else{
			$(this).parent().next().addClass("hide");
		}
	});
	$('#datepicker1').datepicker({
		format: 'yyyy-mm-dd'
	});
=======
var main = function () {
    $(".account-row").click(function () {
        if ($(this).parent().find("p").hasClass("selected_account")) {
            $(this).parent().find("p").removeClass("selected_account");
        }
        else {
            $(this).parent().find("p").addClass("selected_account");
        }
        if ($(this).parent().next().hasClass("hide")) {
            $(this).parent().next().fadeIn(400).removeClass("hide");
        }
        else {
            $(this).parent().next().addClass("hide");
        }
    });
    $('#datepicker1').datepicker({
        format: 'yyyy-mm-dd',
        maxDate: "+0d"
    });
>>>>>>> origin/Final0.1
}
$(document).ready(main);