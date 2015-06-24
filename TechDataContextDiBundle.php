<?php namespace TechData\ContextDiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use TechData\ContextDiBundle\DependencyInjection\CompilerPass\ContextProviderCompilerPass;
use TechData\ContextDiBundle\DependencyInjection\CompilerPass\ContextConsumerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TechDataContextDiBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ContextProviderCompilerPass());
        $container->addCompilerPass(new ContextConsumerCompilerPass());
    }
}
