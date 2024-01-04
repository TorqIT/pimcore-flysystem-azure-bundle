<?php

namespace TorqIT\FlysystemAzureBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use TorqIT\FlysystemAzureBundle\DependencyInjection\Compiler\FlysystemAzurePass;

class FlysystemAzureBundle extends AbstractPimcoreBundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new FlysystemAzurePass());
    }
}
