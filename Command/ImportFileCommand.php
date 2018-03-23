<?php

Class ImportFileCommand implements CommandInterface
{
    const DIRECTORY_SOURCE = 'uploaded';
    const DIRECTORY_DESTINATION = 'processed';

    public function execute()
    {
        $fileService  = new FileService();

        $fileList = $fileService->getFromDirectory(self::DIRECTORY_SOURCE);

        foreach ($fileList as $file) {
            $eventCsvReader = new EventCsvReader();

            $eventCsvReader->perform(self::DIRECTORY_SOURCE . '/' . $file);

            $fileService->moveToDirectory($file, self::DIRECTORY_SOURCE, self::DIRECTORY_DESTINATION);
        }
    }
}