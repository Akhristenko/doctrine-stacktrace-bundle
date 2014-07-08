<?php

namespace Akhristenko\Bundle\DoctrineStacktraceBundle;

use Akhristenko\Bundle\DoctrineStacktraceBundle\DependencyInjection\CompilerPass\CompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AkhristenkoDoctrineStacktraceBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CompilerPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION);
    }
}
