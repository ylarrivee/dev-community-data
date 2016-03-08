# PHP UG Data

[![Build Status](https://travis-ci.org/afilina/phpug-data.svg?branch=master)](https://travis-ci.org/afilina/phpug-data)

The goal is simple: collect all data, current and historical for anyone to use in order to make a stronger PHP community.

Feel free to add your own user group, fix erroneous data and add additional fields.

```json
{
    "name": "Full user group name",
    "first_meetup": "yyyy-mm-dd",
    "last_meetup": "yyyy-mm-dd", // leave blank if still active
    "locations": [
        {
            "name": "City, State (if applies), Country",
            "first_meetup": "yyyy-mm-dd",
            "last_meetup": "yyyy-mm-dd", // leave blank if still active
        }
    ],
    "website": "http://example.com",
    "twitter": "@twitter_handle",
    "calendar_feed": "http://example.com/feed.rss"
}
```
