This package enables Pimcore to write to an Azure Storage Account via Flysystem. It acts as a wrapper around https://github.com/thephpleague/flysystem-azure. To install:

1. Run `composer require torqit/pimcore-flysystem-azure-bundle`
2. Set environment variables and values for `AZURE_STORAGE_ACCOUNT_NAME`, `AZURE_STORAGE_ACCOUNT_CONTAINER`, `AZURE_STORAGE_ACCOUNT_CONTAINER_ASSETS` and `AZURE_STORAGE_ACCOUNT_KEY` which will allow the bundle to write to your Storage Account.
3. Register the bundle by adding it to your `Kernel.php`. In order to ensure the bundle's configuration is added AFTER Pimcore's Flysystem configuration, explicitly supply a low priority value (e.g. -100) like so:
    ```php
    class Kernel extends PimcoreKernel
    {
        public function registerBundlesToCollection(BundleCollection $collection) {
            $collection->addBundle(new \TorqIT\FlysystemAzureBundle\FlysystemAzureBundle\FlysystemAzureBundle, -100);
        }
    }
