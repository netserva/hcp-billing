<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

  require APPPATH.'libraries/Twilio/autoload.php';
  use Twilio\Rest\Client;

  class Sms extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
        User::logged_in();

        $this->load->module('layouts');
        $this->load->library(['template']);
    }

    public function twilio($payload)
    {
        $sid = config_item('twilio_sid');
        $token = config_item('twilio_token');
        $client = new Client($sid, $token);

        $phone = !str_contains('+', $payload['phone']) ? '+'.$payload['phone'] : $payload['phone'];

        try {
            $message = $client->messages->create(
                $phone,
                [
                    'from' => config_item('twilio_phone'),
                    'body' => $payload['message'],
                ]
            );
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        $data = [
            'user' => 1,
            'module' => 'invoices',
            'module_field_id' => 1,
            'activity' => $message,
            'icon' => 'fa-paperplane',
            'value1' => $payload['phone'],
            'value2' => '',
        ];

        App::Log($data);

        return $message;
    }
}
