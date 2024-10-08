<?php
namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait NotificationTraits
{
    public string $smsApiUrl = 'https://app.philsms.com/api/v3/sms/send';
    public string $smsApiKey = '910|qLM64QroAvrfFA9nQpt46YZYylOpkhwF3P04GoEg ';

    public function sendSms($recipient = '', $message = '')
    {
        try
        {
            $payload['sender_id'] = "PhilSMS";
            $payload['recipient'] = $recipient;
            $payload['message'] = $message;

            $response = Http::withHeaders([
                "Authorization" => "Bearer ".$this->smsApiKey,
                "Content-Type"  => "application/json"
            ])->post(
                $this->smsApiUrl,
                $payload
            );

            return $response->json();
        } catch(\Exception $error)
        {
            throw new HttpException(500, $error->getMessage());
        }
    }
}
