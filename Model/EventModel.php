<?php

class EventModel extends AbstractModel
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var FileModel
     */
    protected $file;

    /**
     * @var DateTime
     */
    protected $eventDatetime;

    /**
     * @var string
     */
    protected $eventAction;

    /**
     * @var int
     */
    protected $callRef;

    /**
     * @var float
     */
    protected $eventValue;

    /**
     * @var string
     */
    protected $eventCurrencyCode;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return EventModel
     */
    protected function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return FileModel
     */
    public function getFile(): FileModel
    {
        return $this->file;
    }

    /**
     * @param FileModel $file
     *
     * @return EventModel
     */
    public function setFile(FileModel $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getEventDatetime(): DateTime
    {
        return $this->eventDatetime;
    }

    /**
     * @param DateTime $eventDatetime
     *
     * @return EventModel
     */
    public function setEventDatetime(DateTime $eventDatetime)
    {
        $this->eventDatetime = $eventDatetime;

        return $this;
    }

    /**
     * @return string
     */
    public function getEventAction()
    {
        return $this->eventAction;
    }

    /**
     * @param string $eventAction
     *
     * @return EventModel
     */
    public function setEventAction($eventAction)
    {
        $this->eventAction = $eventAction;

        return $this;
    }

    /**
     * @return int
     */
    public function getCallRef()
    {
        return $this->callRef;
    }

    /**
     * @param int $callRef
     *
     * @return EventModel
     */
    public function setCallRef($callRef)
    {
        $this->callRef = $callRef;

        return $this;
    }

    /**
     * @return float
     */
    public function getEventValue()
    {
        return $this->eventValue;
    }

    /**
     * @param float $eventValue
     *
     * @return EventModel
     */
    public function setEventValue($eventValue)
    {
        $this->eventValue = $eventValue;

        return $this;
    }

    /**
     * @return string
     */
    public function getEventCurrencyCode()
    {
        return $this->eventCurrencyCode;
    }

    /**
     * @param string $eventCurrencyCode
     *
     * @return EventModel
     */
    public function setEventCurrencyCode($eventCurrencyCode)
    {
        $this->eventCurrencyCode = $eventCurrencyCode;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function save(): EventModel
    {
        $fileId = null;

        if(null !== $this->getFile()) {
            $fileId = $this->getFile()->getId();
        }

        $this->databaseManager
            ->query('INSERT INTO event (file_id, event_datetime, event_action, call_ref, event_value, event_currency_code) VALUE (?, ?, ?, ?, ?, ?)',
                $fileId,
                $this->getEventDatetime()->format('Y-m-d H:i:s'),
                $this->getEventAction(),
                $this->getCallRef(),
                $this->getEventValue(),
                $this->getEventCurrencyCode()
            );

        return $this->find($this->databaseManager->lastInsertId());
    }

    /**
     * @inheritdoc
     */
    public function find(int $id): EventModel
    {
        $result = $this->databaseManager->query('select * from event where id = ?', $id)->fetch(PDO::FETCH_ASSOC);


        return $this->map($result);
    }

    /**
     * @inheritdoc
     */
    protected function map($result): EventModel
    {
        return $this
            ->setId($result['id'])
            ->setEventDatetime(new DateTime($result['event_datetime']))
            ->setEventAction($result['event_action'])
            ->setCallRef($result['call_ref'])
            ->setEventValue($result['event_value'])
            ->setEventCurrencyCode($result['event_currency_code']);
    }
}