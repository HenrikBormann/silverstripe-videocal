<?php

namespace Zazama\Videocal;

use Override;
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\LiteralField;

class LocalVideo extends DataObject {

    /**
     * @config
     */
    private static $table_name = 'LocalVideo';

    /**
     * @config
     */
    private static $has_one = [
        'Video' => File::class,
        'Thumbnail' => Image::class
    ];

    /**
     * @config
     */
    private static $owns = [
        'Video',
        'Thumbnail'
    ];

    /**
     * @config
     */
    private static $casting = [
        'VideoName' => 'Varchar'
    ];

    /**
     * @config
     */
    private static $summary_fields = [
        'ID' => 'ID',
        'VideoName' => 'Video'
    ];

    #[Override]
    public function getCMSFields() {
        $fields = FieldList::create(
            UploadField::create(
                'Video',
                'Video'
            )
                ->setFolderName('LocalVideos')
                ->setAllowedFileCategories('video'),
            UploadField::create(
                'Thumbnail',
                'Thumbnail'
            )
                ->setFolderName('LocalVideos/Thumbnails')
                ->setAllowedFileCategories('image')
        );

        if($this->isInDB()) {
            $fields->add(LiteralField::create(
                'Shortcode',
                'Shortcode: ' . $this->getShortcode()
            ));
        }

        return $fields;
    }

    public function getVideoName() {
        if($this->VideoID) {
            return $this->Video()->Title;
        }

        return '-';
    }

    public function getShortcode() {
        return '[localvideo videoid="' . $this->ID . '" /]';
    }
}
