# Carsguide

Twitter Search API

# Installation
  - composer install
  - npm install
  - npm run production

# Tests
  - command "phpunit"
  - command "php artisan dusk"

# Dusk Tests
  - uses chrome driver to run tests

# Caching
  - Software will cache the Bearer token so it only calls once
  - Checks the cache each time to see if the bearer is stored, if not generates new token
  
# Database
Chosen not to use a database as the search API will constantly pull new results, caching is used for the bearer.

# Frontend
Boots a VueJs App.  The app uses axios to do the api requests.  VueJs manages the state of the client side.

