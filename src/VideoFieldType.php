<?php

namespace Anomaly\VideoFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

/**
 * Class VideoFieldType
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class VideoFieldType extends FieldType
{

    /**
     * The field input view.
     *
     * @var string
     */
    protected $inputView = 'anomaly.field_type.video::input';
}
