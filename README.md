URLess
======

Open-Source minimalist PHP URL Shortener

Requirement: 
PHP 5.2

Optionnal:
cURL for checking the url
PDO and/or SQLite for using database instead of file structure

API
===

A small API is implemented

Use api.php

There is three parameters:
- request
- url
- id
 
request is required all the time. The value must be "add" or "get"
url is required when request is "add"
id is required when request is "get"

The response is a JSON array, with one or two row

The row "type" indicate the type of the response. The value can be : 
- ok : no error during process
- bad_api : error in api construction
- no_url : only with "get" request. there is no url at the selected id
- bad_url : only with "add". the url is not a valid url
- unknown : an unknown error has occured
 
The second row is "msg", only present where type is "ok"
- in "add" request, it contains the generated id for the url
- in "get" request, it contains the url for the id

