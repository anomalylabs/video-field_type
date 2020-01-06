<?php

namespace Anomaly\VideoFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;
use Anomaly\Streams\Platform\Addon\Plugin\PluginCriteria;
use Anomaly\Streams\Platform\Support\Collection;
use Anomaly\VideoFieldType\Matcher\Command\GetMatcher;

/**
 * Class VideoFieldTypePresenter
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class VideoFieldTypePresenter extends FieldTypePresenter
{

    /**
     * The decorated object.
     * This is for IDE hinting.
     *
     * @var VideoFieldType
     */
    protected $object;

    /**
     * Return the embed iframe.
     *
     * @param array $attributes
     * @param array $parameters
     * @return PluginCriteria
     */
    public function iframe(array $attributes = [], array $parameters = [])
    {
        if (!$this->object->getValue()) {
            return null;
        }

        /* @var \Anomaly\VideoFieldType\Matcher\Contract\\Anomaly\VideoFieldType\Matcher\Contract\MatcherInterface $matcher */
        $matcher = dispatch_now(new GetMatcher($this->object->getValue()));

        return new PluginCriteria(
            'render',
            function (Collection $options) use ($matcher, $attributes, $parameters) {

                // Autoplay normalization
                if ($options->pull('autoplay', false) == true) {
                    $parameters['autoplay'] = array_get($parameters, 'autoplay', true);
                }

                // Normalize allow attribute
                $attributes['allow'] = array_get($attributes, 'allow', '') . 'autoplay;';

                return $matcher->iframe(
                    $matcher->id($this->object->getValue()),
                    $options->merge($attributes)->all(),
                    $parameters
                );
            }
        );
    }

    /**
     * Return the embed iframe.
     *
     * @param array $attributes
     * @param array $parameters
     * @return PluginCriteria
     */
    public function fluid(array $attributes = [], array $parameters = [])
    {
        if (!$this->object->getValue()) {
            return null;
        }

        /* @var \Anomaly\VideoFieldType\Matcher\Contract\MatcherInterface $matcher */
        $matcher = dispatch_now(new GetMatcher($this->object->getValue()));

        return new PluginCriteria(
            'render',
            function (Collection $options) use ($matcher, $attributes, $parameters) {

                $attributes['style'] = 'position: absolute; top: 0; left: 0; width: 100%; height: 100%;';

                return '<div style="position: relative; padding-bottom: 56.25%; padding-top: 30px; height: 0; overflow: hidden;">' . $matcher->iframe(
                    $matcher->id($this->object->getValue()),
                    $options->merge($attributes)->all(),
                    $parameters
                ) . '</div>';
            }
        );
    }

    /**
     * Return the embed URL.
     *
     * @return string
     */
    public function embed()
    {
        if (!$this->object->getValue()) {
            return null;
        }

        /* @var \Anomaly\VideoFieldType\Matcher\Contract\MatcherInterface $matcher */
        $matcher = dispatch_now(new GetMatcher($this->object->getValue()));

        return $matcher->embed($this->object->getValue());
    }

    /**
     * Return the video ID.
     *
     * @return int
     */
    public function id()
    {
        if (!$this->object->getValue()) {
            return null;
        }

        /* @var \Anomaly\VideoFieldType\Matcher\Contract\MatcherInterface $matcher */
        $matcher = dispatch_now(new GetMatcher($this->object->getValue()));

        return $matcher->id($this->object->getValue());
    }

    /**
     * Return the video provider.
     *
     * @return string
     */
    public function provider()
    {
        if (!$this->object->getValue()) {
            return null;
        }

        /* @var \Anomaly\VideoFieldType\Matcher\Contract\MatcherInterface $matcher */
        $matcher = dispatch_now(new GetMatcher($this->object->getValue()));

        return $matcher->getProvider();
    }

    /**
     * Return the player.
     *
     * @return string
     */
    public function player()
    {
        return view(
            'anomaly.field_type.video::player',
            [
                'video' => $this,
            ]
        )->render();
    }

    /**
     * Return the cover image.
     *
     * @return null
     */
    public function cover()
    {
        if (!$this->object->getValue()) {
            return null;
        }

        /* @var \Anomaly\VideoFieldType\Matcher\Contract\MatcherInterface $matcher */
        $matcher = dispatch_now(new GetMatcher($this->object->getValue()));

        return $matcher->cover($this->id());
    }

    /**
     * Return an image.
     *
     * @param null $image
     * @return null
     */
    public function image($image = null)
    {
        if (!$this->object->getValue()) {
            return null;
        }

        /* @var \Anomaly\VideoFieldType\Matcher\Contract\MatcherInterface $matcher */
        $matcher = dispatch_now(new GetMatcher($this->object->getValue()));

        return $matcher->image($this->id(), $image);
    }
}
