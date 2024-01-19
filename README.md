This package enables Pimcore to write to an Azure Storage Account via Flysystem. It acts as a wrapper around https://github.com/thephpleague/flysystem-azure. To install:

1. Run `composer require torqit/pimcore-flysystem-azure-bundle:dev-pimcore-10.x`
2. Set environment variables and values for `AZURE_STORAGE_ACCOUNT_NAME`, `AZURE_STORAGE_ACCOUNT_CONTAINER`, `AZURE_STORAGE_ACCOUNT_ASSETS_CONTAINER` and `AZURE_STORAGE_ACCOUNT_KEY` that will allow the bundle to write to your Storage Account.
3. Enable the bundle by doing one of the following:
   1. Add it to `var/config/extensions.php`:
      ```php
      <?php
       return [
           "bundle" => [
               "TorqIT\\FlysystemAzureBundle\\FlysystemAzureBundle" => TRUE,
           ]
       ];
      ```,
   2. Or, add it to `Kernel.php`:
       ```php
       use TorqIT\FlysystemAzureBundle\FlysystemAzureBundle;

       class Kernel extends PimcoreKernel
       {
           public function registerBundlesToCollection(BundleCollection $collection) {
               $collection->addBundle(new FlysystemAzureBundle);
           }
       }
       ```
1. Add the contents of the file `flysystem_example.yaml` to your project's `flysystem.yaml` file (typically located at `pimcore-root/config/packages/flysystem.yaml`). Note that if you want to enable it in certain environments only, use Symfony environments to accomplish this (i.e. by using a different `flysystem.yaml` in your "local" environment), or use a CD workflow to deploy the configuration detailed here when deploying to upper environments.
