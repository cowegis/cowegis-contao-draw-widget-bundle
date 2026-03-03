<?php

declare(strict_types=1);

namespace Cowegis\Bundle\ContaoDrawWidget\DependencyInjection;

use Override;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

final class CowegisContaoDrawWidgetExtension extends Extension
{
    /** {@inheritDoc} */
    #[Override]
    public function load(array $configs, ContainerBuilder $container): void
    {
    }
}
