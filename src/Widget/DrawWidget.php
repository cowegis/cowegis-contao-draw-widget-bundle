<?php

declare(strict_types=1);

namespace Cowegis\Bundle\ContaoDrawWidget\Widget;

use Contao\Widget;

/** @psalm-suppress PropertyNotSetInConstructor */
final class DrawWidget extends Widget
{
    /** @var bool */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $blnSubmitInput = true;

    /** @var bool */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $blnForAttribute = true;

    /** @var string */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $strTemplate = 'be_cowegis_draw_widget';

    public function generate(): string
    {
        return '';
    }
}
