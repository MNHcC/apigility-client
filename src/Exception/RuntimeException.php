<?php
namespace MNHcC\ApigilityClient\Exception;

use stdClass;

class RuntimeException extends \Exception implements ExceptionInterface
{
    /**
     *
     * @var stdClass
     */
    protected $errorObject = null;
    
    /**
     * RuntimeException throws on error whit respond of the api
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     * @param stdClass $errorObject
     */
    public function __construct($message = "", $code = 0, $previous = null, $errorObject =null) {
        parent::__construct($message, $code, $previous);
        $this->errorObject = $errorObject;
    }
    
    /**
     * 
     * @return stdClass
     */
    public function getErrorObject() {
        return $this->errorObject;
    }

    /**
     * 
     * @param stdClass $errorObject
     * @return $this
     */
    public function setErrorObject($errorObject) {
        $this->errorObject = $errorObject;
        return $this;
    }


}
