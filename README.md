# Optimize and Resize images with Laravel in a few lines of code


This package can compress .png, .jpeg and .gif files. Here's how you can use it:

Compress Image,
you can optimize the uploaded image or you can save both of them
```php
use titi23\ImageOptimizer\ImageOptimize;

$optimizedImage = new ImageOptimize();

$optimizedImage->ImageOptimized($pathToImage, $saveOriginal);
```

Resize Image without losing the `AspectRatio` of the original Image
```php
use titi23\ImageOptimizer\ImageOptimize;

$optimizedImage = new ImageOptimize();

$optimizedImage->ResizeAspectRatio($pathToImage, $percent, $saveOriginal);
```

Resize Image with new width but not losing AspectRatio of the original image (without stretching the new image) 
```php
use titi23\ImageOptimizer\ImageOptimize;

$optimizedImage = new ImageOptimize();

$optimizedImage->ResizeWidth($pathToImage, $newWidth, $saveOriginal);
```

### Installation

You can install the package via composer:

```bash
composer require titi23/image-optimizer-and-resizer
```
Copy and Paste the Service Provider in config/app.php

```php
'providers' => [
 ...
 ...
 titi23\ImageOptimizer\ImageOptimizerServiceProvider::class
 ...
]
```

After that, publish the package by running this in your terminal

```bash
 php artisan vendor:publish --tag=image-optimizer --force
```

### Configuration

In the config directory of your project it must be generated a file called `image-optimizer.php`

Description for each attribute:

- `upload_dir` write the name of the directory where you will upload your images e.g. 'uploads/' -ps: the folder must be inside `public`.
- `supportedFormat` array of the types of images that are allowed.
- `compressRate` amount of the compression that image passes through, value between 1 and 100, 1: low quality, 100: high quality
- `resize_percent` percent of the resize of the image, value between 1 and 100, e.g. 50, half of the original version

## Credits

- [Petrit Lame](https://github.com/petritlame/)


## License

The MIT License (MIT)
