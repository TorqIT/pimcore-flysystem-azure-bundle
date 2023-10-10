This package enables Pimcore to write to an Azure Storage Account via Flysystem. It acts as a wrapper around https://github.com/thephpleague/flysystem-azure. To install:

1. Run `composer require torqit/pimcore-flysystem-azure-bundle:^2.0`
2. Set environment variables and values for `AZURE_STORAGE_ACCOUNT_NAME`, `AZURE_STORAGE_ACCOUNT_CONTAINER`, `AZURE_STORAGE_ACCOUNT_CONTAINER_ASSETS` and `AZURE_STORAGE_ACCOUNT_KEY` that will allow the bundle to write to your Storage Account.
3. Register the bundle by adding it it to `Kernel.php`. In order to ensure the bundle's configuration is added AFTER Pimcore's, explicitly supply a low priority value (e.g. -100) like so:
        ```php
        use TorqIT\FlysystemAzureBundle\FlysystemAzureBundle;
        class Kernel extends PimcoreKernel
        {
            public function registerBundlesToCollection(BundleCollection $collection) {
                if (class_exists('TorqIT\\FlysystemAzureBundle\\FlysystemAzureBundle')) {
                    $collection->addBundle(new FlysystemAzureBundle, -100);
                }
            }
        }
        ```
        1. Note that you may opt to only use the Storage Account in "upper" environments, and not while developing
           locally. In this case, you can conditionally enable the bundle in `Kernel.php` as follows:
            ```php
            use TorqIT\FlysystemAzureBundle\FlysystemAzureBundle;

            class Kernel extends PimcoreKernel
            {
                public function registerBundlesToCollection(BundleCollection $collection)
                if (class_exists('TorqIT\\FlysystemAzureBundle\\FlysystemAzureBundle')) {
                    if (!array_key_exists('LOCAL', $_ENV) || !$_ENV['LOCAL']) {
                        $collection->addBundle(new FlysystemAzureBundle, -100);
                    }
                }
            }
            ```
           where `LOCAL` is a boolean environment variable that can be set to `true` when developing your app locally.
