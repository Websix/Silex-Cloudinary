<?php
declare(strict_types = 1);

namespace W6\Cloudinary;

use Cloudinary as Driver;
use Cloudinary\Uploader;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Cloudinary Service
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
final class Cloudinary implements CloudinaryInterface, ServiceProviderInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * Cloudinary constructor.
     *
     * @param string $cloud_name
     * @param string $api_key
     * @param string $api_secret
     */
    public function __construct(string $cloud_name, string $api_key, string $api_secret)
    {
        $this->config = [
            'cloud_name' => $cloud_name,
            'api_key'    => $api_key,
            'api_secret' => $api_secret,
        ];
    }

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     * @param Application $app
     */
    public function register(Application $app)
    {
        Driver::config($this->config);

        $service = $this;

        $app[static::UPLOADER] = $app->protect(
            function (UploadedFile $file, $options = []) use ($service) {
                return $service->createFromFile($file, $options);
            }
        );

        $app[static::IMPORTER] = $app->protect(
            function (string $url, $options = []) use ($service) {
                return $service->createFromUrl($url, $options);
            }
        );
    }

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::boot()
     * @param Application $app
     */
    public function boot(Application $app)
    {
        // :)
    }

    /**
     * @inheritdoc
     */
    public function createFromFile(UploadedFile $file, $options = []): array
    {
        return Uploader::upload($file, $options);
    }

    /**
     * @inheritdoc
     */
    public function createFromUrl(string $url, $options = []): array
    {
        return Uploader::upload($url, $options);
    }
}
