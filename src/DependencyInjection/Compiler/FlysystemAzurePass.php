<?php

declare(strict_types=1);

namespace TorqIT\FlysystemAzureBundle\DependencyInjection\Compiler;

use League\Flysystem\Visibility;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class FlysystemAzurePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $pimcoreAdapterServiceIdsToCustomAdapters = [
            'flysystem.adapter.pimcore.document_static.storage' => 'document_static_adapter',
            'flysystem.adapter.pimcore.asset.storage' => 'assets_adapter',
            'flysystem.adapter.pimcore.asset_cache.storage' => 'asset_cache_adapter',
            'flysystem.adapter.pimcore.thumbnail.storage' => 'thumbnail_adapter',
            'flysystem.adapter.pimcore.version.storage' => 'version_adapter',
            'flysystem.adapter.pimcore.recycle_bin.storage' => 'recycle_bin_adapter',
            'flysystem.adapter.pimcore.admin.storage' => 'admin_adapter',
            'flysystem.adapter.pimcore.email_log.storage' => 'email_log_adapter',
            'flysystem.adapter.pimcore.temp.storage' => 'tmp_adapter',
            'flysystem.adapter.pimcore.application_log.storage' => 'application_log_adapter',
        ];
        foreach ($pimcoreAdapterServiceIdsToCustomAdapters as $pimcoreServiceId => $customAdapter) {
            $definition = $container->getDefinition($pimcoreServiceId);
            $definition->setClass($container->getDefinition($customAdapter)->getClass());
        }
    }
}
