<?php

namespace Zazama\Videocal;

use SilverStripe\Model\ArrayData;
use SilverStripe\Model\List\ArrayList;

class LocalVideoShortcodeParser {
    public static function LocalVideoParser($arguments, $content, $parser, $tagName) {
        $localVideoId = $arguments['videoid'];
        if(!$localVideoId) {
            return '';
        }

        $localVideo = LocalVideo::get_by_id(LocalVideo::class, $localVideoId);
        if(!$localVideo) {
            return '';
        }

        return ArrayData::create([
            'Video' => $localVideo->Video(),
            'Thumbnail' => $localVideo->Thumbnail(),
            'Arguments' => new ArrayList(array_map(static fn($key, $value) => new ArrayData([
                'Key' => $key,
                'Value' => $value
            ]), array_keys($arguments), $arguments))
        ])->renderWith('LocalVideoEmbed');
    }
}
