# Squared PHP Framework

We've made a nice box (squared) with all sorts of awesome stuff you need to get started. Now it's your turn to think outside of this squared box and build something beautiful.

Squared is a simple, yet beautiful PHP framework. It comes with a bunch of different tools to get started. (We've included a full list a bit further down in this text) With Squared you don't have to spend your time building routes, viewers, cookies and sessions (and alot more) but instead you can just jump straight into your project and build something awesome without having to build your own routers and viewers.

The framework is based on the Model-View-Controller pattern. You can build your controllers inside the `src/Controllers` Folder and you can toss your views into the `resources/views` folder. More details can be found in the documentation.

This project uses Composer for autoloading and dependency management. Visit https://getcomposer.org for more information about Composer.

## List of features

- URL Router
- Template viewing with Twig
- Encryption
- CurlWrapper by [svyatov](https://github.com/svyatov)
- A PDO database wrapper
- Session and cookie handling
- Redirecting and headers
- Mailing through SwiftMailer
- Input validation
- CSRF-Tokens

## TODO List

- Authentication handler
- Middleware functions

## Different Modules

Here you will find reference points for the different modules in the Squared PHP Framework package.

### URL Router

Squared uses a routing system for delivering templates and running functions on request. Documentation can be found here:

You can set up your routes in the `resources/routes/app.php` file.

Here's an example route setup.

> resources/routes/app.php

```
<?php

use Squared\Router\Router;

$router = new Router();

$router::init();

$router::get('/' function() {
  view('home', [], 'homepage');
});

return $router;
```

This code snippet tells our router to create a route at `mysite.com/` and it will run the `view()` function to display our homepage. Full reference found at:

### Template viewing with Twig

Squared uses Twig for dealing with website templates. You can read Twig's documentation here: https://twig.symfony.com/

We have built a public `view()` function that is accessable from anywhere in your script. Here's a demonstration of the `view()` function.

```
view('home', []')
```

We the `view()` function defaults to using Twig, but if you desire not to use Twig in your template, you can add a third parameter to the function with the value `false` to disable Twig.

### Encryption
