<?php

namespace Nekudo\ShinyGeoip\Cli;

class GeonamesImporter
{
    const REDIS_HOST = '127.0.0.1';

    const REDIS_PORT = 6379;

    const REDIS_DB = 0;

    const DATA_FIELD_COUNT = 19;

    private $fileHandle = null;

    private $importCount = 0;

    /** @var \Redis $redis */
    private $redis = null;

    public function __construct()
    {
        $this->checkRequirements();
    }

    public function import($pathToDatabase)
    {
        if (!file_exists($pathToDatabase)) {
            throw new \RuntimeException('Geonames database not found.');
        }

        $this->init($pathToDatabase);

        foreach ($this->getRow() as $row) {
            // skip row id field count does not match:
            $fieldCount = count($row);
            if ($fieldCount !== self::DATA_FIELD_COUNT) {
                continue;
            }

            $this->store($row);
        }

        printf("Import completed. %d rows imported.", $this->importCount);
        echo "\n";

        $this->deinit();
    }

    private function init($pathToDatabase)
    {
        $this->importCount = 0;

        // open geonames database:
        $this->fileHandle = fopen($pathToDatabase, 'r');
        if ($this->fileHandle === false) {
            throw new \RuntimeException('Could not open geonames database.');
        }

        // connect to redis database:
        $this->redis = new \Redis;
        $this->redis->connect(self::REDIS_HOST, self::REDIS_PORT);
        $this->redis->select(self::REDIS_DB);
    }


    private function deinit()
    {
        // close open file-pointer:
        fclose($this->fileHandle);

        // close connection to redis database:
        $this->redis->close();
    }

    private function getRow()
    {
        while (($data = fgetcsv($this->fileHandle, 1000, "\t")) !== false) {
            yield $data;
        }
    }

    private function store($row)
    {
        $key = $row[0];
        $value = json_encode($row);
        $res = $this->redis->set($key, $value);
        $this->importCount += ($res === true) ? 1 : 0;
    }

    private function checkRequirements()
    {
        // check if script is running in cli mode:
        if (php_sapi_name() !== 'cli') {
            throw new \RuntimeException('This script can only be executed in CLI mode.');
        }

        // check if redis extension is installed:
        if (class_exists('Redis') === false) {
            throw new \RuntimeException('Redis extension is not installed.');
        }
    }
}

try {
    $importer = new GeonamesImporter;
    $importer->import(__DIR__ . '/../data/cities1000.txt');
} catch (\Exception $e) {
    print_r('Error: ' . $e->getMessage());
}
