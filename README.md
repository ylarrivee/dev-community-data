# Community Data

[![Build Status](https://travis-ci.org/afilina/dev-community-data.svg?branch=master)](https://travis-ci.org/afilina/community-data)

The goal is simple: collect all data, current and historical for anyone to use in order to make a stronger developer community.

Feel free to add your own record, fix erroneous data and add additional fields.

## User Groups

The file user-groups.json lists all user groups. Leave "last_meetup" blank if still active.

```json
{
    "name": "Full user group name",
    "tags": ["php", "js"],
    "first_meetup": "yyyy-mm-dd",
    "last_meetup": "yyyy-mm-dd", 
    "locations": [
        {
            "name": "City, State (if applies), Country",
            "first_meetup": "yyyy-mm-dd",
            "last_meetup": "yyyy-mm-dd",
        }
    ],
    "website": "http://example.com",
    "twitter": "@twitter_handle",
    "calendar_feed": "http://example.com/feed.rss"
}
```
