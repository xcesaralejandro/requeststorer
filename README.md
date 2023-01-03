## Introduction

This package allows to store the requests received inside a table in the database. This information is useful for later building reports regarding the site. Although this is quite simple to do with the tools provided by Laravel, it is always good to have a starting base.

## Requirements

php >= 8.0

## Install

#### 1.- Add the package to your project

`composer require xcesaralejandro/requeststorer`

#### 2.- Publish the provider (MANDATORY NON-TRADABLE)

`php artisan vendor:publish --provider="xcesaralejandro\requeststorer\Providers\RequestStorerServiceProvider" --force`

#### 3.- Run migrations

`php artisan migrate`

## Usage
After following the installation steps, the package will have created two new files in its Middleware folder, these are the ones in charge of registering the respective request information.
If you want to store new columns just overwrite the migration and modify the middleware in your project, the package will load them from there and that's why publishing the vendor is mandatory.


The only thing you need to do to start storing your requests is to add the following middleware to your routes:

````store.on.arrival````

This middleware will store the request before going through the controller.


````store.on.response````

This middleware will store the request once it is answered.



In some cases you won't need to store parameters or the response, as they may contain login credentials and keeping them raw can be a security issue. To avoid storing some columns just pass the name as a parameter to the middleware

````store.on.arrival:column1,column2````

````store.on.response:column1,column2````

column1 and column2 will be filled with null when storing the request.




