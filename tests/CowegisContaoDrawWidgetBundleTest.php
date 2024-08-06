<?php

declare(strict_types=1);

namespace Tests\Cowegis\Bundle\ContaoDrawWidget;

use Cowegis\Bundle\ContaoDrawWidget\CowegisContaoDrawWidgetBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class CowegisContaoDrawWidgetBundleTest extends TestCase
{
    public function testInstanceOfBundle(): void
    {
        $bundle = new CowegisContaoDrawWidgetBundle();
        $this->assertInstanceOf(Bundle::class, $bundle);
    }
}
