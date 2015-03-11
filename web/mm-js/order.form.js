$(document).ready(function () {
        
       $('#order_travelerPersonNames').hide();
       
    $('#ordermodel-ticketquantity').change(function(){
        var v = $(this).val();
        $('#quantity-value').html(v);
        $('#total-price').html('$'+ v*99);
        $('#net-price').html('$'+ v*99);
    });
    
    $('input[type=radio][name="OrderModel[travelerType]"]').change(function(){
        var v = $('input[name="OrderModel[travelerType]"]:checked').val();
        if(v==="3")
        {
            $('#order_travelerPersonNames').show();
        }
        else
        {
            $('#order_travelerPersonNames').hide();
        }
    });
    
    
    
    var step1SubmitSelector = '#step1-submit';
    var step2SubmitSelector = '#step2-submit';
    var step3SubmitSelector = '#step3-submit';
    var step4SubmitSelector = '#step4-submit';

    //var url = "?r=order/process";
    var url = "/order/process";

    $(step1SubmitSelector).click(function (e) {
        postOrderForm("step1", "moveTab2");
        return false;
    });

    $(step2SubmitSelector).click(function (e) {

        var bookingDate = [
            $("#ordermodel-bookingyear").val(),
            $("#ordermodel-bookingmonth").val(),
            $("#ordermodel-bookingday").val(),
        ];
        $("#ordermodel-bookingdate").val(bookingDate.join("-"));
        
        postOrderForm("step2", "moveTab3");
        
        return false;
    });

    $(step3SubmitSelector).click(function (e) {
        postOrderForm("step3", "moveTab4");
        return false;
    });

    $(step4SubmitSelector).click(function (e) {
        postOrderForm("step4");
        return false;
    });

    function postOrderForm(step, moveTab)
    {
        var formData = $("#frmBookTicket").serialize();
        $(".has-error").removeClass("has-error");
        $(".help-block").text("");

        showLoader(step);

        $.post(url, formData + "&scenario=" + step).success(function (data) {
            if (step != "step4")
            {
                $("#" + moveTab).click();
                hideLoader();
            }
            else
            {
                if (data == 'success') {
                    confirmPayment();                    
                }
            }
        }).error(function (data) {
            var isValidationError = false;
            if (!(data.responseText.indexOf("<pre>") == 0))
            {
                var errorResponse = $.parseJSON(data.responseText);
                $.each(errorResponse, function (index, val) {
                    $("#order_" + index).addClass("has-error");
                    $("#order_" + index + " .help-block").text(val[0]);
                    isValidationError = true;
                });
            }

            if (!isValidationError)
            {
                orderProcessingError();
            }
            else
            {
                hideLoader();
            }
        });
    }

    function showLoader(step)
    {
        $('#close-loader').hide();
        
        $('#loader-modal').modal({
            backdrop: false,
            keyboard: false,
            show: true
        })

        if (step != "step4")
        {
            $('#loader-content').html("Please wait...");
        }
        else
        {
            $('#loader-content').html("We are processing your order, please wait...");
        }
    }

    function hideLoader() {
        $('#loader-modal').modal('hide');
    }

    function orderProcessingError()
    {
        $('#loader-content').addClass('text-danger');
        $('#loader-content').html("Error: Some error is occured, please try again!!.");
        $('#close-loader').show();
    }

    function confirmPayment()
    {
        $('#loader-content').addClass('text-success');
        $('#loader-content').html("Success: We have received your order successfully.");
        $('#close-loader').show();        
    }

    $('#close-loader').click(function () {
        closeLoader($('#loader-content').hasClass('text-success'));
    });

    function closeLoader(cleanAll)
    {
        hideLoader();
        $('#loader-content').removeClass('text-success');
        $('#loader-content').removeClass('text-danger');

        if (cleanAll)
        {
            $("#frmBookTicket input[type=text]").val("");
            $("#frmBookTicket input[type=radio]").val(false);
            $("#frmBookTicket select").val("");
            $(".has-error").removeClass("has-error");
            $(".help-block").text("");
            $("#moveTab1").click();
            location.reload();
        }
    }

    function centerModal() {
        $(this).css('display', 'block');
        var $dialog = $(this).find(".modal-dialog");
        var offset = ($(window).height() - $dialog.height()) / 2;
        // Center modal vertically in window
        $dialog.css("margin-top", offset);
    }

    $('.modal').on('show.bs.modal', centerModal);
    $(window).on("resize", function () {
        $('.modal:visible').each(centerModal);
    });

});