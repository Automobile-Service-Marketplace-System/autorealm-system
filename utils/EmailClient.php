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
    private function _sendEmail(string $receiverEmail, string $receiverName = "", string $subject = "", string $htmlContent = "", string $senderEmail = "security@autorealm.lk", $params = [], bool $templateLess = false): void
    {
        $sendEmailObject = new SendSmtpEmail();
        $sendEmailObject->setSubject($subject);
        if ($htmlContent !== "") {
            $sendEmailObject->setHtmlContent($htmlContent);
        }
        $sendEmailObject->setSender(new SendSmtpEmailSender(["email" => $senderEmail, "name" => "AutoRealm"]));
        $sendEmailObject->setTo([new SendSmtpEmailTo(["email" => $receiverEmail, "name" => $receiverName])]);
        if(!empty($params)) {
            $sendEmailObject->setParams($params);
        }
//        set template id
        if (!$templateLess) {
            $sendEmailObject->setTemplateId(templateId: 1);
        }

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
    public static function sendEmail(string $receiverEmail, string $receiverName = "", string $subject = "", string $htmlContent = "", string $senderEmail = "security@autorealm.lk", array $params = [], bool $templateLess = false): void
    {
        self::getInstance()->_sendEmail($receiverEmail, $receiverName, $subject, $htmlContent, $senderEmail, $params, $templateLess);
    }
}