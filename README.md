This package enables Pimcore to write to an Azure Storage Account via Flysystem. It acts as a wrapper around https://github.com/thephpleague/flysystem-azure. To install:

1. Run `composer require torqit/azure-flysystem-bundle:^1.0`
2. Set environment variables and values for `AZURE_STORAGE_ACCOUNT_NAME`, `AZURE_STORAGE_ACCOUNT_CONTAINER` and `AZURE_STORAGE_ACCOUNT_KEY` that will allow the bundle to write to your Storage Account.
3. Enable the bundle by doing one of the following:
    1. Add it to `var/config/extensions.php`:
       ```php
       <?php
        return [
            "bundle" => [
                "TorqIT\\FlysystemAzureBundle\\FlysystemAzureBundle" => TRUE,
            ]
        ];
       ```
    2. Add it to `Kernel.php`:
        ```php
        use TorqIT\FlysystemAzureBundle\FlysystemAzureBundle;

        class Kernel extends PimcoreKernel
        {
            public function registerBundlesToCollection(BundleCollection $collection)
            if (class_exists('TorqIT\\FlysystemAzureBundle\\FlysystemAzureBundle')) {
                $collection->addBundle(new FlysystemAzureBundle);
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
                        $collection->addBundle(new FlysystemAzureBundle);
                    }
                }
            }
            ```
           where `LOCAL` is a boolean environment variable that can be set to `true` when developing your app locally.