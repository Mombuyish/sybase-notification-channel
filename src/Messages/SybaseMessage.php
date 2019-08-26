<?php

namespace Yish\Notifications\Messages;

class SybaseMessage
{
    public $content;

    public $subject;

    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    public function subject($subject)
    {
        $this->subject = $subject;

        return $this;
    }
}
