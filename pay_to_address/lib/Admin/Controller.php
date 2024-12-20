<?php
//  get_req_var
namespace WHMCS\Module\Addon\pay_to_address\Admin;

use WHMCS\Module\Addon\pay_to_address\Helper;
use WHMCS\Database\Capsule;
use Smarty;


class Controller
{
    public $tplFileName;
    public $params;
    public $smarty;
    public $tplVar = array();
    public $message = [];
    public function __construct()
    {
        global $CONFIG;
        // echo"<pre>";
        // print_r($CONFIG);
        // die('qq');
        $this->tplVar['rootURL'] = $CONFIG["HTTP_X_FORWARDED_SERVER"];
        $this->tplVar['urlPath'] = $CONFIG["HTTP_X_FORWARDED_SERVER"] . "/modules/addons/{$params['module']}/";
        $this->tplVar['tplDIR'] = ROOTDIR . "/modules/addons/pay_to_address/templates/admin/";
    }

    public function dashboard($vars)
    {
        // global $whmcs;Save

        try {
            global $whmcs;
            $helper = new Helper;
            $sucess = "";
            $error = "";

            if ($whmcs->get_req_var('option') == 'updateData') {

                $id = $whmcs->get_req_var('id');
                $currency_code = $whmcs->get_req_var('currency_code');
                $pay_to_address = $whmcs->get_req_var('pay_to_address');

                $updateDetails = [
                    'id' => $id,
                    'currency_code' => $currency_code,
                    'pay_to_address' => $pay_to_address,
                ];
                $response = $helper->editFeild($updateDetails);
                echo json_encode($response);
                die;
            }


            elseif (!empty($whmcs->get_req_var('CurrencyId'))) {
                // echo "<pre>";
                // print_r($_GET);
                // die;
                $deleteCheck = $helper->deleteFeild($_GET['CurrencyId']);
                //    echo $deleteCheck;
                $deletemsg = 'deletesucess';

                header('refresh:2; url= addonmodules.php?module=pay_to_address');
            }
            elseif ($whmcs->get_req_var("Save")) {
                // print_r($_POST);
                // die;
                $currencyexist = Capsule::table("mod_currency_details")->where(["currency_code" => $whmcs->get_req_var('select_currency')])->first();
                if (!$currencyexist) {
                    $insert_array = [
                        "currency_code" => $whmcs->get_req_var('select_currency'),
                        "pay_to_address" => $whmcs->get_req_var('pay_to_taxUpdate'),
                        "created_at" => date("Y-m-d H:i:s", time()),
                        "updated_at" => date("Y-m-d H:i:s", time()),
                    ];
                    $results = $helper->insertCurrencyData($insert_array);

                    if ($results) {
                        $sucess = "Currency added successfully";
                    } else {
                        $error = "Unable to insert the data";
                    }
                } else {
                    $error = "Currency Already exist";
                }
            }

            $currencyCode = $helper->currencyDropDown();
            $this->tplVar['currencyCode'] = $currencyCode;

            $this->tplVar['currencyData'] = $helper->getCurrencyData();



            $this->tplVar['error'] = $error;
            $this->tplVar['success'] = $sucess;
            $this->tplVar['deletepool'] = $deletemsg;
            $this->tplFileName = __FUNCTION__;
            $this->output();
        } catch (\Exception $e) {

            $this->tplVar['error'] = $e->getMessage();
        }
    }

    private function output()
    {
        try {
            $this->smarty = new Smarty();
            $this->smarty->assign('tplVar', $this->tplVar);
            $this->smarty->assign('fileName', $this->tplFileName);

            if (!empty($this->tplFileName)) {
                $this->smarty->display($this->tplVar['tplDIR'] . $this->tplFileName . '.tpl');
            } else {
                $this->tplVar['errorMsg'] = 'not found';
                $this->smarty->display($this->tplFileName . 'error.tpl');
            }
        } catch (\Exception $e) {
            logActivity("Error In Controller Output" . $e->getMessage());
        }
    }
}
