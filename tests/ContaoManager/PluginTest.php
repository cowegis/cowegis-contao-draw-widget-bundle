<?php

declare(strict_types=1);

namespace Cowegis\Bundle\ContaoDrawWidget\Test\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Cowegis\Bundle\Client\CowegisClientBundle;
use Cowegis\Bundle\ContaoDrawWidget\ContaoManager\Plugin;
use Cowegis\Bundle\ContaoDrawWidget\CowegisContaoDrawWidgetBundle;
use PHPUnit\Framework\TestCase;

/** @covers \Cowegis\Bundle\ContaoDrawWidget\ContaoManager\Plugin */
final class PluginTest extends TestCase
{
    public function testGetBundles(): void
    {
        // Create a mock ParserInterface
        $parser = $this->createMock(ParserInterface::class);

        // Instantiate the Plugin
        $plugin = new Plugin();

        // Call the getBundles method
        $bundles = $plugin->getBundles($parser);

        // Assert that the returned array contains one BundleConfig object
        $this->assertCount(1, $bundles);

        // Assert that the BundleConfig object is configured correctly
        $this->assertInstanceOf(BundleConfig::class, $bundles[0]);
        $this->assertSame(CowegisContaoDrawWidgetBundle::class, $bundles[0]->getName());
        $this->assertSame([ContaoCoreBundle::class, CowegisClientBundle::class], $bundles[0]->getLoadAfter());
    }
}
