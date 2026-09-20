<?php namespace Anomaly\VideoFieldType\Matcher;

use Anomaly\Streams\Platform\Image\Image;

/**
 * Class FlipbaseMatcher
 *
 * @link   http://pyrocms.com/
 * @author Wirelab Digital Creatives <info@wirelab.nl>
 * @author Tim Peters <tim@wirelab.nl>
 */
class FlipbaseMatcher extends AbstractMatcher
{

    /**
     * The provider.
     *
     * @var string
     */
    protected $provider = 'Flipbase';

    /**
     * Return the video ID from the video URL.
     * The ID consists of two parts seperated with a ':'
     * The first part is the customer subdomain,
     * the second part is the video id.
     *
     * @param $url
     * @return string like 'example:some-uuid'
     */
    public function id($url)
    {
        $segments      = explode('/', substr(parse_url($url, PHP_URL_PATH), 1));
        $host_segments = explode('.', parse_url($url, PHP_URL_HOST));

        return $host_segments[0] . ':' . end($segments);
    }

    /**
     * Return if the provided URL matches the vendor.
     *
     * @param $url
     * @return bool
     */
    public function matches($url)
    {
        return str_contains($url, 'flipbase.com');
    }

    /**
     * Return the embed URL for a given video URl.
     *
     * @param $url
     * @return string
     */
    public function embed($url)
    {
        $id = explode(':', $this->id($url));

        return 'https://' . $id[0] . '.flipbase.com/embed/' . $id[1];
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
        $segments = explode(':', $id);

        $src = 'https://' . $segments[0] . '.flipbase.com/embed/' . $segments[1]
            . '?' . http_build_query($parameters);

        return '<iframe
            frameborder="0"
            src="' . $this->attribute($src) . '"'
            . $this->html->attributes($attributes) . '></iframe>';
    }

    /**
     * Return the video's cover image.
     *
     * @todo Currently this is not implmented.
     * @param $id
     * @return Image
     */
    public function cover($id)
    {
        dd('not yet implemented');

        return '';
    }

    /**
     * Return a video image.
     *
     * @todo Currently this is not implmented.
     * @param      $id
     * @param null $image
     * @return Image
     */
    public function image($id, $image = null)
    {
        dd('not yet implemented');

        return '';
    }
}
