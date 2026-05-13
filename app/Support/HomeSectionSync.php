<?php

namespace App\Support;

use App\Models\{PageBlock, PageSection};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class HomeSectionSync
{
    public static function ensureFromBlocks(): void
    {
        $blocks = PageBlock::homepage()->get();
        if ($blocks->isEmpty()) {
            return;
        }

        if (! PageSection::forPage('home')->exists()) {
            foreach ($blocks as $index => $block) {
                PageSection::create(self::blockToSectionData($block, $index));
            }
            Cache::forget('sections_home');
            return;
        }

        $changed = false;
        $sections = PageSection::forPage('home')->orderBy('order')->get();
        foreach ($sections as $section) {
            if (filled($section->items)) {
                continue;
            }

            $block = self::matchBlock($section, $blocks);
            if (! $block) {
                continue;
            }

            $data = self::blockToSectionData($block, (int) $section->order);
            unset($data['page_key'], $data['layout'], $data['order'], $data['is_published']);

            $section->update(array_filter($data, fn ($value) => $value !== null && $value !== []));
            $changed = true;
        }

        if ($changed) {
            Cache::forget('sections_home');
        }
    }

    protected static function matchBlock(PageSection $section, Collection $blocks): ?PageBlock
    {
        $source = data_get($section->settings, 'source_block_type');
        if ($source) {
            return $blocks->firstWhere('type', $source);
        }

        return match ($section->layout) {
            'stats' => $blocks->firstWhere('type', 'stats'),
            'program-cards' => $blocks->firstWhere('type', 'programs'),
            'timeline' => $blocks->firstWhere('type', 'legacy'),
            'cta' => $blocks->firstWhere('type', 'cta_banner'),
            'image-right', 'image-left' => str_contains(strtolower((string) $section->title), 'value')
                ? $blocks->firstWhere('type', 'values')
                : $blocks->firstWhere('type', 'about_intro'),
            'cards' => str_contains(strtolower((string) $section->title), 'touch')
                ? $blocks->firstWhere('type', 'contact_strip')
                : $blocks->firstWhere('type', 'values'),
            default => null,
        };
    }

    public static function blockToSectionData(PageBlock $block, int $order): array
    {
        $extra = $block->extra ?? [];
        $layout = match ($block->type) {
            'stats' => 'stats',
            'programs' => 'program-cards',
            'values', 'contact_strip' => 'cards',
            'legacy' => 'timeline',
            'cta_banner' => 'cta',
            'about_intro' => 'image-right',
            default => 'default',
        };

        $items = match ($block->type) {
            'stats' => [
                ['value' => data_get($extra, 'students', '500+'), 'label' => 'Students'],
                ['value' => data_get($extra, 'teachers', '40+'), 'label' => 'Teachers'],
                ['value' => data_get($extra, 'years', '26+'), 'label' => 'Years'],
                ['value' => data_get($extra, 'programmes', '4'), 'label' => 'Programs'],
            ],
            'programs' => data_get($extra, 'cards', []),
            'values' => data_get($extra, 'items', []),
            'legacy' => [['title' => 'Milestones', 'items' => data_get($extra, 'timeline', [])]],
            'contact_strip' => data_get($extra, 'cards', []),
            'cta_banner' => array_values(array_filter([
                ['label' => $block->button_text ?: 'Apply Now', 'url' => $block->button_url ?: '/admissions'],
                data_get($extra, 'secondary_button_text') ? [
                    'label' => data_get($extra, 'secondary_button_text'),
                    'url' => data_get($extra, 'secondary_button_url', '/contact'),
                    'style' => 'ghost',
                ] : null,
            ])),
            default => [],
        };

        $settings = array_filter([
            'background' => data_get($extra, 'background'),
            'accent' => data_get($extra, 'accent'),
            'section_label' => data_get($extra, 'section_label'),
            'button_bg' => data_get($extra, 'button_bg'),
            'button_text_color' => data_get($extra, 'button_text_color'),
            'source_block_type' => $block->type,
        ], fn ($value) => $value !== null && $value !== '');

        return [
            'page_key' => 'home',
            'layout' => $layout,
            'title' => $block->title,
            'subtitle' => $block->subtitle,
            'content' => $block->content,
            'image' => $block->image_path,
            'button_text' => $block->button_text,
            'button_url' => $block->button_url,
            'items' => $items ?: null,
            'settings' => $settings ?: null,
            'order' => $order,
            'is_published' => (bool) $block->is_visible,
        ];
    }
}
