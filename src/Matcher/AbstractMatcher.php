<?php namespace Anomaly\VideoFieldType\Matcher;

use Anomaly\Streams\Platform\Image\Image;
use Anomaly\VideoFieldType\Matcher\Contract\MatcherInterface;
use Anomaly\Streams\Platform\Html\HtmlBuilder;

/**
 * Class AbstractMatcher
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
abstract class AbstractMatcher implements MatcherInterface
{

    /**
     * The provider.
     *
     * @var null|string
     */
    protected $provider = null;

    /**
     * The HTML utility.
     *
     * @var HtmlBuilder
     */
    protected $html;

    /**
     * The image service.
     *
     * @var Image
     */
    protected $image;

    /**
     * Create a new VimeoMatcher instance.
     *
     * @param HtmlBuilder $html
     * @param Image       $image
     */
    public function __construct(HtmlBuilder $html, Image $image)
    {
        $this->html  = $html;
        $this->image = $image;
    }

    /**
     * Return the video ID from the video URL.
     *
     * @param $url
     * @return int
     */
    abstract public function id($url);

    /**
     * Return if the provided URL matches the vendor.
     *
     * @param $url
     * @return bool
     */
    abstract public function matches($url);

    /**
     * Return the embed URL for a given video URl.
     *
     * @param $url
     * @return string
     */
    abstract public function embed($url);

    /**
     * Return the embeddable iframe code for a given video ID.
     *
     * @param       $id
     * @param array $attributes
     * @param array $parameters
     * @return string
     */
    abstract public function iframe($id, array $attributes = [], array $parameters = []);

    /**
     * Return the video's cover image.
     *
     * @param $id
     * @return Image
     */
    abstract public function cover($id);

    /**
     * Return a video image.
     *
     * @param      $id
     * @param null $image
     * @return Image
     */
    abstract public function image($id, $image = null);

    /**
     * Get the provider.
     *
     * @return null|string
     */
    public function getProvider()
    {
        return $this->provider;
    }
}
