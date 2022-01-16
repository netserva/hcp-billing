<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Fomailer extends Hosting_Billing
{
    public function __construct()
    {
        parent::__construct();
    }

    public function send_email($params)
    {
        if ('FALSE' == config_item('disable_emails')) {
            if ('smtp' == config_item('protocol')) {
                $this->load->library('encryption');
                $this->encryption->initialize(
                    [
                        'cipher' => 'aes-256',
                        'driver' => 'openssl',
                        'mode' => 'ctr',
                    ]
                );
                $raw_smtp_pass = $this->encryption->decrypt(config_item('smtp_pass'));
                $config = [
                    'smtp_host' => config_item('smtp_host'),
                    'smtp_port' => config_item('smtp_port'),
                    'smtp_user' => config_item('smtp_user'),
                    'smtp_pass' => $raw_smtp_pass,
                    'crlf' => "\r\n",
                    'protocol' => config_item('protocol'),
                    'smtp_crypto' => config_item('smtp_encryption'),
                ];
            }

            $this->load->library('email');
            // Send email
            $config['mailtype'] = 'html';
            $config['newline'] = "\r\n";
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = true;

            $this->email->initialize($config);

            $this->email->from(config_item('company_email'), config_item('company_name'));

            if ('TRUE' == config_item('use_alternate_emails') && isset($params['alt_email'])) {
                $alt = $params['alt_email'];
                if ('' != config_item($alt.'_email')) {
                    $this->email->from(config_item($alt.'_email'), config_item($alt.'_email_name'));
                }
            }

            $this->email->to($params['recipient']);

            if (isset($params['cc'])) {
                $this->email->bcc($params['cc']);
            }
            $this->email->subject($params['subject']);
            $this->email->message($params['message']);
            // check attachments
            if ('' != $params['attached_file']) {
                $this->email->attach($params['attached_file']);
            }

            // Queue emails
            if (!$this->email->send()) {
                $this->send_later($params['recipient'], config_item('company_email'), $params['subject'], $params['message']);
            }
        } else {
            // Emails disabled
            return true;
        }
    }

    /**
     * send_later.
     *
     * Log unsent emails to be completed via CRON
     *
     * @param	email params
     * @param mixed $to
     * @param mixed $from
     * @param mixed $subject
     * @param mixed $message
     *
     * @return bool
     */
    private function send_later($to, $from, $subject, $message)
    {
        $emails = [
            'sent_to' => $to,
            'sent_from' => $from,
            'subject' => $subject,
            'message' => $message,
        ];
        $this->db->insert('outgoing_emails', $emails);

        return true;
    }
}

// End of file fomailer.php
