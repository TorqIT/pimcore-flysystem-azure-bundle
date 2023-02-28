This package enables Pimcore to write to an Azure Storage Account via Flysystem. It acts as a wrapper around https://github.com/thephpleague/flysystem-azure. To install:

1. Run `composer require torqit/azure-flysystem-bundle:^1.0`
2. Set environment variables and values for `AZURE_STORAGE_ACCOUNT_NAME`, `AZURE_STORAGE_ACCOUNT_CONTAINER` and `AZURE_STORAGE_ACCOUNT_KEY` that will allow the bundle to write to your Storage Account.