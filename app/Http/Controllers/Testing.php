<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Infobip\Api\WhatsAppApi;
use Infobip\ApiException;
use Infobip\Model\WhatsAppMessage;
use Infobip\Model\WhatsAppTemplateContent;
use Infobip\Model\WhatsAppTemplateDataContent;
use Infobip\Model\WhatsAppTemplateBodyContent;
use Infobip\Model\WhatsAppBulkMessage;
use Infobip\Configuration;

class Testing extends Controller
{
    //
    function index()
    {
        $client = new Client([
            'base_uri' => "https://w1pgyq.api.infobip.com/",
            'headers' => [
                'Authorization' => "App a45f8655076dcbf44b7585554e115e57-409b48f7-71cc-4cea-9e21-746e5734f3e9",
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);

        $response = $client->request(
            'POST',
            'whatsapp/1/message/template',
            [
                RequestOptions::JSON => [
                    'messages' => [
                        [
                            'from' => '447860099299',
                            'to' => "62895376633939",
                            'content' => [
                                'templateName' => 'registration_success',
                                'templateData' => [
                                    'body' => [
                                        'placeholders' => ['sender', 'message', 'delivered', 'testing']
                                    ],
                                    'header' => [
                                        'type' => 'IMAGE',
                                        'mediaUrl' => 'https://api.infobip.com/ott/1/media/infobipLogo',
                                    ],
                                    'buttons' => [
                                        ['type' => 'QUICK_REPLY', 'parameter' => 'yes-payload'],
                                        ['type' => 'QUICK_REPLY', 'parameter' => 'no-payload'],
                                        ['type' => 'QUICK_REPLY', 'parameter' => 'later-payload']
                                    ]
                                ],
                                'language' => 'en',
                            ],
                        ]
                    ]
                ],
            ]
        );

        echo ("HTTP code: " . $response->getStatusCode() . PHP_EOL);
        echo ("Response body: " . $response->getBody()->getContents() . PHP_EOL);
    }

    function test()
    {
        $BASE_URL = "https://w1pgyq.api.infobip.com";
        $API_KEY = "a45f8655076dcbf44b7585554e115e57-409b48f7-71cc-4cea-9e21-746e5734f3e9";
        $RECIPIENT = "62895376633939";

        $configuration = new Configuration(host: $BASE_URL, apiKey: $API_KEY);

        $whatsAppApi = new WhatsAppApi(config: $configuration);

        $message = new WhatsAppMessage(
            from: '447860099299',
            to: $RECIPIENT,
            content: new WhatsAppTemplateContent(
                templateName: 'welcome_multiple_languages',
                templateData: new WhatsAppTemplateDataContent(
                    body: new WhatsAppTemplateBodyContent(placeholders: ['IB_USER_NAME'])
                ),
                language: 'en'
            )
        );

        $bulkMessage = new WhatsAppBulkMessage(messages: [$message]);

        try {
            $messageInfo = $whatsAppApi->sendWhatsAppTemplateMessage($bulkMessage);

            foreach ($messageInfo->getMessages() ?? [] as $messageInfoItem) {
                echo $messageInfoItem->getStatus()->getDescription() . PHP_EOL;
            }
        } catch (ApiException $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }
    }
}
