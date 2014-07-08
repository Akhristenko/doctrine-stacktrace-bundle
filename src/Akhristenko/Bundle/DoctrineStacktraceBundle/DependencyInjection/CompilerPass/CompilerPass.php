<?php

namespace Akhristenko\Bundle\DoctrineStacktraceBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $builder)
    {
        $builder->setParameter('doctrine.data_collector.class', 'Akhristenko\Bundle\DoctrineStacktraceBundle\DataCollector\DoctrineDataCollector');
        $builder->setParameter('doctrine.dbal.logger.profiling.class', 'Akhristenko\Bundle\DoctrineStacktraceBundle\DataCollector\DebugStack');
        $filesystemLoader = $builder->getDefinition('twig.loader.filesystem');
        $filesystemLoader->addMethodCall('prependPath', array(realpath(__DIR__.'/../../Resources/views'), 'Doctrine'));
    }
}