# Cowegis Draw Widget Bundle

The Cowegis Draw Widget Bundle provides a custom widget for drawing and managing vector elements within the Contao CMS. 
It is designed to integrate seamlessly with Contao, offering users an intuitive interface for creating and editing 
map vector drawings.

## Requirements

- **PHP**: ^8.2
- **Contao**: ^5.3

## Installation

To install the Draw Widget Bundle, use Composer. Run the following command in your terminal:
```bash
composer require cowegis/cowegis-contao-draw-widget-bundle
```

## Configuration

The widget uses the `cowegis-editor` HTML element, and it's designed to adjust the editor configuration. You can
customize the initial map settings and the editor toolbar. The configuration is encoded as JSON, so you are not able
to use javascript directly here.

```php
$GLOBALS['TL_DCA']['tl_example']['fields']['vectors'] = [
    'inputType' => 'cowegis_draw',
    'sql'       => 'blob NULL',
    'eval'      => [
        // Height of the widget, defaults to 500px
        'height'  => '500px',
        // Toolbar options, see https://www.geoman.io/docs/toolbar
        // Default:
        'toolbar' => [
            'position' => 'bottomleft',
        ],
        // Leaflet map options, see https://leafletjs.com/reference.html#map-option
        // Default:
        'map' => [
            "maxZoom" => 15,
            "minZoom" => 2,
            "center"  => [0, 0],
            "zoom"    => 2,
        ],
        // Maximum number of vector elements. Toolbar draw buttons get disabled when used.
        'limit' => null
    ]
];
```

If you need to customize the whole configuration, you may define a callback. See the initial config in 
`\Cowegis\Bundle\ContaoDrawWidget\Widget\DrawWidget::editorOptions()`

```php
$GLOBALS['TL_DCA']['tl_example']['fields']['vectors'] = [
    'inputType' => 'cowegis_draw',
    'eval'      => [
        'callback' => function (array $options) {
            var_dump($options);
            
            return $options;
        }
    ]
];
```

## GeoJSON data

GeoJSON does not provide information about circles or circle markers as they are available for Leaflet. To overcome
this limitation this widget adds GeoJSON properties `type` and `radius` to the geometry.

### Circle

The radius for a circle is defined meters, see https://leafletjs.com/reference.html#circle.

```json
{
  "type": "Feature",
  "geometry": {
    "type": "Point",
    "coordinates": [125.6, 10.1]
  },
  "properties": {
    "type": "circle",
    "radius": 100
  }
}
```

### Circle marker

The radius for a circle marker is defined in pixels, see https://leafletjs.com/reference.html#circlemarker.

```json
{
  "type": "Feature",
  "geometry": {
    "type": "Point",
    "coordinates": [125.6, 10.1]
  },
  "properties": {
    "type": "circleMarker",
    "radius": 10
  }
}
```
