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


This package is much more useful if you make sure you create your resources semantically and use proper http tags.

What you will find in your requests table is:

user id, route name, controller name, action (Function assigned on the controller), http method, path_info, uri, query_string,
is_secure, is_ajax, client_ip, client_port, user_agent, referer, server_protocol, request params, request content params, 
http_response_code, stored_on, send_at




