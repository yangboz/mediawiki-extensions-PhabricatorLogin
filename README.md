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

https://secure.phabricator.com/book/phabcontrib/article/using_oauthserver/

Usage
==

Test the `Phabricator.OAuthServer` endpoint:

```sh
curl http://127.0.0.1:86/oauthserver/auth/
```

You receive the following JSON response, which indicates you are not authorized to access the resource:

```json
{
  "error": "OAuth: Malformed Request",
  "error_description": "Required parameter client_id was not present in the request.OAuth Error Code: invalid_request"
}
```

In order to access the protected resource, you must first request an access token via the OAuth handshake. Request OAuth authorization:

Code:

```sh
curl -X POST http://127.0.0.1:86/oauthserver/auth/ -H "Accept: application/json" -d "client_id=PHID-OASC-nzslouj4t6ktbbqhxmeq&response_type=code&redirect_uri=http://127.0.0.1/Special:OAuth2Client/callback"
```

Token:

```sh
curl -X POST http://127.0.0.1:86/oauthserver/auth/ -H "Accept: application/json" -d "client_id=PHID-OASC-nzslouj4t6ktbbqhxmeq&client_secret=tst35gndx2ifzuiz5hwsvitaxuudwvhl&code=YOURCODE&grant_type=token&redirect_uri=http://127.0.0.1/Special:OAuth2Client/callback"
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
http://127.0.0.1:86/api/user.whoami?access_token=mki6bdttynqyyauuq7xpmqjnmey52v7i
```

If the request is successful, you will see the following JSON response:

```json
{
    "result": {
        "phid": "PHID-USER-pt6wom54ozlddkp3kus6",
        "userName": "user",
        "realName": "FirstName LastName",
        "image": "http://127.0.0.1:86/file/data/okjea2eoycua4i7a3n46/PHID-FILE-wqlcx6jjdh5l6jseb4dy/alphanumeric_aleo-white_U.png-_3f674d-255%2C255%2C255%2C0.7.png",
        "uri": "http://127.0.0.1:86/p/user/",
        "roles": [
            "admin",
            "verified",
            "approved",
            "activated"
        ]
        ,
        "primaryEmail": "user@example.com"
    }
    ,
    "error_code": null,
    "error_info": null
}
```

After the specified time period, the `access_token` will expire. Use the `refresh_token` that was returned in the original OAuth authorization to retrieve a new `access_token`:

```sh
curl -X POST -vu PHID-OASC-nzslouj4t6ktbbqhxmeq:tst35gndx2ifzuiz5hwsvitaxuudwvhl http://localhost:8080/oauth/token -H "Accept: application/json" -d "grant_type=refresh_token&refresh_token=f554d386-0b0a-461b-bdb2-292831cecd57&client_secret=123456&client_id=clientapp"
```
More: https://github.com/royclarkson/spring-rest-service-oauth
