# BuzzingPixel Cookie API

Provides a an easy to use API and entity for dealing with cookies in PHP.

## Usage

### Creating a cookie entity

```php
<?php
declare(strict_types=1);

use corbomite\di\Di;
use buzzingpixel\cookieapi\CookieApi;

/** @var CookieApi $cookieApi */
$cookieApi = Di::get('CookieApi');

// Make a cookie entity (same as new \buzzingpixel\cookieapi\Cookie) but more testable as method call
$cookie = $cookieApi->makeCookie('MyCookie', 'MyValue');
```

#### `makeCookie()` or `Cookie::__construct()` arguments

##### `$name`

Type: `string`. Required. The name of the cookie.

##### `$value`

Type: `string`. Required. The value of the cookie.

##### `$expire`

Type: `DateTime` class. Optional. Defaults to 20 years in future.

##### `$path`

Type: `string`. Optional. Defaults to `/` The cookie path.

##### `$domain`

Type: `string`. Optional. Defaults to empty. The domain for the cookie.

##### `$secure`

Type: `boolean`. Optional. Defaults to `false`.

##### `$httpOnly`

Type: `boolean`. Optional. Defaults to `true`.

### Retrieving a cookie

```php
<?php
declare(strict_types=1);

use corbomite\di\Di;
use buzzingpixel\cookieapi\CookieApi;

/** @var CookieApi $cookieApi */
$cookieApi = Di::get('CookieApi');

// Get a cookie by its name. Returns a `\buzzingpixel\cookieapi\Cookie` or null if no cookie set
$cookie = $cookieApi->retrieveCookie('MyCookie');
```

### Save a cookie

```php
<?php
declare(strict_types=1);

use corbomite\di\Di;
use buzzingpixel\cookieapi\CookieApi;

/** @var CookieApi $cookieApi */
$cookieApi = Di::get('CookieApi');

$cookie = $cookieApi->makeCookie('MyCookie', 'MyValue');

$cookieApi->saveCookie($cookie);
```

### Delete a cookie

```php
<?php
declare(strict_types=1);

use corbomite\di\Di;
use buzzingpixel\cookieapi\CookieApi;

/** @var CookieApi $cookieApi */
$cookieApi = Di::get('CookieApi');

// Delete a cookie by passing the cookie entity to be deleted
$cookie = $cookieApi->retrieveCookie('MyCookie');
$cookieApi->deleteCookie($cookie);

// Delete a cookie by name
$cookieApi->deleteCookieByName('MyCookie');
```

## License

Copyright 2018 BuzzingPixel, LLC

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at [http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0).

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
