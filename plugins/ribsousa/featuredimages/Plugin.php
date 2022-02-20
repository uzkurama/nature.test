<?php namespace Ribsousa\Featuredimages;

use System\Classes\PluginBase;
use Event;

/**
 * Class Plugin
 *
 * @package Acme\BlogBanner
 */
class Plugin extends PluginBase
{
    public $require = ['RainLab.Blog'];

    /**
     * @inheritdoc
     */
    public function pluginDetails(): array
    {
        return [
            'name'        => 'Blog Banner',
            'description' => 'A RainLab.Blog extension adding banner image via Media Manager to posts.',
            'author'      => 'Acme',
            'icon'        => 'icon-file-image-o',
        ];
    }

    public function register()
    {
        Event::listen('backend.form.extendFields', function (\Backend\Widgets\Form $formWidget) {
            if (!$formWidget->getController() instanceof \RainLab\Blog\Controllers\Posts) {
                return;
            }

            if (!$formWidget->model instanceof \RainLab\Blog\Models\Post) {
                return;
            }

            $formWidget->addSecondaryTabFields([
                'metadata[banner_image]' => [
                    'tab' => 'rainlab.blog::lang.post.tab_manage',
                    'label'   => 'Banner Image',
                    'type' => 'mediafinder',
                    'mode' => 'image'
                ],
            ]);

            $formWidget->removeField('featured_images');
        });
    }
}
