<?php

use App\Models\PurchaseRequest;
use App\Models\StoreRequest;

if (!function_exists('make_reference_id')) {
    function make_reference_id($prefix, $number)
    {
        $padded_text = $prefix . '-' . str_pad($number, 5, 0, STR_PAD_LEFT);

        return $padded_text;
    }
}

if (!function_exists('make_store_request_no')) {
    function make_store_request_no()
    {
        $record = StoreRequest::latest()->first();

        $prefix = "SR";

        if ($record == null or $record == "") {
            if (date('l', strtotime(date('Y-01-01')))) {
                $requestNo = $prefix . date('Y') . '-00001';
            }
        } else {
            $expNum = explode('-', $record->code);
            $number = ($expNum[1] + 1);
            $requestNo = $prefix . date('Y') . '-' . str_pad($number, 5, 0, STR_PAD_LEFT);
        }

        return $requestNo;
    }
}

if (!function_exists('make_purchase_request_no')) {
    function make_purchase_request_no()
    {
        $record = PurchaseRequest::latest()->first();

        $prefix = "PRA";

        if ($record == null or $record == "") {
            if (date('l', strtotime(date('Y-01-01')))) {
                $requestNo = $prefix . date('Y') . '-00001';
            }
        } else {
            $expNum = explode('-', $record->code);
            $number = ($expNum[1] + 1);
            $requestNo = $prefix . date('Y') . '-' . str_pad($number, 5, 0, STR_PAD_LEFT);
        }

        return $requestNo;
    }
}
