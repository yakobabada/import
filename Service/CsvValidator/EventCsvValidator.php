<?php

class EventCsvValidator extends AbstractCsvValidator
{
    public function __construct()
    {
        $this->schema = [
            'eventDatetime' => [
                'required' => true,
                'type' => 'string',
                'format' => 'yyyy-mm-dd hh:mm:ss',
            ],
            'eventAction' => [
                'required' => true,
                'type' => 'string',
                'length' => [
                    'min' => 1,
                    'max' => 20
                ]
            ],
            'callRef' => [
                'required' => true,
                'type' => 'int'
            ],
            'eventValue' => [
                'type' => 'float'
            ],
            'eventCurrencyCode' => [
                'type' => 'string',
                'length' => 3
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function checkExtraCondition(array $line)
    {
        if ($line['eventValue'] !== 0 && empty($line['eventCurrencyCode'])) {
            $this->addError('eventCurrencyCode shouldn\'t be empty as event value is provided');
        }
    }
}