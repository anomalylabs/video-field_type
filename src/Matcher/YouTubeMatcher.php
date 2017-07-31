<?php namespace Anomaly\VideoFieldType\Matcher;

use Anomaly\Streams\Platform\Image\Image;

/**
 * Class YouTubeMatcher
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class YouTubeMatcher extends AbstractMatcher
{

    /**
     * The provider.
     *
     * @var string
     */
    protected $provider = 'YouTube';

    /**
     * The regex pattern.
     *
     * @var string
     */
    protected $pattern = '/^(?:(?:https?:\/\/)?(?:www\.)?youtu\.?be(?:\.com)?\/)(?:watch\?v=|v\/)?([a-zA-Z0-9_-]*)/';

    /**
     * Return the video ID from the video URL.
     *
     * @param $url
     * @return int
     */
    public function id($url)
    {
        preg_match($this->pattern, $url, $matches);

        return array_get($matches, 1);
    }

    /**
     * Return if the provided URL matches the vendor.
     *
     * @param $url
     * @return bool
     */
    public function matches($url)
    {
        return (bool)preg_match($this->pattern, $url, $matches);
    }

    /**
     * Return the embed URL for a given video URl.
     *
     * @param $url
     * @return string
     */
    public function embed($url)
    {
        return 'https://www.youtube.com/embed/' . $this->id($url);
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
        $parameters = $parameters ?: ['rel' => 0];

        return '<iframe
            frameborder="0"
            src="https://www.youtube.com/embed/' . $id . '?' . http_build_query($parameters) . '"
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
        return $this->image->make('https://img.youtube.com/vi/' . $id . '/0.jpg', 'image');
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
        return $this->image->make('https://img.youtube.com/vi/' . $id . '/' . ($image ?: 1) . '.jpg', 'image');
    }
}
