<?php
    use WHMCS\Database\Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

add_hook('ClientAreaPageViewInvoice', 1111, function($vars) {
  $client_id = $vars['clientsdetails']['userid'];
   $currencyid= $vars['clientsdetails']['currency'];
 $currency_details=  Capsule::table('mod_currency_details')->where('currency_code', $currencyid)->first();
    return ["payto" => nl2br($currency_details->pay_to_address)];
});
add_hook('ClientAreaHeadOutput', 1, function ($vars) {

    $totalamount = $vars['rawtotal'];
    $html = '';

    if ($vars['templatefile'] == "viewcart") {
        global $CONFIG;
        $html .= '<script>
                    jQuery(document).ready(function(){
                        jQuery(document).on("change",function(){
                            var countryCode = jQuery("#inputCountry").val();
                            var stateCode = jQuery("#stateselect").val();
                            $.ajax({
                                url: "/cart.php?a=setstateandcountry",
                                type: "post",
                                data:{
                                    token: "bd2ce56ce628c558deaeaccc296f44c50d4fad78",
                                    "country":countryCode,
                                    "state":stateCode
                                },
                                success: function(result){
                                    // After successful AJAX call, hit another URL
                                    $.ajax({
                                        url: "/cart.php?a=checkout&e=false",
                                        type: "get",
                                        success: function(response){
                                            // console.log(response);
                                            let result = response.lastIndexOf("totalCartPrice");

                                            $("#totalCartPrice").html((response.substr(result+16,15)).split("<")[0]);
                                        },
                                        error: function(xhr, status, error){
                                            console.error("Error occurred while hitting currency updater URL:", error);
                                        }
                                    });
                                },
                                error: function(xhr, status, error){
                                    console.error("Error occurred during AJAX call:", error);
                                }
                            });
                        });
                    });
                </script>';

        return $html;

    }

});
    
