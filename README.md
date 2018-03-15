PhabricatorLogin MediaWiki Extension
=====================

This Extension provides a Phabricator Login Special page to login with a Phabricator account to a
the MediaWiki User account.

Requirements
==
* MediaWiki Version 1.28+
* MySQL (sorry, no PostgreSQL or SQLite support for now)
* PHP 5.5+
* Phabricator Developer Account with Google+ API access
* Phabricator OAuth server
* API Credentials for Phabricator OAuthServerApplication (Client ID and Client Secret)

Installation and Configuration
==
See https://github.com/yangboz/mediawiki-extensions-PhabricatorLogin


References
=======

This Extension uses the Google API PHP Client, a free software licensed under Apacha 2.0:

https://github.com/google/google-api-php-client

https://github.com/google/google-api-php-client/blob/master/LICENSE

https://secure.phabricator.com/book/phabcontrib/article/using_oauthserver/

https://upload.wikimedia.org/wikipedia/commons/4/49/Wikimania_2011-_A_brief_introduction_to_MediaWiki_extension_development.pdf

http://blog.soton.ac.uk/webteam/2010/04/13/254/

Usage
==

Test the `greeting` endpoint:

```sh
curl http://localhost:8080/greeting
```

You receive the following JSON response, which indicates you are not authorized to access the resource:

```json
{
  "error": "unauthorized",
  "error_description": "An Authentication object was not found in the SecurityContext"
}
```

In order to access the protected resource, you must first request an access token via the OAuth handshake. Request OAuth authorization:

```sh
curl -X POST -vu clientapp:123456 http://localhost:8080/oauth/token -H "Accept: application/json" -d "password=spring&username=roy&grant_type=password&scope=read%20write&client_secret=123456&client_id=clientapp"
```

A successful authorization results in the following JSON response:

```json
{
  "access_token": "ff16372e-38a7-4e29-88c2-1fb92897f558",
  "token_type": "bearer",
  "refresh_token": "f554d386-0b0a-461b-bdb2-292831cecd57",
  "expires_in": 43199,
  "scope": "read write"
}
```

Use the `access_token` returned in the previous request to make the authorized request to the protected endpoint:

```sh
curl http://localhost:8080/greeting -H "Authorization: Bearer ff16372e-38a7-4e29-88c2-1fb92897f558"
```

If the request is successful, you will see the following JSON response:

```json
{
  "id": 1,
  "content": "Hello, Roy!"
}
```

After the specified time period, the `access_token` will expire. Use the `refresh_token` that was returned in the original OAuth authorization to retrieve a new `access_token`:

```sh
curl -X POST -vu clientapp:123456 http://localhost:8080/oauth/token -H "Accept: application/json" -d "grant_type=refresh_token&refresh_token=f554d386-0b0a-461b-bdb2-292831cecd57&client_secret=123456&client_id=clientapp"
```
More: https://github.com/royclarkson/spring-rest-service-oauth
