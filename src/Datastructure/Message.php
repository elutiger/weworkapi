<?php
namespace Elutiger\Weworkapi\Datastructure;

use Elutiger\Weworkapi\Message as BaseMessage;

class Message extends BaseMessage
{
    private $title = null; // string
    private $description = null; // string
    private $url = null; // string
    private $picurl = null; // string
    private $btntxt = null; // string

    public function __construct($receivers = [], $content = [])
    {
        foreach ($receivers as $key => $value) {
            $this->$key = $value;
        }

        foreach ($content as $key => $value) {
            $this->$key = $value;
        }
    }

    public function __get($propertyName)
    {

        return $this->$propertyName ?? null;
    }

    public function __set($property, $value)
    {
        return $this->$property = $value;
    }
}
