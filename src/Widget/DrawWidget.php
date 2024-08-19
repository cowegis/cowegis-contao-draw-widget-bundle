<?php

declare(strict_types=1);

namespace Cowegis\Bundle\ContaoDrawWidget\Widget;

use Contao\Widget;

use function array_merge;
use function in_array;
use function json_decode;

/**
 * @property string|null                                             $height   Height as css value, e.g. 300px
 * @property array<string,mixed>                                     $map      Map options
 * @property array<string,mixed>                                     $toolbar  Toolbar options
 * @property callable(array<string,mixed>): array<string,mixed>|null $callback Callback
 * @property string|null                                             $language Customized language of the editor
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class DrawWidget extends Widget
{
    private const SUPPORTED_LANGUAGES = [
        'cz',
        'da',
        'de',
        'el',
        'en',
        'es',
        'fa',
        'fi',
        'fr',
        'hu',
        'id',
        'it',
        'ja',
        'ko',
        'ky',
        'nl',
        'no',
        'pl',
        'pt_br',
        'ro',
        'ru',
        'sv',
        'tr',
        'ua',
        'zh',
        'zh_tw',
    ];

    /** @var bool */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $blnSubmitInput = true;

    /** @var bool */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $blnForAttribute = true;

    /** @var string */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $strTemplate = 'be_cowegis_draw_widget';

    /** {@inheritDoc} */
    public function __construct(array|null $arrAttributes = null)
    {
        parent::__construct($arrAttributes);

        $this->decodeEntities = true;
    }

    public function generate(): string
    {
        return '';
    }

    /** @return array<string, mixed> */
    public function editorOptions(): array
    {
        /** @psalm-var string $language */
        $language = $this->language ?? $GLOBALS['TL_LANGUAGE'];

        /**
         * @psalm-suppress MixedArgument
         * @psalm-suppress MixedMethodCall
         */
        $options = [
            'map'    => [
                'options'  => array_merge(
                    [
                        'maxZoom' => 15,
                        'minZoom' => 2,
                        'center'  => [0, 0],
                        'zoom'    => 2,
                    ],
                    $this->map ?? [],
                ),
                'bounds'  => ['adjustAfterLoad' => true],
                'controls' => [
                    [
                        'controlId' => 'geocoder',
                        'type'      => 'geocoder',
                        'options'   => [
                            'defaultMarkGeocode' => false,
                            'collapsed'          => false,
                            'placeholder'        => /** @psalm-suppress MixedMethodCall */ self::getContainer()
                                ->get('translator')
                                ->trans('cowegis.draw.searchLabel', [], 'contao_default'),
                        ],
                    ],
                    [
                        'controlId' => 'fullscreen',
                        'type'      => 'fullscreen',
                        'options'   => [],
                    ],
                ],
                'layers'   => [
                    [
                        'layerId'        => 'osm',
                        'type'           => 'tileLayer',
                        'urlTemplate'    => 'https://{s}.tile.osm.org/{z}/{x}/{y}.png',
                        'initialVisible' => true,
                        'options'        => [
                            'attribution' => '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a>'
                                . ' contributors',
                        ],
                    ],
                    [
                        'layerId' => 'data',
                        'type'    => 'data',
                        'initialVisible' => true,
                        'options' => [
                            'pane'         => null,
                            'adjustBounds' => true,
                            'pmIgnore'     => false,
                        ],
                        'data' => [
                            'type'   => 'inline',
                            'format' => 'geojson',
                            'data'   => $this->value
                                ? json_decode($this->value, true)
                                : ['type' => 'FeatureCollection', 'features' => []],
                        ],
                    ],
                ],
                'editor' => [
                    'language' => in_array($language, self::SUPPORTED_LANGUAGES, true)
                        ? $language
                        : 'en',
                    'toolbar'  => array_merge(
                        ['position' => 'bottomleft'],
                        $this->toolbar ?? [],
                    ),
                ],
            ],
            'assets' => [
                [
                    'type' => 'stylesheet',
                    'url'  => 'bundles/cowegisclient/css/cowegis.css',
                ],
            ],
        ];

        if ($this->callback !== null) {
            $configCallback = $this->callback;
            $options        = $configCallback($options);
        }

        return $options;
    }
}
