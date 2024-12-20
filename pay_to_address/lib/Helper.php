<?php

namespace WHMCS\Module\Addon\Pay_To_Address;

use WHMCS\Database\Capsule;

class Helper
{

    public function currencyDropDown()
    {
        try {
            $currencyData = Capsule::table('tblcurrencies')->get();
            return $currencyData;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function insertCurrencyData($formData)
    {
        try {
            return Capsule::table('mod_currency_details')->insert($formData);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }


    public function getCurrencyData()
    {
        return Capsule::table('mod_currency_details')
            ->join('tblcurrencies', 'tblcurrencies.id', 'mod_currency_details.currency_code')
            ->select('mod_currency_details.*', 'tblcurrencies.code as currency')
            ->get();
    }
    public function editFeild($data)
{
    try {
        if (empty($data['pay_to_address'])) {
            throw new \Exception("Pay to Address cannot be empty.");
        }

        $currencyExists = Capsule::table('tblcurrencies')
            ->where('id', $data['currency_code'])
            ->exists();

        if (!$currencyExists) {
            throw new \Exception("Invalid currency code provided.");
        }

        $updateData = [
            "currency_code" => $data['currency_code'],
            "pay_to_address" => $data['pay_to_address']
        ];
        $result = Capsule::table('mod_currency_details')
            ->where('id', $data['id'])
            ->update($updateData);

        if ($result) {
            $updateDetails = ['status' => "success"];
        } else {
            $updateDetails = ['status' => "error"];
        }

        return $updateDetails;
    } catch (\Exception $e) {
        return ['status' => 'error', 'message' => $e->getMessage()];
    }
}


    public function deleteFeild($id)
    {
        try {
            return Capsule::table('mod_currency_details')->where('id', $id)->delete();
        } catch (\Exception $e) {
            return "Uh oh! deleting didn't work, but I was able to rollback. {$e->getMessage()}";
        }
    }
}
