<?php

namespace app\utils;

use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\ApiException;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\SendSmtpEmail;
use SendinBlue\Client\Model\SendSmtpEmailSender;
use SendinBlue\Client\Model\SendSmtpEmailTo;
use GuzzleHttp\Client;


class EmailClient
{
    private static EmailClient $instance;
    private static TransactionalEmailsApi $api;

    final private function __construct()
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey(
            apiKeyIdentifier: "api-key",
            key: $_ENV['SENDINBLUE_API_KEY']
        );
        self::$api = new TransactionalEmailsApi(
            client: new Client(),
            config: $config
        );
    }


    /**
     * @throws ApiException
     */
    private function _sendEmail($receiverEmail, $receiverName = "", $subject = "", $htmlContent = "", $senderEmail = "security@autorealm.lk", $params = []): void
    {
        $sendEmailObject = new SendSmtpEmail();
        $sendEmailObject->setSubject($subject);
        if ($htmlContent !== "") {
            $sendEmailObject->setHtmlContent($htmlContent);
        }
        $sendEmailObject->setSender(new SendSmtpEmailSender(["email" => $senderEmail, "name" => "AutoRealm"]));
        $sendEmailObject->setTo([new SendSmtpEmailTo(["email" => $receiverEmail, "name" => $receiverName])]);
        $sendEmailObject->setParams($params);
//        set template id
        $sendEmailObject->setTemplateId(templateId: 1);

        self::$api->sendTransacEmail($sendEmailObject);

    }

    private static function getInstance(): EmailClient
    {
        if (!isset(self::$instance)) {
            self::$instance = new EmailClient();
        }
        return self::$instance;
    }


    /**
     * @throws ApiException
     */
    public static function sendEmail($receiverEmail, $receiverName = "", $subject = "", $htmlContent = "", $senderEmail = "security@autorealm.lk", $params = []): void
    {
        self::getInstance()->_sendEmail($receiverEmail, $receiverName, $subject, $htmlContent, $senderEmail, $params);
    }
}