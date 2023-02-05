<p align="center">
    <img src="public/assets/webby-readme.png" width="600" alt="Webby">
</p>

[![MIT License](https://img.shields.io/github/license/sylynder/webby)](https://github.com/tterb/atomic-design-ui/blob/master/LICENSEs) ![Lines of code](https://img.shields.io/tokei/lines/github/sylynder/webby) ![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/sylynder/webby) ![Packagist Version](https://img.shields.io/packagist/v/sylynder/webby) ![Packagist Downloads (custom server)](https://img.shields.io/packagist/dt/sylynder/webby)

## About Webby

**Webby** aims to be a "lego-like" PHP framework that allows you to build APIs, Console/Cli and Web Applications in a modular architecture, that can also integrate other features from existing PHP frameworks or other PHP packages with ease. 

It is an extension of the CodeIgniter 3 framework for easy web application development with an easy developer experience (DX) for beginners.

Build Awesome PHP applications with a "Simple(Sweet) Application Architecture". 

## Features

- Easy and Improved Routing
- HMVC First Architecture
- Application can be APIs, Console or Web Based
- Easy to integrate with Other Frameworks
- Extend with Packages
- Use "Plates" a blade-like templating engine for your views
- Use "Services" to seperate business logic from Controllers
- Use "Actions" instead of "Services" for CRUD functionalities or business logic
- Use "Forms Or Rules" to validate input requests
- A near "Service discovery" feature included
- Use any database abstraction or library you want as a model

## Authors

- [@otengkwame](https://www.github.com/otengkwame)
- [All Contributors][webby-contributors]
- [All Sylynder Engine Contributors][engine-contributors]

## Installation

The recommended way to install Webby is [through Composer](https://getcomposer.org/).
Are you [New to Composer?](https://getcomposer.org/doc/00-intro.md) click on the link.

This will install the latest PHP supported version:

```bash
$ composer create-project sylynder/webby <project-name>
```

Make sure to replace *project-name* with the name of your project

## Documentation

The main documentation of Webby can be found here: [Webby Docs](https://webby.sylynder.com/docs)

The documentation is currently been updated constantly. It will take time to cover all aspects of the framework but we are working around the clock to make this possible. 

Currently we have planned to use the blogs section to guide developers through their journey in learning the framework.

If you have been developing with CodeIgniter 3 already and you are familiar with the HMVC approach you can still use the same knowlegde to get going.

For developers who are very familiar with the CodeIgniter 3 framework can still refer to the documentation here: [CI3 Docs](https://www.codeigniter.com/userguide3/index.html)

The concept of CodeIgniter 4 has not been so clear and rewriting CodeIgniter 3 has set the framework back in so many ways, this is a way to show that Codeigniter could have been improved gradually without the approach the Core Team 
used.


## Server Requirements

PHP version 8.0 or newer is recommended.

PHP 8.1 was released in November 2021 and so most of it's functionalities were not known to be supported yet, this delayed the development of this project to work perfectly with the latest version 8.1 of PHP and the framework, ~~we advise to stay between versions 7.4 and 8.0 for stable PHP appplication development.~~ 

~~If you want to discover bugs and contribute, then you are welcome to use the PHP 8.1 version.~~

Currently it supports 8.1 but no issues have come up yet. All issues can be discussed and it will be addressed. PHP 8.2 is here since December 2022. We will be looking forward to related issues too to resolve. Currently some issues have already been fixed.

## Quick FAQs

#### Why did you decide to create Webby
---
* Webby was created with PHP beginners in mind, to simplify how web applications can be built (with PHP) without complex concepts and functionalities
* Looking at how other (PHP) frameworks makes it difficult for beginners to start, we are making the approach different. 
* Also CodeIgniter 3 was not been updated for sometime and new PHP versions were not working until they updated to the recent version (3.1.13).
* I used it as an opportunity to learn and understand more about Software Architecture and creating Software Paradigms.

#### Is it anything different from CodeIgniter 3 or 4?
---
It uses the Core of the CodeIgniter 3 framework and borrows some new features added from CodeIgniter 4. It is designed to move developers who are familiar with CI3 to easily adapt to CI4 with a little similar syntax or concept.


## Important Links

The links below will guide you to know more about how Webby Works

* [Installation Guide](https://webby.sylynder.com/docs/installation/)
* [Getting Started](https://webby.sylynder.com/docs/getting-started/)
* [Contribution Guide](https://webby.sylynder.com/docs/contribution-guide/)
* [Learn Webby](https://blog.webby.sylynder.com)
* [Community](https://github.com/sylynder/webby/discussions)


## What's Next
There are lots of future plans for Webby

* [x] Enable and Test for PHP 8.1 compatibility
* [x] Improve and simplify CI3's database migrations
* [x] Enable module based packages to use composer packages
* [x] Enable easy engine folder upgrade (Currently folder will have to be replaced when an update is available) (Done on 30th October 2022 18:22 PM)
* [x] Move sylynder/codeigniter repo to sylynder/engine repo (Done on 31st December 2022 15:08 PM)
* [ ] Create a compatible HTTP and Routing feature (may be PSR-7 compatible)  that enables general integration with other frameworks
* [ ] Improve and optimize speed
* [ ] Improve on cli or console feature
* [ ] Integrate asynchronous features (may be fibers) [as a package]
* [ ] And many more to add (and many more to learn)
* [ ] Write version three (v3) with a few major class api change but try to not make heavy breaking changes so as to reduce future upgrade headache. Unlike other major PHP Frameworks



## Used By

This project is used by the following companies:

- Seguah Dreams
- Glomot Company
- Wigal Vision

## Credits

- Rougin (https://github.com/rougin/spark-plug)
- Yidas (https://github.com/yidas/codeigniter-rest)
- Chriskacerguis (https://github.com/chriskacerguis/codeigniter-restserver)
- Nobitadore (https://github.com/nobitadore/Arrayz)
- Lonnieezell (https://github.com/lonnieezell/Bonfire)
- GustMartins (https://github.com/GustMartins/Slice-Library)
- CodeIgniter 3 (https://github.com/bcit-ci/CodeIgniter)
- CodeIgniter 4 (https://github.com/codeigniter4/CodeIgniter4)
- [All Contributors][engine-contributors]


## License

We are using the MIT License (MIT). Please see our LICENSE.md file. If you want to know more about the license go to [LICENSE]((https://choosealicense.com/licenses/mit/)) for more information.

[webby-contributors]: https://github.com/sylynder/webby/contributors

[engine-contributors]: https://github.com/sylynder/engine/contributors
