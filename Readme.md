# Composer Download Sleep Plugin

This plugin will sleep for a given amount of seconds before downloading a file.
Purpose is to avoid hitting the rate limit of the provider.

## Installation

- Requirements: PHP ^8.2 and Composer 2.x
- Install the plugin in your project:
  - Globally: `composer global require viosys/composer-download-sleep-plugin`
  - Per project: `composer require viosys/composer-download-sleep-plugin --dev`
- Composer will automatically activate the plugin (type: composer-plugin).

## Configuration

| Name        | Type    | Default | Description                                                                                                                                         |
|-------------|---------|---------|-----------------------------------------------------------------------------------------------------------------------------------------------------|
| duration    | integer | 1       | Number of seconds to sleep before each download                                                                                                     |
| urlsToApply | array   | []      | List of URLs to apply the sleep delay to. Only downloads from these URLs will be delayed. The download URL has to start with one of the given URLs. |

```json
{
    "require": {
        "viosys/composer-download-sleep-plugin": "*"
    },
    "extra": {
        "viosys/composer-download-sleep-plugin": {
            "duration": 2,
            "urlsToApply": [
                "https://packages.example.com"
            ]
        }
    }
}
```

## Development

- Static analysis: install dev dependencies and run PHPStan
  - Install: `composer install`
  - Run: `composer phpstan`
  - Strict: `composer phpstan:strict`

PHPStan is configured via phpstan.neon.dist at level 8 analyzing the src directory.