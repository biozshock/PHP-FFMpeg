<?php
/**
 * Created by PhpStorm.
 * User: bumz
 * Date: 04/06/18
 * Time: 10:53
 */

namespace FFMpeg\Format;


class NullFormat implements FormatInterface
{
    public function getPasses()
    {
        return 1;
    }

    public function getExtraParams()
    {
        return array();
    }
}
