<?php

class FileService
{
    /**
     * @param $dir
     * @param null|string $extension
     *
     * @return array
     */
    public function getFromDirectory($dir, $extension = null) : array
    {
        $listFileAndDir = scandir($dir);

        unset($listFileAndDir[0]);
        unset($listFileAndDir[1]);

        if (null !== $extension) {
            // Regex to pull out with extension.
        }

        return array_values($listFileAndDir);
    }

    /**
     * @param string $fileName
     * @param string $source
     * @param string $destination
     *
     * @throws Exception
     */
    public function moveToDirectory(string $fileName, string $source, string $destination)
    {
        $fileSource = $source . '/' . $fileName;
        $fileDestination = $destination . '/' . $fileName;

        if (!file_exists($fileSource)) {
            throw new \Exception('the file ' . $fileName . ' Doesn\'t exist');
        }

        if (copy($fileSource, $fileDestination)) {
            unlink($fileSource);
        }
    }
}