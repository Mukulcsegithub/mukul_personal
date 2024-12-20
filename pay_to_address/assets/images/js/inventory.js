$(document).ready(function () {

    jQuery('#datatbl').DataTable();

    $('#txtarea').keyup(function(){
        poolval = $('#txtarea').val();
        if (poolval.length == "") {
            $('#usercheck').html("pool muast be filled");
           
        }
        else
        {
            $('#usercheck').html("");
        }
    });
    $("form").submit(function (event) {
        poolval = $('#txtarea').val();
        if (poolval.length == "") {
            event.preventDefault();
            $('#usercheck').html("pool muast be filled");
        }
    });
  
// write two sum code


    //     jQuery('body').on('click', '#delete_pool', function () {
    //         var firewallId = $(this).data('id');
    //         console.log(firewallId);
    //         jQuery('#confirmDelete').data('id', firewallId);
    //         jQuery('#deleteModal').modal('show');
    //     });
    //     jQuery('body').on('click', '#confirmDelete', function () {
    //         var firewallId = jQuery(this).data('id');
    //         deletePool(firewallId);
    //     });
    //     jQuery('#datatbl').DataTable();
    // });

    // function deletePool(Pool_id){
    //     console.log(window.location.href);
    //     jQuery.ajax({
    //         url: "../../lib/Admin/Controller.php",
    //         type: 'POST',
    //         data: {
    //             "action": true,
    //             "data": Pool_id
    //         },
    //         // dataType: 'json',
    //         success: function(response) {
    //             console.log(response);
    //         }
});
