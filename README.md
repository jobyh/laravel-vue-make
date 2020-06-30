# laravel-vue-make
[![Build Status](https://travis-ci.com/jobyh/laravel-vue-make.svg?branch=main)](https://travis-ci.com/jobyh/laravel-vue-make)

Artisan generator for Vue component files. Supports Laravel 7, 6 &amp; 5.8.

## Why?

- I scaffold stuff up using Artisan a lot
- It's straight-forward to use and consistent


## Quick start

```
% cd /path/to/laravel/project
% composer require --dev jobyh/laravel-vue-make
```

### Customise Stubs

I use Tailwind for styles so the default stubs don't
contain a `<style>` tag. You might though so...

Publishing stubs in Laravel 7 is a [great feature](https://laravel.com/docs/7.x/artisan#stub-customization).
Yes please.

```
% php artisan vendor:publish --tag vue-stub
```

## Usage

Generate a Vue component file:

```
% php artisan vue:component MyComponent
# -> resources/js/components/MyComponent.vue
```

Generate under a subdirectory (short version `-d` is also available):

```
% php artisan vue:component --dir='foo/bar' MyComponent
# -> resources/js/components/foo/bar/MyComponent.js
```
