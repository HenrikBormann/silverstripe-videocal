<?php

namespace Zazama\Videocal;

use Override;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use Zazama\Videocal\LocalVideo;

class LocalVideoModelAdmin extends ModelAdmin
{
    /**
     * @config
     */
    private static $managed_models = [
        LocalVideo::class
    ];

    /**
     * @config
     */
    private static $url_segment = 'videos';

    /**
     * @config
     */
    private static $menu_title = 'Videos';

    #[Override]
    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        // This check is simply to ensure you are on the managed model you want adjust accordingly
        if ($this->modelClass === LocalVideo::class) {
            $gridField = $form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass));

            // This is just a precaution to ensure we got a GridField from dataFieldByName() which you should have
            if ($gridField instanceof GridField) {
                $gridFieldDataColumns = $gridField->getConfig()->getComponentByType(GridFieldDataColumns::class);

                $gridFieldDataColumns->setFieldFormatting(array_merge($gridFieldDataColumns->getFieldFormatting(), [
                    "Shortcode" => fn($value, $item) => '<span>' . $item->getShortcode() . '</span> <a href="#' . $item->ID . '" class="btn btn-sm btn-outline-secondary action" data-shortcode=\'' . $item->getShortcode() . '\' onclick="navigator.clipboard.writeText(this.dataset.shortcode); return false;">' . _t('Zazama\\Videocal\\COPY_SHORTCODE', 'Copy Shortcode') . '</a>'
                ]));

                $gridFieldDataColumns->setDisplayFields(array_merge($gridFieldDataColumns->getDisplayFields($gridField), [
                    "Shortcode" => "Shortcode"
                ]));
            }
        }

        return $form;
    }
}
