# Composer Download Sleep Plugin

This plugin will sleep for a given amount of seconds before downloading a file.
Purpose is to avoid hitting the rate limit of the provider.

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