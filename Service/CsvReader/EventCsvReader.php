<?php

class EventCsvReader extends AbstractCsvReader
{
    public function initValidator()
    {
        $this->validator = new EventCsvValidator();
    }

    public function buildModel(array $line)
    {
        $eventModel = new EventModel();

        foreach ($line as $key => $value) {
            $methodName = 'set' . ucfirst($key);

            if($methodName === 'setEventDatetime') {
                $eventModel->$methodName(new DateTime($value));
                continue;
            }

            $eventModel->$methodName($value);
        }

        return $eventModel;
    }

    public function save(FileModel $fileModel, array  $line)
    {
        $model = $this->buildModel($line);

        $model
            ->setFile($fileModel)
            ->save();
    }
}