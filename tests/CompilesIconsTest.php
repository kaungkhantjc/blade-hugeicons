<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\BladeIconsServiceProvider;
use KaungKhantKyaw\HugeIcons\BladeHugeIconsServiceProvider;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CompilesIconsTest extends TestCase
{
    #[Test]
    public function it_compiles_a_single_anonymous_component()
    {
        $result = svg('hugeicon-play')->toHtml();

        // Keep the SVG content flush to the left to match the generator's output
        $expected = <<<'SVG'
            <svg stroke-width="1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M18.8906 12.846C18.5371 14.189 16.8667 15.138 13.5257 17.0361C10.296 18.8709 8.6812 19.7884 7.37983 19.4196C6.8418 19.2671 6.35159 18.9776 5.95624 18.5787C5 17.6139 5 15.7426 5 12C5 8.2574 5 6.3861 5.95624 5.42132C6.35159 5.02245 6.8418 4.73288 7.37983 4.58042C8.6812 4.21165 10.296 5.12907 13.5257 6.96393C16.8667 8.86197 18.5371 9.811 18.8906 11.154C19.0365 11.7084 19.0365 12.2916 18.8906 12.846Z" stroke="currentColor" stroke-linejoin="round"/></svg>
            SVG;
        $this->assertXmlStringEqualsXmlString($expected, $result);
    }

    #[Test]
    public function it_can_add_classes_to_icons()
    {
        $result = svg('hugeicon-play', 'w-6 h-6 text-gray-500')->toHtml();

        $expected = <<<'SVG'
            <svg stroke-width="1.5" class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M18.8906 12.846C18.5371 14.189 16.8667 15.138 13.5257 17.0361C10.296 18.8709 8.6812 19.7884 7.37983 19.4196C6.8418 19.2671 6.35159 18.9776 5.95624 18.5787C5 17.6139 5 15.7426 5 12C5 8.2574 5 6.3861 5.95624 5.42132C6.35159 5.02245 6.8418 4.73288 7.37983 4.58042C8.6812 4.21165 10.296 5.12907 13.5257 6.96393C16.8667 8.86197 18.5371 9.811 18.8906 11.154C19.0365 11.7084 19.0365 12.2916 18.8906 12.846Z" stroke="currentColor" stroke-linejoin="round"/></svg>
            SVG;

        $this->assertXmlStringEqualsXmlString($expected, $result);
    }

    #[Test]
    public function it_can_add_styles_to_icons()
    {
        $result = svg('hugeicon-play', ['style' => 'color: #555'])->toHtml();

        $expected = <<<'SVG'
            <svg style="color: #555" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M18.8906 12.846C18.5371 14.189 16.8667 15.138 13.5257 17.0361C10.296 18.8709 8.6812 19.7884 7.37983 19.4196C6.8418 19.2671 6.35159 18.9776 5.95624 18.5787C5 17.6139 5 15.7426 5 12C5 8.2574 5 6.3861 5.95624 5.42132C6.35159 5.02245 6.8418 4.73288 7.37983 4.58042C8.6812 4.21165 10.296 5.12907 13.5257 6.96393C16.8667 8.86197 18.5371 9.811 18.8906 11.154C19.0365 11.7084 19.0365 12.2916 18.8906 12.846Z" stroke="currentColor" stroke-linejoin="round"/></svg>
            SVG;

        $this->assertXmlStringEqualsXmlString($expected, $result);
    }

    #[Test]
    public function it_can_change_stroke_width_to_icons()
    {
        $result = svg('hugeicon-play', attributes: ['stroke-width' => '2'])->toHtml();

        $expected = <<<'SVG'
            <svg stroke-width="2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M18.8906 12.846C18.5371 14.189 16.8667 15.138 13.5257 17.0361C10.296 18.8709 8.6812 19.7884 7.37983 19.4196C6.8418 19.2671 6.35159 18.9776 5.95624 18.5787C5 17.6139 5 15.7426 5 12C5 8.2574 5 6.3861 5.95624 5.42132C6.35159 5.02245 6.8418 4.73288 7.37983 4.58042C8.6812 4.21165 10.296 5.12907 13.5257 6.96393C16.8667 8.86197 18.5371 9.811 18.8906 11.154C19.0365 11.7084 19.0365 12.2916 18.8906 12.846Z" stroke="currentColor" stroke-linejoin="round"/></svg>
            SVG;

        $this->assertXmlStringEqualsXmlString($expected, $result);
    }

    protected function getPackageProviders($app): array
    {
        return [
            BladeIconsServiceProvider::class,
            BladeHugeIconsServiceProvider::class,
        ];
    }
}
