<?php

/*
 * This file is part of the PDF Version Converter.
 *
 * (c) Thiago Rodrigues <xthiago@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tests\Converter;

use Mrden\PDFVersionConverter\Converter\GhostscriptConverter;
use Mrden\PDFVersionConverter\Converter\GhostscriptConverterCommand;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Thiago Rodrigues <xthiago@gmail.com>
 */
class GhostscriptConverterTest extends TestCase
{
    use ProphecyTrait;

    protected $tmp;

    protected function setUp(): void
    {
        $this->tmp = __DIR__.'/../files/stage';

        if (!file_exists($this->tmp))
            mkdir($this->tmp);
    }

    protected function tearDown(): void
    {
    }

    /**
     * @param string $file
     * @param $newVersion
     *
     * @dataProvider filesProvider
     */
    public function testMustConvertPDFVersionWithSuccess(string $file, $newVersion)
    {
        $fs = $this->prophesize(Filesystem::class);
        $fs->exists(Argument::type('string'))
            ->willReturn(true)
            ->shouldBeCalled();

        $fs->copy(
                Argument::type('string'),
                $file,
                true
            )
            ->willReturn(null)
            ->shouldBeCalled();

        $command = $this->prophesize(GhostscriptConverterCommand::class);
        $command->run(
                $file,
                Argument::type('string'),
                $newVersion,
                Argument::type('null')
            )
            ->willReturn(null)
            ->shouldBeCalled();

        $converter = new GhostscriptConverter(
            $command->reveal(),
            $fs->reveal(),
            $this->tmp
        );

        $converter->convert($file, $newVersion);
    }

    /**
     * @return array
     */
    public static function filesProvider(): array
    {
        return array(
            // file, new version
            array(__DIR__ . '/../files/repo/v1.1.pdf', '1.4'),
            array(__DIR__ . '/../files/repo/v1.2.pdf', '1.4'),
            array(__DIR__ . '/../files/repo/v1.3.pdf', '1.4'),
            array(__DIR__ . '/../files/repo/v1.4.pdf', '1.4'),
            array(__DIR__ . '/../files/repo/v1.5.pdf', '1.4'),
            array(__DIR__ . '/../files/repo/v1.6.pdf', '1.4'),
            array(__DIR__ . '/../files/repo/v1.7.pdf', '1.4'),
            array(__DIR__ . '/../files/repo/v2.0.pdf', '1.4'),
        );
    }
}
