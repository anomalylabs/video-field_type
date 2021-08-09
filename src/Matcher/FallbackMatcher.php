<?php

namespace Anomaly\VideoFieldType\Matcher;

use Anomaly\Streams\Platform\Image\Image;

/**
 * Class FallbackMatcher
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FallbackMatcher extends AbstractMatcher
{

    /**
     * The provider.
     *
     * @var string
     */
    protected $provider = 'Fallback';

    /**
     * Return the video ID from the video URL.
     *
     * @param $url
     * @return int
     */
    public function id($url)
    {
        return $url;
    }

    /**
     * Return if the provided URL matches the vendor.
     *
     * @param $url
     * @return bool
     */
    public function matches($url)
    {
        return (bool) starts_with($url, ['http://', 'https://']);
    }

    /**
     * Return the embed URL for a given video URl.
     *
     * @param $url
     * @return string
     */
    public function embed($url)
    {
        return $url;
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
        return '<iframe
            frameborder="0"
            src="' . $this->embed($id) . '"
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
        return null;
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
        return null;
    }
}
