<?php

/*
 * This file is part of PHP-FFmpeg.
 *
 * (c) Strime <romain@strime.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FFMpeg\Filters\Video;

use FFMpeg\Filters\FilterInterface;
use FFMpeg\Format\FormatInterface;
use FFMpeg\Media\Video;
use FFMpeg\Filters\TPriorityFilter;

class ExtractMultipleFramesFilter implements FilterInterface
{

    use TPriorityFilter;

    /**
     * will extract a frame every second
     */
    const FRAMERATE_EVERY_SEC = '1/1';

    /**
     * will extract a frame every 2 seconds
     */
    const FRAMERATE_EVERY_2SEC = '1/2';

    /**
     * will extract a frame every 5 seconds
     */
    const FRAMERATE_EVERY_5SEC = '1/5';

    /**
     * will extract a frame every 10 seconds
     */
    const FRAMERATE_EVERY_10SEC = '1/10';

    /**
     * will extract a frame every 30 seconds
     */
    const FRAMERATE_EVERY_30SEC = '1/30';

    /**
     * will extract a frame every minute
     */
    const FRAMERATE_EVERY_60SEC = '1/60';

    /**
     * @var int
     */
    private $priority;

    /**
     * @var string
     */
    private $frameRate;

    public function __construct(string $frameRate = self::FRAMERATE_EVERY_SEC, int $priority = 0)
    {
        $this->setPriority($priority);

        $this->frameRate = $frameRate;
    }

    /**
     * Returns the framerate used.
     * One of the FRAMERATE_EVERY_* constants
     *
     * @return string
     */
    public function getFrameRate(): string
    {
        return $this->frameRate;
    }


    /**
     * @inheritDoc
     */
    public function apply(Video $video, FormatInterface $format): array
    {
        $commands = ['-vf'];
        $commands[] = 'fps=' . $this->frameRate;

        return $commands;
    }
}
