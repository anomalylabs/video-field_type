<?php namespace Anomaly\VideoFieldType\Matcher;

use Collective\Html\HtmlBuilder;

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
     * Regular expression
     *
     * @var string
     */
    protected $regex = '@^(?:(?:https?://)?(?:www\.)?youtube\.com/)(?:watch\?v=|v/)([a-zA-Z0-9_]*)@';

    /**
     * The HTML utility.
     *
     * @var HtmlBuilder
     */
    protected $html;

    /**
     * Create a new VimeoMatcher instance.
     *
     * @param HtmlBuilder $html
     */
    public function __construct(HtmlBuilder $html)
    {
        $this->html = $html;
    }

    /**
     * Return the video ID from the video URL.
     *
     * @param $url
     * @return int
     */
    public function id($url)
    {
        preg_match($this->regex, $url, $matches);

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
        return boolean (preg_match($this->regex, $url, $matches));
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
     * @return string
     */
    public function iframe($id, array $attributes = [])
    {
        return '<iframe
            frameborder="0"
            src="https://www.youtube.com/embed/' . $id . '"
            ' . $this->html->attributes($attributes) . '></iframe>';
    }
}
