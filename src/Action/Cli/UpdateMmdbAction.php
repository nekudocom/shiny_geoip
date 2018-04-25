<?php

declare(strict_types=1);

namespace Nekudo\ShinyGeoip\Action\Cli;

class UpdateMmdbAction extends CliAction
{
    /**
     * @var string $pathTmp Path to folder containing mmdb file.
     */
    private $pathTmp = '';

    /**
     * @var string $pathArchive Path to the downloaded mmdb archive.
     */
    private $pathArchive = '';

    /**
     * @var string $pathMmdb Path to current mmdb file.
     */
    private $pathMmdb = '';

    /**
     * @var string $pathMmdbNew Path to new/downloaded mmdb file.
     */
    private $pathMmdbNew = '';

    /**
     * Downloads new mmdb file and replaces the current version with the new one.
     *
     * @param array $arguments
     * @throws \Exception
     */
    public function __invoke(array $arguments)
    {
        $this->initPaths();

        $this->responder->out('Downloading new mmdb...');
        $this->downloadMmdbArchive();

        $this->responder->out('Extracting archive...');
        $this->extractMmdbArchive();

        $this->responder->out('Replacing mmdb file...');
        $this->findMmdbFile();
        $this->replaceMmdbFile();
        $this->cleanup();

        $this->responder->success('Update completed.');
    }

    /**
     * Sets some paths required in other methods.
     */
    private function initPaths()
    {
        $this->pathMmdb = $this->config['mmdb_path'];
        $this->pathTmp = dirname($this->pathMmdb);
        $this->pathArchive = $this->pathTmp . '/' . basename($this->config['mmdb_url']);
    }

    /**
     * Downloads mmdb-archive from url set in configuration.
     *
     * @throws \Exception
     */
    private function downloadMmdbArchive()
    {
        $wgetCommandPattern = 'wget -q -P %s %s';
        $wgetCommand = sprintf($wgetCommandPattern, $this->pathTmp, $this->config['mmdb_url']);
        exec($wgetCommand, $output, $exitCode);
        if ($exitCode !== 0 || false === file_exists($this->pathArchive)) {
            throw new \Exception('Could not download latest mmdb file.');
        }
    }

    /**
     * Extracts mmdb archive into temporary folder.
     *
     * @throws \Exception
     */
    private function extractMmdbArchive()
    {
        $commandPattern = "tar -xf %s -C %s --wildcards --no-anchored '*.mmdb'";
        $unzipCommand = sprintf($commandPattern, $this->pathArchive, $this->pathTmp);
        exec($unzipCommand, $output, $exitCode);
        if ($exitCode !== 0) {
            throw new \Exception('Could not extract mmdb archive.');
        }
    }

    /**
     * Finds path to new mmdb file in temporary folder.
     * This method is needed cause the subfolder in the mmdb tar archive changes.
     *
     * @throws \Exception
     */
    private function findMmdbFile()
    {
        $directory = new \RecursiveDirectoryIterator($this->pathTmp);
        $iterator = new \RecursiveIteratorIterator($directory);
        $regex = new \RegexIterator($iterator, '/^.+\.mmdb$/i', \RegexIterator::GET_MATCH);
        foreach ($regex as $match) {
            $this->pathMmdbNew = ($match[0] === $this->pathMmdb) ? '' : $match[0];
            if ($this->pathMmdbNew !== '') {
                break;
            }
        }

        if ($this->pathMmdbNew === '') {
            throw new \Exception('Could not find new mmdb file.');
        }
    }

    /**
     * Replaces current mmdb file with new one which was just downloaded.
     *
     * @throws \Exception
     */
    private function replaceMmdbFile()
    {
        $res = rename($this->pathMmdbNew, $this->pathMmdb);
        if ($res !== true) {
            throw new \Exception('Could not move mmdb file to target folder.');
        }
    }

    /**
     * Removes temporary files and folders.
     */
    private function cleanup()
    {
        unlink($this->pathArchive);
        rmdir(dirname($this->pathMmdbNew));
    }
}
