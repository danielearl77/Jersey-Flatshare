$('#mapModel').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var tmpPostcode = button.data('post'); // Extract info from data-* attributes
    var tmpStreet = button.data('street');
    var tmpTown = button.data('town');
    //replace space with + in postcode and street vals
    var street = tmpStreet.replace(" ", "+");
    var postcode = tmpPostcode.replace(" ", "+");
    var town = tmpTown.replace(" ", "+");
    var propURL = 'https://www.google.com/maps/embed/v1/place?key=AIzaSyDGKWfIpUjw53gwgXYTPcQQBxKJ8-N1hos&q=' + street + ',' + town + ',' + postcode; 
    // Update the modal's content. Add propURL into iframe src attr.
    var modal = $(this);
    modal.find('.modal-body #propMap').attr("src", propURL);
});
        
$('#contactModel').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('propid'); // Extract info from data-* attributes
    var modal = $(this);
    modal.find('.modal-body #propid').val(id);
    $("#mailresult").text(" ");
});
        
$('#viewMoreText').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var propText = button.data('proptext'); // Extract info from data-* attributes
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-body #propDes').text(propText);
});
        
$(document).ready(function () {
    $("#submitToLandlord").click(function () {
        $("#mailresult").removeClass("bg-danger");
        $("#mailresult").removeClass("bg-success");
        
        var prop = $("#propid").val();
        var name = $("#name").val();
        var email = $("#email").val();
        var tel = $("#tel").val();
        var msg = $("#msg").val();
        var dataString = '&prop1=' + prop + '&name1=' + name + '&email1=' + email + '&tel1=' + tel + '&msg1=' + msg;   
        
        $.ajax({
            type: "POST",
            url: "sendmsg.php",
            data: dataString,
            cache: false,
            success: function (result) {
                $("#name").attr('placeholder', "Enter Name").val("");
                $("#email").attr('placeholder', "Enter Email Address").val("");
                $("#tel").attr('placeholder', "Enter Contact Number").val("");
                $("#msg").attr('placeholder', "Enter Message Here").val("");
                if (result.includes("Error")) {
                    $("#mailresult").addClass("bg-danger");
                    $("#mailresult").text(result);
                } else {
                    $("#mailresult").addClass("bg-success");
                    $("#mailresult").text(result);
                }
            }
        });       
    });    
});


$(".propImg").click(function() {
	var image = $(this).attr("src");
    var noImg = "noImg.png";
    
    if (image.includes("noImg.png") || image.includes("waiting.png")) {
        null;
    } else {
        $("div#lightbox img").attr("src", image);
        $("div#lightbox").fadeIn(300);
    }	
});
// close the lightbox
$("#closeLightbox").click(function() {
	$("div#lightbox").fadeOut(350);
});


function cookieClose() {
    $("div#cookieWarning").fadeOut(300);
    localStorage.cookieMsg = "y";
}

$(document).ready(function () {
    var test;
    test = localStorage.cookieMsg;
    if(test != "y") {
        $("div#cookieWarning").show();
    }
});


