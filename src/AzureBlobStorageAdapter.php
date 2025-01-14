<?php

namespace Torq\PimcoreFlysystemAzureBundle;

use DateTimeInterface;
use League\Flysystem\ChecksumProvider;
use League\Flysystem\Config;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\FilesystemException;
use League\Flysystem\UrlGeneration\PublicUrlGenerator;
use League\Flysystem\UrlGeneration\TemporaryUrlGenerator;
use League\MimeTypeDetection\MimeTypeDetector;
use AzureOss\Storage\Blob\BlobContainerClient;

class AzureBlobStorageAdapter implements FilesystemAdapter, ChecksumProvider, TemporaryUrlGenerator, PublicUrlGenerator {
    private \AzureOss\FlysystemAzureBlobStorage\AzureBlobStorageAdapter $wrappedAdapter;

    public function __construct(
        private readonly BlobContainerClient $containerClient,
        string $prefix = "",
        ?MimeTypeDetector $mimeTypeDetector = null,
        private readonly string $visibilityHandling = \AzureOss\FlysystemAzureBlobStorage\AzureBlobStorageAdapter::ON_VISIBILITY_THROW_ERROR,
    ) {
        $this->wrappedAdapter = new \AzureOss\FlysystemAzureBlobStorage\AzureBlobStorageAdapter($this->containerClient, $prefix, $mimeTypeDetector, $this->visibilityHandling);
    }

    /**
     * There appears to be a bug with either the underlying adapter, or Pimcore's use of it -
     * Azure will close the passed $contents stream, but Pimcore will try to do the same,
     * resulting in an error that the stream is no longer valid (since it is already closed).
     * This override makes a copy of the original stream instead and leaves it open and returns that,
     * thus ensuring that Pimcore will be able to successfully close the original.
     * @throws FilesystemException
     */
    public function writeStream(string $path, $contents, Config $config): void
    {
        $tempStream = tmpfile();
        stream_copy_to_stream($contents, $tempStream);
        rewind($tempStream);
        $this->wrappedAdapter->writeStream($path, $tempStream, $config);
    }

    public function checksum(string $path, Config $config): string
    {
        return $this->wrappedAdapter->checksum($path, $config);
    }

    public function fileExists(string $path): bool
    {
        return $this->wrappedAdapter->fileExists($path);
    }

    public function directoryExists(string $path): bool
    {
        return $this->wrappedAdapter->directoryExists($path);
    }

    public function write(string $path, string $contents, Config $config): void
    {
        $this->wrappedAdapter->write($path, $contents, $config);
    }

    public function read(string $path): string
    {
        return $this->wrappedAdapter->read($path);
    }

    public function readStream(string $path)
    {
        $this->wrappedAdapter->readStream($path);
    }

    public function delete(string $path): void
    {
        $this->wrappedAdapter->delete($path);
    }

    public function deleteDirectory(string $path): void
    {
        $this->wrappedAdapter->deleteDirectory($path);
    }

    public function createDirectory(string $path, Config $config): void
    {
        $this->wrappedAdapter->createDirectory($path, $config);
    }

    public function setVisibility(string $path, string $visibility): void
    {
        $this->wrappedAdapter->setVisibility($path, $visibility);
    }

    public function visibility(string $path): FileAttributes
    {
        return $this->wrappedAdapter->visibility($path);
    }

    public function mimeType(string $path): FileAttributes
    {
        return $this->wrappedAdapter->mimeType($path);
    }

    public function lastModified(string $path): FileAttributes
    {
        return $this->wrappedAdapter->lastModified($path);
    }

    public function fileSize(string $path): FileAttributes
    {
        return $this->wrappedAdapter->fileSize($path);
    }

    public function listContents(string $path, bool $deep): iterable
    {
        return $this->wrappedAdapter->listContents($path, $deep);
    }

    public function move(string $source, string $destination, Config $config): void
    {
        $this->wrappedAdapter->move($source, $destination, $config);
    }

    public function copy(string $source, string $destination, Config $config): void
    {
        $this->wrappedAdapter->copy($source, $destination, $config);
    }

    public function publicUrl(string $path, Config $config): string
    {
        return $this->wrappedAdapter->publicUrl($path, $config);
    }

    public function temporaryUrl(string $path, DateTimeInterface $expiresAt, Config $config): string
    {
        return $this->wrappedAdapter->temporaryUrl($path, $expiresAt, $config);
    }
}