<?php

Abstract class AbstractCsvReader
{
    const MAX_LENGTH = 1000;

    protected $validator;

    protected $sysLogService;

    public function __construct()
    {
        $this->sysLogService = new SysLogService();
    }

    /**
     * @param string $file
     */
    public function perform(string $file)
    {
        if (($handle = fopen($file, "r")) === false) {
            $this->sysLogService->logWarning("readJobsFromFile: Failed to open file [$file]");

            return;
        }

        $fileModel = new FileModel();
        $fileModel->setName($file);
        $fileModel = $fileModel->save();

        $lineNumber = 0;
        $header = [];

        while (($data = fgetcsv($handle, self::MAX_LENGTH, ",")) !== FALSE) {
            $this->initValidator();
            $lineNumber++;

            if (count($header) === 0) {
                $header = array_merge($header, $data);
                $this->validator->validateSchema($header);

                if (count($this->validator->getErrors()) !== 0) {
                    $errors = implode(', ', $this->validator->getErrors());
                    $this->sysLogService->logWarning("Errors; file: $file, errors: $errors");

                    break;
                }

                continue;
            }

            if ($data[0] == NULL) {
                continue;
            }

            $line = $this->prepareLine($header, $data);
            $this->validator->validateLine($line);

            if (count($this->validator->getErrors()) !== 0) {
                $errors = implode(', ', $this->validator->getErrors());
                $this->sysLogService->logWarning("Errors; file: $file, line: $lineNumber, errors: $errors");

                continue;
            }

            $this->save($fileModel, $line);
        }
    }

    /**
     * @param array $header
     * @param array $data
     *
     * @return array
     */
    private function prepareLine(array $header, array $data): array
    {
        $line = [];

        foreach ($header as $key => $value) {
            $line[$value] = isset($data[$key]) ? $data[$key] : null;
        }

        return $line;
    }

    abstract public function initValidator();

    /**
     * @param array $line
     *
     * @return mixed
     */
    abstract public function buildModel(array $line);

    /**
     * @param FileModel $fileModel
     * @param array $line
     *
     * @return mixed
     */
    abstract public function save(FileModel $fileModel, array $line);
}