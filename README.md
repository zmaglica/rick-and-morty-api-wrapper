# The Rick and Morty API wrapper with query builder

[![Latest Version on Packagist](https://img.shields.io/packagist/v/zmaglica/rick-and-morty-api-wrapper.svg?style=flat-square)](https://packagist.org/packages/zmaglica/rick-and-morty-api-wrapper)
[![Build Status](https://img.shields.io/travis/zmaglica/rick-and-morty-api-wrapper/master.svg?style=flat-square)](https://travis-ci.org/zmaglica/rick-and-morty-api-wrapper)
[![Quality Score](https://img.shields.io/scrutinizer/g/zmaglica/rick-and-morty-api-wrapper.svg?style=flat-square)](https://scrutinizer-ci.com/g/zmaglica/rick-and-morty-api-wrapper)
[![Total Downloads](https://img.shields.io/packagist/dt/zmaglica/rick-and-morty-api-wrapper.svg?style=flat-square)](https://packagist.org/packages/zmaglica/rick-and-morty-api-wrapper)

This PHP package is wrapper for https://rickandmortyapi.com/ with query builder that is similar to Doctrine and Laravel database query builder. It contains popular function like where clauses, easy pagination, eager loading of results and many other things.

## Installation

You can install the package via composer:

```bash
composer require zmaglica/rick-and-morty-api-wrapper
```

## Usage

Default query function that can be use on all API endpoints

``` php
where() // Add custom filtering. where(['name' => 'Rick'])
clear() // Clear all filters (where clauses)
whereId() // Add character, location or episode ID to where clause whereId([1,2,3])
setPage() // Specify request page. Example: setPage(2)
nextPage() // Set next page
previousPage() // Set previous page
raw() // Execute raw URI to the Rick and Morty API without any filters and pages
```

Default functions that can be used **AFTER** request is performed

``` php
toArray() // Get results as array
toJson() // Get results as json
isFirstPage() // Check if request result page is first page
isLastPage() //Check if request result page is last page
count() // Get total number of records
pages() // Get total number of pages
prev() // Send request to fetch data from previous page
next() // Send request to fetch data from next page
first() // Send request to fetch data from first page
goToPage(int $page) // Send request to fetch data from desired page
last() // Send request to fetch data from last page
```

Create instance of API wrapper like this

``` php
$api = new RickAndMortyApiWrapper() 
```

You can set up your own GuzzleHTTP client by calling `setClient()` method . Also you can pass array to class constructor to add custom Guzzle HTTP configuration options

##### Character

Character API documentation can be found here: https://rickandmortyapi.com/documentation/#character

First, create instance of API wrapper

``` php
$api = new RickAndMortyApiWrapper() 
```

After that call method `character()` where you can execute API calls for character schema

``` php
$characterApi = $api->character(); // Or you can directly call new RickAndMortyApiWrapper()->character()
```
After that you can execute The Rick and Morty API calls.

##### Examples:

Get all characters

``` php
$characterApi->all();
```
Get single character

``` php
$characterApi->get(1);
```
Get multiple characters

``` php
$characterApi->get([1,2,3]);
```
Get character origin location

``` php
$characterApi->getOrigin(1);
```
Get character last known location

``` php
$characterApi->getLocation(1);
```

Add "Status" filter to request
``` php
$characterApi->isAlive() // fetch alive characters
$characterApi->isDead() // fetch dead characters
$characterApi->isStatusUnknown() // fetch characters with unknown status
```

Add "Gender" filter to request
``` php
$characterApi->isFemale() // fetch female characters
$characterApi->isMale() // fetch male characters
$characterApi->isGenderless() // fetch genderless characters
$characterApi->isGenderUnknown() // fetch unknown gender characters
```

Run custom query parameter using built-in where functionality
``` php
$characterApi->where(['status' => 'alive', 'gender' => 'female']) //Get all female characters that are alive.
```
Same query can be achieved by using this:
 ``` php
 $characterApi->isAlive()->isFemale()
 ```
Custom filtering can be achieved by using available filter with where clause (whereFilterName) 
``` php
$characterApi->whereName('Rick') // filter by the given name.
$characterApi->whereStatus('alive') //  filter by the given status (alive, dead or unknown).
$characterApi->whereType('Korblock') //   filter by the given type.
$characterApi->whereGender('female') // filter by the given gender (female, male, genderless or unknown).
```

**After** you execute API call you can fetch location and episodes from founded characters using these methods:

``` php
$characterApi->all()->locations() // Get instace of Location API from founded characters. Pass false to constructor if you want to remove duplicates
$characterApi->all()->getLocations() // Get all location from founded characters. Pass false to constructor if you want to remove duplicates
$characterApi->all()->origins() // Get instace of origin Location API from founded characters. Pass false to constructor if you want to remove duplicates
$characterApi->all()->getOrigins() // Get all origin location from founded characters. Pass false to constructor if you want to remove duplicates
$characterApi->all()->episodes() // Get instace of Episode API from founded characters. Pass false to constructor if you want to remove duplicates
$characterApi->all()->getEpisodes() // Get all episode from founded characters. Pass false to constructor if you want to remove duplicates
```
Here is the example of getting all episodes alive characters that are females.

``` php
$characterApi->isAlive()->isFemale->get()->getEpisodes();
// Same thing can be achieved by using following code
$characterApi->whereStatus('alive')->whereGender('female')->get()->getEpisodes();
// and using this code
$characterApi->where(['status' => 'alive', 'gender' => 'female'])->get()->getEpisodes();
// even shorter by calling getEpisodes() instead of get()
$characterApi->isAlive()->isFemale()->getEpisodes();


```
### Todo

 - Add more examples and update documentation for Location and Episode API 

### Testing

``` bash
vendor/bin/phpunit
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email zvonimirmaglica4@gmail.com instead of using the issue tracker.

## Credits

- [Zvonimir Maglica](https://github.com/zmaglica)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com).
