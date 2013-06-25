Alligator
=========

Alligator is a PHP plugin for regator.com.

Search best blogs posts from keywords & get url, title and description.

<a href="http://regator.com" target="_blank">http://regator.com</a> does not sponsor this API.

Requirements
------------
* PHP 5.2.0 or newer
* <a href="https://github.com/92bondstreet/swisscode" target="_blank">SwissCode</a>


What comes in the package?
--------------------------
1. `alligator.php` - The Alligator class functions to get results from request to regator.com
2. `example.php` - All Alligator functions call


Example.php
-----------

	// Init constructor with false value: no dump log file
	$alligator = new Alligator();

	// Get best blog posts from keywords
	$posts = $alligator->search_allblogs("google chrome",30); 
	print_r($posts);


To start the demo
-----------------
1. Upload this package to your webserver.
4. Open `example.php` in your web browser and check screen output. 
5. Enjoy !


Project status
--------------
Alligator is currently maintained by Yassine Azzout.


Authors and contributors
------------------------
### Current
* [Yassine Azzout][] (Creator, Building keeper)

[Yassine Azzout]: http://www.92bondstreet.com


License
-------
[MIT license](http://www.opensource.org/licenses/Mit)

