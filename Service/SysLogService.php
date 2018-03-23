<?php

class SysLogService
{
    /**
     * @param string $error
     */
    public function logWarning(string $error)
    {
        error_log($error . PHP_EOL, 3, LOG_DESTINATION);
    }
}