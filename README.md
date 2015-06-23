Podium
===
The project is in its initial stage, your welcome to Contribute.
Podium is a simple, flexible & powerful AngularJS starter theme for wordpress, foundation and gulp support 

Requirements
---
- [livereload chrome extension](https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei).
- [Node.js 0.12.x](https://nodejs.org).
- [PHP >= 5.4.x](http://php.net/)
- [gulp >= 3.8.10](http://gulpjs.com/).
- [Bower >= 1.3.12](http://bower.io/).

Features
---

Installation
---


### Install gulp and Bower

Building the theme requires [node.js](http://nodejs.org/download/). We recommend you update to the latest version of npm: `npm install -g npm@latest`.

From the command line:

1. Install [gulp](http://gulpjs.com) and [Bower](http://bower.io/) globally with `npm install -g gulp bower`
2. Navigate to the theme directory, then run `npm install`
3. Run `bower install`

You now have all the necessary dependencies to run the build process.

### Available gulp commands

* `gulp` — Compile and optimize the files in your assets directory
* `gulp watch` — Compile assets when file changes are made

Don't forget to remove this line from functions.php file:

```php
define('WP_ENV', 'development');
```
before your theme uploaded to the production server.

## Documentation
TODO

## Contributing

Contributions are welcome from everyone.