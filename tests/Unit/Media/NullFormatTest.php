<?php
/**
 * Created by PhpStorm.
 * User: bumz
 * Date: 04/06/18
 * Time: 10:55
 */

namespace Tests\FFMpeg\Unit\Media;

use FFMpeg\Filters\Video\ExtractMultipleFramesFilter;
use FFMpeg\Format\NullFormat;
use FFMpeg\Media\Video;

class NullFormatTest extends AbstractMediaTestCase
{
    public function testSave()
    {
        $driver = $this->getFFMpegDriverMock();
        $ffprobe = $this->getFFProbeMock();

        $driver->expects($this->once())
            ->method('command')
            ->with(array(
                '-y',
                '-i',
                __FILE__,
                // need to shift indexes because video saver shifts filters to the end
                5 => '-vf',
                6 => '[in]fps=1/10[out]',
                7 => '/tmp/image%03d.jpg',
            ));

        $video = new Video(__FILE__, $driver, $ffprobe);
        $video->filters()
            ->extractMultipleFrames(ExtractMultipleFramesFilter::FRAMERATE_EVERY_10SEC);

        $video->save(new NullFormat(), '/tmp/image%03d.jpg');
    }
}
