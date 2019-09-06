$(document).ready(function () {
    $("#getMapProp").click(function () {

        var prop = $("#propID").val();
        var dataString = '&prop1=' + prop;
        var propertyObject;
        
        $.ajax({
            type: "POST",
            url: "getProp.php",
            data: dataString,
            cache: false,
            success: function (result) {
                propertyObject = result;
                var mpar = propertyObject.split("-");
                //break string at - points and put into sep input boxes
                
                $("#resStreet").val(mpar[0]);
                $("#resTown").val(mpar[1]);
                $("#resPost").val(mpar[2]);
                
                $("#mapResult").text("");
            }
            
        });       
    });    
});

$(document).ready(function () {
    $("#submitUpdateMap").click(function () {

        var prop = $("#propID").val();
        var street = $("#resStreet").val();
        var town = $("#resTown").val();
        var postcode =  $("#resPost").val();
        var dataString = '&prop1=' + prop + '&street1=' + street + '&town1=' + town + '&postcode1=' + postcode;

        $.ajax({
            type: "POST",
            url: "updatemap.php",
            data: dataString,
            cache: false,
            success: function (result) {
                $("#mapResult").text(result);
            }
        });       
    });    
});