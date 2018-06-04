<?php
/**
 * Created by PhpStorm.
 * User: bumz
 * Date: 04/06/18
 * Time: 12:02
 */

namespace Tests\FFMpeg\Functional;


use FFMpeg\Filters\Video\ExtractMultipleFramesFilter;
use FFMpeg\Format\NullFormat;

class FramesExtractTest extends FunctionalTestCase
{
    /**
     * @param int $framesPerSecond
     * @param int $expectedImages
     *
     * @dataProvider framesProvider
     */
    public function testFramesCount($framesPerSecond, $expectedImages)
    {
        $filenameTemplate = __DIR__ . '/output/image%02d.jpg';
        $files = array();
        for ($i=1; $i < $expectedImages + 1; $i++) {
            $filename = sprintf($filenameTemplate, $i);
            if (is_file($filename)) {
                unlink($filename);
            }
            $files[] = $filename;
        }

        $ffmpeg = $this->getFFMpeg();
        $video = $ffmpeg->open(__DIR__ . '/../files/Test.ogv');

        $this->assertInstanceOf('FFMpeg\Media\Video', $video);

        $video->filters()
            ->extractMultipleFrames($framesPerSecond);

        $video->save(new NullFormat(), $filenameTemplate);
        for ($i=1; $i < $expectedImages + 1; $i++) {
            $filename = sprintf($filenameTemplate, $i);
            $this->assertFileExists($filename);
            unlink($filename);
        }

        // next frame was not fetched
        $this->assertFileNotExists(sprintf($filenameTemplate, $i));
    }

    public function framesProvider()
    {
        $calls = [];

        // video length is 00:00:29.53 and ffmpeg catches frame on second 0
        $calls[] = [ExtractMultipleFramesFilter::FRAMERATE_EVERY_2SEC, 16];
        $calls[] = [ExtractMultipleFramesFilter::FRAMERATE_EVERY_SEC, 30];

        return $calls;
    }
}
