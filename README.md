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
