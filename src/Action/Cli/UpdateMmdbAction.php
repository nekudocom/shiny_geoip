<?php

declare(strict_types=1);

namespace Nekudo\ShinyGeoip\Action\Cli;

class UpdateMmdbAction extends CliAction
{
    private $tmpPath = '';

    private $mmdbArchiveName = '';

    private $mmdbFileName = '';

    public function __invoke(array $arguments)
    {
        $this->initPaths();

        $archiveUrl = $this->config['mmdb_url'];
        $tmpPath = dirname($this->config['mmdb_path']);


        $archivePath = $this->downloadMmdbArchive($archiveUrl, $tmpPath);
        $this->extractMmdbArchive($archivePath, $tmpPath);
        $pathNewMmdb = $this->findMmdbFile($tmpPath);
        $this->replaceMmdbFile($this->config['mmdb_path'], $pathNewMmdb);
        $this->cleanup($archivePath, dirname($pathNewMmdb));
        $this->responder->success('Update completed.');
    }

    private function initPaths()
    {
        $this->tmpPath = dirname($this->config['mmdb_path']);
        $this->mmdbArchiveName = basename($this->config['mmdb_url']);
        $this->mmdbFileName = basename($this->config['mmdb_path']);
    }

    private function downloadMmdbArchive(string $archiveUrl, string $targetPath): string
    {
        $this->responder->out('Starting download of mmdb file...');
        $wgetCommandPattern = 'wget -q -P %s %s';
        $wgetCommand = sprintf($wgetCommandPattern, $targetPath, $archiveUrl);
        exec($wgetCommand, $output, $exitCode);
        if ($exitCode !== 0) {
            throw new \Exception('Could not download latest mmdb file.');
        }

        $this->responder->out('Download completed.');
        return $targetPath . '/' . basename($archiveUrl);
    }

    private function extractMmdbArchive(string $archivePath, string $tmpPath)
    {
        $this->responder->out('Extracting archive...');
        $commandPattern = "tar -xf %s -C %s --wildcards --no-anchored '*.mmdb'";
        $unzipCommand = sprintf(
            $commandPattern,
            $archivePath,
            $tmpPath
        );
        exec($unzipCommand, $output, $exitCode);
        if ($exitCode !== 0) {
            throw new \Exception('Could not extract mmdb archive.');
        }
    }

    private function findMmdbFile(string $tmpPath): string
    {
        $newDbPath = '';
        $directory = new \RecursiveDirectoryIterator($tmpPath);
        $iterator = new \RecursiveIteratorIterator($directory);
        $regex = new \RegexIterator($iterator, '/^.+\.mmdb$/i', \RegexIterator::GET_MATCH);
        foreach ($regex as $match) {
            $newDbPath = ($match[0] === $this->config['mmdb_path']) ? '' : $match[0];
            if ($newDbPath !== '') {
                break;
            }
        }

        if ($newDbPath === '') {
            throw new \Exception('Could not find new mmdb file.');
        }

        return $newDbPath;
    }

    private function replaceMmdbFile(string $pathOldMmdb, string $pathNewMmdb)
    {
        $res = rename($pathOldMmdb, $pathNewMmdb);
        if ($res !== true) {
            throw new \Exception('Could not move mmdb file to target folder.');
        }
    }

    private function cleanup(string $archivePath, string $newMmdbFolder)
    {
        unlink($archivePath);
        rmdir($newMmdbFolder);
    }
}
