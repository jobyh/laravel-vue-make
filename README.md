# laravel-react-make

**This is an Alpha release expect breaking changes ahead**

Artisan generator for React components. Currently being written
for Laravel 7 but should work for 6 (5?). Will have Laravel 7
stub support.

## Usage

Generate a React function component:

```
$ php artisan react:component MyComponent
# -> resources/js/components/MyComponent.js
```

Generate under a subdirectory (short version `-d` is also available):

```
$ php artisan react:component --dir='foo/bar' MyComponent
# -> resources/js/components/foo/bar/MyComponent.js
```

Use `.jsx` file extension (short version `-x` is also available)

```
$ php artisan react:component --jsx MyComponent
# -> resources/js/components/MyComponent.jsx
```
