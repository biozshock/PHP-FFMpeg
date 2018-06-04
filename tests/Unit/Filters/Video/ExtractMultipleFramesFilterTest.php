<?php

namespace Tests\FFMpeg\Unit\Filters\Video;

use FFMpeg\Filters\Video\ExtractMultipleFramesFilter;
use Tests\FFMpeg\Unit\TestCase;

class ExtractMultipleFramesFilterTest extends TestCase
{
    /**
     * @dataProvider provideFrameRates
     */
    public function testApply($frameRate, $expected)
    {
        $video = $this->getVideoMock();

        $format = $this->getMockBuilder(\FFMpeg\Format\VideoInterface::class)->getMock();
        $format->expects($this->never())
            ->method('getModulus');

        $filter = new ExtractMultipleFramesFilter($frameRate);
        $this->assertEquals($expected, $filter->apply($video, $format));
    }

    public function provideFrameRates()
    {
        return array(
            array(ExtractMultipleFramesFilter::FRAMERATE_EVERY_SEC, array('-vf', 'fps=1/1')),
            array(ExtractMultipleFramesFilter::FRAMERATE_EVERY_2SEC, array('-vf', 'fps=1/2')),
            array(ExtractMultipleFramesFilter::FRAMERATE_EVERY_5SEC, array('-vf', 'fps=1/5')),
            array(ExtractMultipleFramesFilter::FRAMERATE_EVERY_10SEC, array('-vf', 'fps=1/10')),
            array(ExtractMultipleFramesFilter::FRAMERATE_EVERY_30SEC, array('-vf', 'fps=1/30')),
            array(ExtractMultipleFramesFilter::FRAMERATE_EVERY_60SEC, array('-vf', 'fps=1/60')),
        );
    }
}
