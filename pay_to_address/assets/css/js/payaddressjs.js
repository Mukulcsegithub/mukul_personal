$(document).ready(function () {

    $('.datatable').on('click', '.btnClick', function () {
        console.log('hii');
        var currency_code = $(this).data('currencycode');
        var id = $(this).data('id');
        var currency = $(this).data('currency');
        var address = $(this).data('address');

        var pay_to_taxUpdate = $("#pay_to_taxUpdate").val();
        console.log(pay_to_taxUpdate);
        $("#myModal #select_currency option").attr("selected", false);
        $("#myModal #select_currency option").each(function () {
            if ($(this).val() == currency_code) { // EDITED THIS LINE
                $(this).attr("selected", "selected");
            }
        });

        $("#myModal #updateBtn").attr('data-dataid', id);

        $('#myModal textarea[name="pay_to_tax"]').val(address);

    });
    $("#updateBtn").click(function (e) {
        e.preventDefault();
        jQuery(".error").remove(); 
        var pay_to_tax = $("#pay_to_tax").val();
        if (pay_to_tax.length < 1) {
            jQuery('#pay_to_tax').after('<span class="error">This field is required</span>');
            return false;
        }
        $(this).prop("disabled", true);
        $(this).append(`<i class="fa fa-spinner fa-spin"></i>`);
        let id = $(this).data('dataid');
        var currencyCode = $('#select_currency').val();

        var payToAddress = $('#pay_to_tax').val();
        $.ajax({
            url: '',
            type: 'POST',
            data: { option: 'updateData', id: id, pay_to_address: payToAddress, currency_code: currencyCode },

            success: function (response) {
                let result = JSON.parse(response);
                console.log(result);
                if (result.status === 'success') {
                    console.log('qqq');
                    swal({
                        title: "Updated successfully!",
                        icon: "success",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Okay!"
                    }, function(isConfirm) {
                        if (isConfirm) {
                            // Reload the page
                            location.reload();
                        }
                    });
                } else {
                    swal("Updation failed");
                }
                $("#updateBtn").prop("disabled", false);
                $("#updateBtn").find("i").remove();
            }

          
        });
       
    });
});
$("#add_pay_address").click(function (e) {
    jQuery(".error").remove(); 
    var pay_to_taxUpdate = $("#pay_to_taxUpdate").val();
    if (pay_to_taxUpdate.length < 1) {
        jQuery('#pay_to_taxUpdate').after('<span class="error">This field is required</span>');
        return false;
    }
});

    


