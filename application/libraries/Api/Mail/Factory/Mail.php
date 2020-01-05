<?php
namespace Api\Mail\Factory;

use Api\Table;

class Mail extends Factory {
    const TABLE = 'Mail';

    public function __construct($id) {
        parent::__construct($id, self::TABLE);
    }

    public function subject($params = []) {
        if (!$this->subject)
            return '';

        if (isset($params['subjectParams']) && is_array($params['subjectParams']) && $params['subjectParams']) {
            foreach ($params['subjectParams'] as $k => $v)
                $this->subject = str_replace('{' . $k . '}', $v, $this->subject);
        }

        return $this->subject;
    }
}