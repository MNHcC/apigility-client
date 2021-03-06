<?php
namespace MNHcC\ApigilityClient\Http\Response\Content;

use MNHcC\ApigilityClient\Http\Response\Content\ContentInterface;

abstract class AbstractContent implements ContentInterface
{

    /**
     * @var mixed Response content
     */
    protected $content;

    /**
     * Get the response content
     *
     * @return mixed:
     */
    public function getContent()
    {
        return $this->content;
    }
}
