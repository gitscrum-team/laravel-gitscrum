<?php

namespace GitScrum\Contracts;

interface SlackInterface
{
    public function send($content, $type = 0);
}
