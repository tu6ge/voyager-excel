# Voyager Excel Contributing Guide

We love it when the community can contribute code, this is a contributing guide:

## Etiquette

This project is an open source project, and as such, the maintainers use their free time to build and maintain it. The code is freely available and can be used, forked and modified.

Please be considerate towards maintainers when raising issues or presenting pull requests.

It's the duty of the maintainer to ensure that all submissions to the project are of sufficient quality to benefit the project. Many developers have different skill sets, strengths, and weaknesses. Respect the maintainer's decision, and do not be upset or abusive if your submission is not used.

## Environment

- php ^7.3 or ^7.4
- laravel ^6 or ^7
- voyager ^1.4 stable version

You should install Voyager first, [install documents](https://github.com/the-control-group/voyager#installation-steps)

## Fork this repository to your github

## Clone your github repository to local path

you should be create a new laravel project , and go to the Laravel directory, clone your repository: 

```
root
|-vendor
|-voyager-excel
...
```

## require tu6ge/voyage-excel in your composer.json

open your composer.json in laravel project root path.

write the content:
```
    ...
    "require": {
        ...
        "tu6ge/voyager-excel":"*"
    },
    "repositories": [
        {
            "type":"path",
            "url": "./voyager-excel"
        }
    ]
    ...
```

and run `composer dump` command. this is finished.

## Run

run `php artisan serve` , you can quick preview it in voyager.

## Implement your ideas

