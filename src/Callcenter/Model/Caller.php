<?php
declare(strict_types=1);

namespace Callcenter\Model;

class Caller
{
    /**
     * @var string
     */
    public $callerid;

    /**
     * @var string
     */
    public $uid;

    /**
     * @var string
     */
    public $hash;

    /**
     * @var string
     */
    public $queue = '';

    /**
     * @var string
     */
    public $status = "NA";

    /**
     * @var int
     */
    public $time;

    /**
     * Caller constructor.
     * @param string $callerid
     * @param string $uid
     */
    public function __construct(string $callerid, string $uid)
    {
        $this->callerid = $callerid;
        $this->uid = $uid;

        $this->hash = sha1($callerid.$uid);

        $this->time = time();
    }

    /**
     * @param string $queue
     */
    public function setQueue(string $queue) : void
    {
        $this->queue = $queue;
        $this->setStatus('QUEUED');
    }

    /**
     * @return string
     */
    public function getStatus() : string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getQueue() : string
    {
        return $this->queue;
    }

    /**
     * @return int
     */
    public function getDuration() : int
    {
        return time() - $this->time;
    }

    /**
     * @param string $status
     * @return bool
     */
    public function setStatus(string $status) : bool
    {
        $status = strtoupper($status);

        if ($this->status == $status) {
            return false;
        }

        $this->status = $status;
        $this->time = time();

        return true;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return (($this->callerid)?:"anonymous")."|{$this->status}|{$this->hash}";
    }

    /**
     * @return string
     */
    public function getReportLine() : string
    {
        $duration = time() - $this->time;

        return date('Y-m-d H:i:s').";CALLER;{$this->callerid};{$this->status};$duration;{$this->queue}";
    }
}
