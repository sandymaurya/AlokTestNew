$(document).ready(function () {
//    var selectorPrefix = '#ticketmodel-';
    var step1SubmitSelector = '#step1-submit';
    var step2SubmitSelector = '#step2-submit';
    var step3SubmitSelector = '#step3-submit';
    var step4SubmitSelector = '#step4-submit';

    //var url = "?r=order/process";
    var url = "/order/process";
    
    $(step1SubmitSelector).click(function (e) {
        var formData = $("#frmBookTicket").serialize();
        $(".has-error").removeClass("has-error");
        $(".help-block").text("");
        $.post(url, formData+"&scenario=step1").success(function (data) {
            $("#moveTab2").click();
        }).error(function(data) {
            var errorResponse = $.parseJSON(data.responseText);
            $.each(errorResponse, function(index, val) {
                $("#order_"+index).addClass("has-error");
                $("#order_"+index+" .help-block").text(val[0]);
            });
        });
        return false;
    });

    $(step2SubmitSelector).click(function (e) {

        var bookingDate = [
            $("#ordermodel-bookingyear").val(),
            $("#ordermodel-bookingmonth").val(),
            $("#ordermodel-bookingday").val(),
        ];

        $("#ordermodel-bookingdate").val(bookingDate.join("-"));

        var formData = $("#frmBookTicket").serialize();
        $(".has-error").removeClass("has-error");
        $(".help-block").text("");
        $.post(url, formData+"&scenario=step2").success(function (data) {
            $("#moveTab3").click();
        }).error(function(data) {
            var errorResponse = $.parseJSON(data.responseText);
            $.each(errorResponse, function(index, val) {
                $("#order_"+index).addClass("has-error");
                $("#order_"+index+" .help-block").text(val[0]);
            });
        });
        return false;
    });

    $(step3SubmitSelector).click(function (e) {
        var formData = $("#frmBookTicket").serialize();
        $(".has-error").removeClass("has-error");
        $(".help-block").text("");
        $.post(url, formData+"&scenario=step3").success(function (data) {
            $("#moveTab4").click();
        }).error(function(data) {
            var errorResponse = $.parseJSON(data.responseText);
            $.each(errorResponse, function(index, val) {
                $("#order_"+index).addClass("has-error");
                $("#order_"+index+" .help-block").text(val[0]);
            });
        });
        return false;
    });

    $(step4SubmitSelector).click(function (e) {
        var formData = $("#frmBookTicket").serialize();
        $(".has-error").removeClass("has-error");
        $(".help-block").text("");
        $.post(url, formData+"&scenario=step4").success(function (data) {
            if(data=='success') {
                alert("Success: We have received your order successfully.");
                location.reload();
            }
            // process payment
        }).error(function(data) {
            var errorResponse = $.parseJSON(data.responseText);
            $.each(errorResponse, function(index, val) {
                $("#order_"+index).addClass("has-error");
                $("#order_"+index+" .help-block").text(val[0]);
            });
        });
        return false;
    });
});