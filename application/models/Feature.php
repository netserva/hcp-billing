<?php

declare(strict_types=1);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Feature extends CI_Model
{
    private static $db;

    public function __construct()
    {
        parent::__construct();
        self::$db = &get_instance()->db;
    }

    public static function requests()
    {
        self::$db->select('tickets.*, count(distinct hd_ticketreplies.id) as comments');
        self::$db->join('ticketreplies', 'tickets.id = ticketreplies.ticketid', 'left');
        self::$db->from('tickets');
        self::$db->where('department', 6);
        self::$db->group_by('tickets.id');

        return self::$db->get()->result();
    }

    public static function search($text)
    {
        self::$db->select('subject');
        self::$db->from('tickets');
        self::$db->where('department', 6);
        self::$db->like('subject', $text);

        return self::$db->get()->result();
    }

    public static function request($slug)
    {
        self::$db->select('tickets.*');
        self::$db->from('tickets');
        self::$db->where('ticket_code', explode('_', $slug)[0]);

        return self::$db->get()->row();
    }

    public static function replies($slug)
    {
        self::$db->select('ticketreplies.*');
        self::$db->join('tickets', 'tickets.id = ticketreplies.ticketid');
        self::$db->from('ticketreplies');
        self::$db->where('department', 6);
        self::$db->where('ticket_code', explode('_', $slug)[0]);

        return self::$db->get()->result();
    }

    public static function category($name)
    {
        self::$db->select('tickets.*, count(distinct hd_ticketreplies.id) as comments');
        self::$db->join('ticketreplies', 'tickets.id = ticketreplies.ticketid', 'left');
        self::$db->from('tickets');
        self::$db->where('department', 6);
        self::$db->where('type', $name);
        self::$db->group_by('tickets.id');

        return self::$db->get()->result();
    }

    public static function categories()
    {
        self::$db->select('count(distinct id) AS num, type as cat_name');
        self::$db->from('tickets');
        self::$db->where('department', 6);
        self::$db->group_by('cat_name');

        return self::$db->get()->result();
    }
}

// End of file model.php
