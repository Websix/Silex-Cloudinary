# Silex Cloudinary Provider

A service provider to Cloudinary API Client.

## Install

```
composer require mrprompt/silex-cloudinary
```

## Usage

```
use SilexFriends\Cloudinary\Cloudinary as CloudinaryServiceProvider;

$app->register(
    new CloudinaryServiceProvider(
        $cloud_name,
        $api_key,
        $api_secret
    )
);

$file = $app['request']->files->get('file');
$upload = $app['cloudinary.uploader']($file, $options);

print_r($upload);

```


#### License
MIT