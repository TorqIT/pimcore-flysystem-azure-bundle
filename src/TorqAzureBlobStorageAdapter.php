<?php

namespace App\Flysystem;

use League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter;
use League\Flysystem\Config;
use League\MimeTypeDetection\MimeTypeDetector;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Internal\StorageServiceSettings;

class TorqAzureBlobStorageAdapter extends AzureBlobStorageAdapter
{
    public function __construct(
        private BlobRestProxy $client,
        private string $container,
        string $prefix = '',
        MimeTypeDetector $mimeTypeDetector = null,
        private int $maxResultsForContentsListing = 5000,
        private string $visibilityHandling = self::ON_VISIBILITY_THROW_ERROR,
        private ?StorageServiceSettings $serviceSettings = null,
    ) {
        parent::__construct($client, $container, $prefix, $mimeTypeDetector, $maxResultsForContentsListing, $visibilityHandling, $serviceSettings);
    }

    /**
     * There appears to be a bug with either Azure's BlobRestProxy,
     * or Pimcore's use of it - Azure will close the passed $contents stream, but Pimcore's 
     * supervisord will try to do the same, resulting in an error that the stream is no
     * longer valid (since it's already closed). This extension makes a copy of the original stream
     * and passes that to Flysystem (and eventually Azure) instead, thus ensuring that Pimcore will be able to successfully
     * close the original.
     */
    public function writeStream(string $path, $contents, Config $config): void
    {
        $tempStream = tmpfile();
        stream_copy_to_stream($contents, $tempStream);
        rewind($tempStream);
        parent::writeStream($path, $tempStream, $config);
    }

}