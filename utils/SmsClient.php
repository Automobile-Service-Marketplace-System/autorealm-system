<?php

namespace app\utils;

use NotifyLk\Api\SmsApi;
use NotifyLk\ApiException;


class SmsClient
{
    private static SmsClient $instance;
    private static SmsApi $api;
    private static string $apiKey;
    private static string $userId;
    private static string $senderId;
    private static string $customerContactGroupId;
    private static string $messageType;


    final private function __construct()
    {
        self::$api = new SmsApi();
        self::$apiKey = $_ENV["NOTIFY_API_KEY"];
        self::$userId = $_ENV["NOTIFY_USER_ID"];
        self::$senderId = $_ENV["NOTIFY_SENDER_ID"];
        self::$customerContactGroupId = $_ENV["NOTIFY_CUSTOMER_CONTACT_GROUP_ID"];
        self::$messageType = "unicode";
    }

    private static function getInstance(): SmsClient
    {
        if (!isset(self::$instance)) {
            self::$instance = new SmsClient();
        }
        return self::$instance;
    }

    /**
     * @param array $customer
     * @param string $message
     * @return bool|array
     * @throws ApiException
     */
    public static function sendSmsToCustomer(array $customer, string $message): bool|array
    {
        $instance = self::getInstance();
        $api = $instance::$api;

        var_dump($customer);

        var_dump($message);

        $to = substr($customer['contact_no'], 1);
        $contact_fname = $customer['f_name'];
        $contact_lname = $customer['l_name'];
        $contact_email = $customer['email'];
        $contact_address = $customer['address'];

        $api->sendSMS(
            user_id: self::$userId,
            api_key: self::$apiKey,
            message: $message,
            to: $to,
            sender_id: self::$senderId,
            contact_fname: $contact_fname,
            contact_lname: $contact_lname,
            contact_email: $contact_email,
            contact_address: $contact_address,
            contact_group: self::$customerContactGroupId,
            type: self::$messageType
        );
        return [
            "message" => "Successfully sent sms to customer"
        ];
    }
}