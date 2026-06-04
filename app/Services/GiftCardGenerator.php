<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use ArPHP\I18N\Arabic;

class GiftCardGenerator
{
    public function generate(array $data): string
    {
        $templatePath = $this->resolveImagePath($data['template_path'] ?? null);

        if (!$templatePath || !file_exists($templatePath)) {
            return $data['template_path'] ?? '';
        }

        $image = Image::make($templatePath);

        $fontPath = public_path('fonts/Cairo-Regular.ttf');

        if (!file_exists($fontPath)) {
            return $data['template_path'] ?? '';
        }

        $message = $this->buildMessage($data);

        $lines = preg_split("/\r\n|\n|\r/", trim($message));

        $lines = array_values(array_filter(array_map('trim', $lines)));

        $lineHeight = 60;
        $imageHeight = $image->height();
        $imageWidth  = $image->width();
        $x = $imageWidth / 2;

        $totalTextHeight = count($lines) * $lineHeight;
        $y = ($imageHeight / 2) - ($totalTextHeight / 2) + 120;

        foreach ($lines as $index => $line) {
            $line = $this->prepareArabicText($line);

            if ($line === '') continue;

            $image->text($line, $x, $y + ($index * $lineHeight), function ($font) use ($fontPath) {
                $font->file($fontPath);
                $font->size(40);
                $font->color('#333333');
                $font->align('center');
                $font->valign('top');
            });
        }

        $folder = storage_path('app/public/attachments/generated-gift-cards');

        if (!File::isDirectory($folder)) {
            File::makeDirectory($folder, 0775, true);
        }

        $fileName  = 'gift-card-' . time() . '-' . uniqid() . '.png';
        $relativePath = 'attachments/generated-gift-cards/' . $fileName;

        $image->save(storage_path('app/public/' . $relativePath));

        return $relativePath;
    }
    private function prepareArabicText(string $text): string
    {
        $arabic = new Arabic();

        $p = $arabic->arIdentify($text);

        for ($i = count($p) - 1; $i >= 0; $i -= 2) {
            $utf8ar = $arabic->utf8Glyphs(substr($text, $p[$i - 1], $p[$i] - $p[$i - 1]));
            $text   = substr_replace($text, $utf8ar, $p[$i - 1], $p[$i] - $p[$i - 1]);
        }

        return $text;
    }
    private function buildMessage(array $data): string
    {
        $template = $data['message_template'] ?? '';

        if (!$template) {
            $template = "إلى / [[giver_name]]\nأهديك صدقة عن مشروع [[project]]\nجعلها الله لك نورًا وأجرًا وبركة\nمن / [[from_name]]";
        }

        return str_replace(
            [
                '[[giver_name]]',
                '[[giver_group]]',
                '[[from_name]]',
                '[[project]]',
                '[[card]]',
            ],
            [
                $data['giver_name'] ?? '',
                $data['giver_group'] ?? '',
                $data['from_name'] ?? '',
                $data['project'] ?? '',
                $data['card'] ?? '',
            ],
            $template
        );
    }



    private function resolveImagePath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        $path = ltrim($path, '/');

        if (!str_starts_with($path, 'attachments/')) {
            $candidate = 'attachments/' . $path;

            $storageCandidate = storage_path('app/public/' . $candidate);
            if (file_exists($storageCandidate)) {
                return $storageCandidate;
            }

            $publicStorageCandidate = public_path('storage/' . $candidate);
            if (file_exists($publicStorageCandidate)) {
                return $publicStorageCandidate;
            }
        }

        $storagePath = storage_path('app/public/' . $path);
        if (file_exists($storagePath)) {
            return $storagePath;
        }

        $publicStoragePath = public_path('storage/' . $path);
        if (file_exists($publicStoragePath)) {
            return $publicStoragePath;
        }

        $publicPath = public_path($path);
        if (file_exists($publicPath)) {
            return $publicPath;
        }

        return null;
    }
}
