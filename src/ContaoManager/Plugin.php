<?php

declare(strict_types=1);

namespace Cowegis\Bundle\ContaoDrawWidget\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Cowegis\Bundle\Client\CowegisClientBundle;
use Cowegis\Bundle\ContaoDrawWidget\CowegisContaoDrawWidgetBundle;

final class Plugin implements BundlePluginInterface
{
    /** {@inheritDoc} */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(CowegisClientBundle::class),
            BundleConfig::create(CowegisContaoDrawWidgetBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class, CowegisClientBundle::class]),
        ];
    }
}
