<?php
use WHMCS\Module\Addon\pay_to_address\Admin\AdminDispatcher;
use WHMCS\Module\Addon\pay_to_address\Helper;
use WHMCS\Database\Capsule;
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}
function pay_to_address_config()
{
    return [
        // Display name for your module
        'name' => ' Pay Address',
        // Description displayed within the admin interface
        'description' => 'Depending on the selected currency, then the address I want is what would show in the Pay To field on the invoice.',
        // Module author name
        'author' => '<a href="http://whmcsglobalservices.com/" target="_blank"><img src="/modules/addons/electronic_invoice/assests/img/whmcsglobalservices.svg" alt="WHMCS GLOBAL SERVICES"  width="150"></a>',
        // Default language
        'language' => 'english',
        // Version number
        'version' => '1.0',
        'fields' => [
            'delete_db' => [
                'FriendlyName' => 'Delete Database Table',
                'Type' => 'yesno',
                'Description' => 'Tick this box to delete the addon module database table when deactivating the module.',
            ]
        ]
    ];
}

function pay_to_address_activate()
{
    try {
        if (!Capsule::schema()->hasTable('mod_currency_details')) {
            Capsule::schema()->create(
                'mod_currency_details', 
                function ($table) {
                    $table->increments('id');
                    $table->string('currency_code'); 
                    $table->text('pay_to_address'); 
                    $table->timestamps();
                }
            );
        }
    } catch (Exception $e) {
        logActivity('Failed to Create (mod_currency_details) Table: ' . $e->getMessage()); 
    }
}




function pay_to_address_deactivate()
{
   
        try {
            $deleteDbTable = Capsule::table('tbladdonmodules')->where('module', 'pay_to_address ')->where('setting', 'delete_db')->value('value');
            if ($deleteDbTable == 'on') {
                $tables = ['mod_currency_details'];
                foreach ($tables as $value) {
                    Capsule::schema()->dropIfExists($value);
                }
            }
            return array('status' => 'success', 'description' => 'Deactivated successfully.');
        } catch (\Exception $e) {
            return ['status' => "error", 'description' => 'Unable to deactivate module: ' . $e->getMessage(),];
        }
    }

function pay_to_address_output($vars)
{

    try{
        $whmcs = WHMCS\Application::getInstance();
        $action = !empty($whmcs->get_req_var("action")) ? $whmcs->get_req_var("action") : 'dashboard';
        $dispatcher = new AdminDispatcher(); 
        $response = $dispatcher->dispatch($action, $vars);
    } catch (\Exception $e) {
        return ['status' => "error", 'description' => 'Somting Went Wrong In Module' . $e->getMessage(),];
    }
    }
