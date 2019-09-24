<?php

namespace EasyCorp\EasyLog;

use Monolog\Handler\StreamHandler;

class EasyLogHandler extends StreamHandler
{
    /**
     * @param resource|string $stream
     */
    public function __construct($stream)
    {
        parent::__construct($stream);

        $this->formatter = new EasyLogFormatter();
    }

    /**
     * @param array $record
     */
    public function handle(array $record)
    {
        throw new \RuntimeException('The method "handle()" should never be called (call "handleBatch()" instead). This is probably caused by a wrong "monolog" configuration. Please read EasyLogHandler README instructions to learn how to configure and use it.');
    }

    /**
     * @param array $records
     */
    public function handleBatch(array $records)
    {
        // if the log records were filtered (by channel, level, etc.) the array
        // no longer contains consecutive numeric keys. Make them consecutive again
        // before the log processing (this eases getting the next/previous record)
        $records = array_values($records);

        if ($records) {
            $this->write($this->getFormatter()->formatBatch($records));
        }
    }
}
