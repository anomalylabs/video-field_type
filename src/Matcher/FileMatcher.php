<?php

namespace Anomaly\VideoFieldType\Matcher;

use Anomaly\Streams\Platform\Image\Image;
use Anomaly\FilesModule\File\Command\GetFile;
use Anomaly\FilesModule\File\Contract\FileInterface;
use Exception;

/**
 * Class FileMatcher
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FileMatcher extends AbstractMatcher
{

    /**
     * The provider.
     *
     * @var string
     */
    protected $provider = 'File';

    /**
     * Return the video ID from the video URL.
     *
     * @param $url
     * @return int
     */
    public function id($url)
    {
        /* @var FileInterface $video */
        if (!$video = $this->instance($url)) {
            return null;
        }

        return $video->getId();
    }

    /**
     * Return if the provided URL matches the vendor.
     *
     * @param $url
     * @return bool
     */
    public function matches($url)
    {
        return (bool) !starts_with($url, ['http://', 'https://']) && str_is('*://*/*', $url);
    }

    /**
     * Return the embed URL for a given video URl.
     *
     * @param $url
     * @return string|null
     */
    public function embed($url)
    {
        /* @var FileInterface $video */
        if (!$video = $this->instance($url)) {
            return null;
        }

        return $video->route('stream');
    }

    /**
     * Return the embeddable iframe code for a given video ID.
     *
     * @param       $id
     * @param array $attributes
     * @param array $parameters
     * @return string
     */
    public function iframe($id, array $attributes = [], array $parameters = [])
    {
        if (!$src = $this->embed($id)) {
            return '';
        }

        return '<iframe
            frameborder="0"
            src="' . $this->attribute($src) . '"
            ' . $this->html->attributes($attributes) . '></iframe>';
    }

    /**
     * Return the video's cover image.
     *
     * @param $id
     * @return Image
     */
    public function cover($id)
    {
        throw new Exception('Cover method not implemented for [File] matcher.');
    }

    /**
     * Return a video image.
     *
     * @param      $id
     * @param null $image
     * @return Image
     */
    public function image($id, $image = null)
    {
        throw new Exception('Image method not implemented for [File] matcher.');
    }

    /**
     * Return the file instance.
     *
     * @param string $url
     * @return FileInterface
     */
    protected function instance($url)
    {
        return dispatch_sync(new GetFile($url));
    }
}
