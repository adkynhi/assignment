<?php
/**
* @author    Roland Soos
* @copyright (C) 2015 Nextendweb.com
* @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access');
?><?php
/**
 * @var $this   N2View
 * @var $_class N2SmartsliderBackendSlidersView
 */

$this->widget->init('topbar', array());
?>
    <div class="n2-ss-dashboard">
        <div class="n2-box n2-box-border n2-box-huge n2-ss-create-slider">
            <img src="<?php echo N2ImageHelper::fixed('$ss$/admin/images/create-slider.png') ?>">

            <div class="n2-box-placeholder">
                <table>
                    <tbody>
                    <tr>
                        <td class="n2-box-button">
                            <div class="n2-h2"><?php n2_e('It\'s a great day to start something new.'); ?></div>

                            <div
                                class="n2-h3"><?php n2_e('Click on the \'Create Slider\' button to get started.'); ?></div>
                            <a href="#"
                               class="n2-button n2-button-x-big n2-button-green n2-uc n2-h3 n2-ss-create-slider"><?php n2_e('Create slider'); ?></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php

        function n2GetBox($class, $image, $html, $hasBorder = true) {
            echo N2Html::tag('div', array(
                'class' => 'n2-box n2-box-title ' . $class . ($hasBorder ? ' n2-box-border' : '')
            ), N2Html::image(N2ImageHelper::fixed('$ss$/admin/images/' . $image)) . N2Html::tag("div", array(
                    'class' => 'n2-box-placeholder'
                ), N2Html::tag("table", array(), N2Html::tag("tr", array(), N2Html::tag("td", array(
                    'class' => 'n2-box-button'
                ), $html)))));
        }

        n2GetBox('n2-ss-demo-slider', 'add-demo.png', '<div>' . n2_('100+ Sample slide with one click.') . '</div><a href="#" class="n2-button n2-button-small n2-button-green n2-uc n2-h5">' . n2_('add sample slider') . '</a>');

        ob_start();
        $this->widget->init("buttonmenu", array(
            "content" => N2Html::tag('div', array(
                'class' => 'n2-button-menu'
            ), N2Html::tag('div', array(
                'class' => 'n2-button-menu-inner n2-border-radius'
            ), N2Html::link(n2_('Import by upload'), $this->appType->router->createUrl(array('sliders/importbyupload')), array(
                    'class' => 'n2-h4'
                )) . N2Html::link(n2_('Restore by upload'), $this->appType->router->createUrl(array('sliders/restorebyupload')), array(
                    'class' => 'n2-h4'
                )) . N2Html::link(n2_('Import from server'), $this->appType->router->createUrl(array('sliders/importfromserver')), array(
                    'class' => 'n2-h4'
                )) . N2Html::link(n2_('Restore from server'), $this->appType->router->createUrl(array('sliders/restorefromserver')), array(
                    'class' => 'n2-h4'
                )) . N2Html::link(n2_('Export all slider'), $this->appType->router->createUrl(array('sliders/exportall')), array(
                    'class'  => 'n2-h4',
                    'target' => '_blank'
                ))))
        ));

        n2GetBox('', 'import-upload.png', '<div>' . n2_('Import slider from different sources.') . '</div>' . N2Html::tag('div', array('class' => 'n2-button n2-button-with-menu n2-button-small n2-button-green'), N2Html::link(n2_('Import by upload'), $this->appType->router->createUrl(array('sliders/importbyupload')), array(
                    'class' => 'n2-button-inner n2-uc n2-h5'
                )) . ob_get_clean()));

        n2GetBox('n2-box-wide n2-box-overflow n2-box-free', 'free/box2.png', N2Html::tag('div', array(), 'Take your slider to the next level with Smart Slider 3 PRO!') . N2Html::link('See all features', N2SS3::getWhyProUrl(), array(
                'target' => '_blank',
                'class'  => 'n2-button n2-button-blue n2-button-medium n2-h5 n2-uc'
            )), false);
    
        $updateModel = N2SmartsliderUpdateModel::getInstance();
        $hasUpdate   = $updateModel->hasUpdate();
        $this->appType->router->setMultiSite();
        $updateUrl = $this->appType->router->createUrl(array(
            'update/update',
            N2Form::tokenizeUrl() + array('download' => 1)
        ));
        $this->appType->router->unSetMultiSite();

        $versionsTXT = '<div>' . sprintf(n2_('Installed version: %s'), N2SS3::$version . (N2SSPRO ? ' Pro' : '')) . ($hasUpdate ? '<br/>' . sprintf(n2_('Latest version: %s'), $updateModel->getVersion() . (N2SSPRO ? ' Pro' : '')) : '<br/>' . sprintf(n2_('Last check: %s'), $updateModel->lastCheck())) . '</div>';

        n2GetBox('', 'Update.png', $versionsTXT . ($hasUpdate ? '<a href="' . $updateUrl . '" class="n2-button n2-button-small n2-button-blue n2-uc n2-h5">' . n2_('Update') . '</a>' : '') . (!$hasUpdate ? '<a href="' . $this->appType->router->createUrl(array(
                    'update/check',
                    N2Form::tokenizeUrl()
                )) . '" class="n2-button n2-button-small n2-button-blue n2-uc n2-h5">' . n2_('Check') . '</a>' : '') . '<a href="#" onclick="NextendModalDocumentation(\'' . n2_('Changelog') . '\', \'http://doc.smartslider3.com/article/432-changelog\');return false;" class="n2-button n2-button-small n2-button-grey n2-uc n2-h5">' . n2_('Changelog') . '</a>');
        if ($hasUpdate) {
            ?>
            <script type="text/javascript">
                n2(window).ready(function ($) {
                    $('.n2-main-top-bar').append('<div class="n2-left n2-top-bar-menu"><span><?php printf(n2_('Version %s available!'), $updateModel->getVersion()); ?></span> <a style="font-size: 12px;margin-right: 10px;" class="n2-h3 n2-uc n2-has-underline n2-button n2-button-blue n2-button-medium" href="<?php echo $updateUrl; ?>"><?php n2_e('Update'); ?></a> <a style="font-size: 12px;" class="n2-h3 n2-uc n2-has-underline n2-button n2-button-grey n2-button-medium" href="#" onclick="NextendModalDocumentation(\'<?php n2_e('Changelog'); ?>\', \'http://doc.smartslider3.com/article/432-changelog\');return false;"><?php n2_e('Changelog'); ?></a></div>');
                });
            </script>
        <?php
        }

        n2GetBox('', 'Documentation.png', N2Html::tag('div', array(), n2_('Interactive online documentation.')) . N2Html::link(n2_('Read'), 'http://doc.smartslider3.com', array(
                'target' => '_blank',
                'class'  => 'n2-button n2-button-grey n2-button-small n2-h5 n2-uc'
            )));
        n2GetBox('', 'Videos.png', N2Html::tag('div', array(), n2_('Helpful tutorial videos.')) . N2Html::link(n2_('Watch'), 'https://www.youtube.com/watch?v=MKmIwHAFjSU&list=PLSawiBnEUNfvzcI3pBHs4iKcbtMCQU0dB', array(
                'target' => '_blank',
                'class'  => 'n2-button n2-button-grey n2-button-small n2-h5 n2-uc'
            )));
        n2GetBox('', 'Help.png', N2Html::tag('div', array(), n2_('First class support with real people.')) . N2Html::link(n2_('Write'), 'http://smartslider3.com/contact-us/', array(
                'target' => '_blank',
                'class'  => 'n2-button n2-button-grey n2-button-small n2-h5 n2-uc'
            )));
        n2GetBox('', 'Newsletter.png', N2Html::tag('div', array(), n2_('Receive the latest news.')) . N2Html::link(n2_('Subscribe'), 'http://eepurl.com/bDp_8b', array(
                'target' => '_blank',
                'class'  => 'n2-button n2-button-grey n2-button-small n2-h5 n2-uc'
            )));

        n2GetBox('', 'Facebook.png', N2Html::tag('div', array(), n2_('Join the community on Facebook.')) . N2Html::link(n2_('Join'), 'https://www.facebook.com/nextendweb', array(
                'class'  => 'n2-button n2-button-grey n2-button-small n2-h5 n2-uc',
                'target' => '_blank'
            )));
        n2GetBox('', 'Love.png', N2Html::tag('div', array(), n2_('Are you satisfied with Smart Slider 3?')) . N2Html::link(n2_('Yes'), 'http://smartslider3.com/satisfied-customer/', array(
                'target' => '_blank',
                'class'  => 'n2-button n2-button-green n2-button-small n2-h5 n2-uc'
            )) . N2Html::link(n2_('No'), 'http://smartslider3.com/suggestion/', array(
                'target' => '_blank',
                'class'  => 'n2-button n2-button-red n2-button-small n2-h5 n2-uc'
            )));
        n2GetBox('n2-box-add-license', 'AddLicense.png', '<div>' . n2_('You got the PRO license key?') . '</div><a href="http://doc.smartslider3.com/article/484-updating-the-free-version-to-the-full" target="_blank" class="n2-button n2-button-small n2-button-blue n2-uc n2-h5">' . n2_('Install PRO version') . '</a>');
    

        ?>

        <div class="n2-clear"></div>
    </div>

<?php
if (intval(N2SmartSliderSettings::get('discover', 1)) == 1):
    N2SmartSliderSettings::set('discover', 0);
    ?>

    <script type="text/javascript">
        n2(window).ready(function () {
            new NextendModal({
                zero: {
                    size: [
                        913,
                        710
                    ],
                    title: n2_('Discover Smart Slider 3'),
                    back: false,
                    close: true,
                    content: '<iframe style="margin:20px 10px 0;" width="854" height="480" src="https://www.youtube.com/embed/fjmENHah_oY?autoplay=1" frameborder="0" allowfullscreen></iframe>',
                    controls: ['<a href="#" class="n2-button n2-button-big n2-button-green n2-uc n2-h4">' + n2_('Close') + '</a>'],
                    fn: {
                        show: function () {
                            this.createHeading(n2_("We've created a simple tutorial video to guide you through the basic steps of making your first slider. Good luck with the sliders!")).css({
                                width: '520px',
                                textAlign: 'center',
                                margin: '15px auto',
                                lineHeight: '24px'
                            }).appendTo(this.content);
                            this.controls.find('.n2-button-green')
                                .on('click', n2.proxy(function (e) {
                                    e.preventDefault();
                                    this.hide(e);
                                }, this));
                        }
                    }
                }
            }, true);

        });
    </script>

<?php
endif;
?>
<?php N2SS3::showBeacon('Main page, Import, Update'); ?>