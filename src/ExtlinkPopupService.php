<?php

namespace Drupal\extlink_popup;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * External links popup service.
 */
class ExtlinkPopupService implements ExtlinkPopupServiceInterface {

  use StringTranslationTrait;

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The config object for 'extlink.settings'.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $extlinkSettings;

  /**
   * Constructs an ExtlinkPopupService object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
    $this->extlinkSettings = $config_factory->get('extlink.settings');
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public function extlinkSettingsFormAlter(array &$form, FormStateInterface $form_state) {
    $form['extlink_popup'] = [
      '#type' => 'checkbox',
      '#return_value' => '_popup',
      '#title' => $this->t('Display a jquery dialog pop-up warning when any external link is clicked.'),
      '#default_value' => $this->extlinkSettings->get('extlink_popup'),
      '#weight' => 0,
    ];

    $form['extlink_popup_text_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Jquery Dialog popup settings'),
    ];

    $form['extlink_popup_text_fieldset']['extlink_popup_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Popup Title'),
      '#default_value' => $this->extlinkSettings->get('extlink_popup_title'),
    ];

    $form['extlink_popup_text_fieldset']['extlink_popup_body'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Popup body'),
      '#default_value' => $this->extlinkSettings->get('extlink_popup_body'),
    ];
    $form['extlink_popup_text_fieldset']['extlink_popup_button_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Button text'),
      '#default_value' => $this->extlinkSettings->get('extlink_popup_button_text'),
    ];

    $form['#submit'][] = [$this, 'extlinkSettingsFormSubmit'];
  }

  /**
   * {@inheritdoc}
   */
  public function extlinkSettingsFormSubmit(array $form, FormStateInterface $form_state) {
    $this->configFactory->getEditable('extlink.settings')
      ->set('extlink_popup', $form_state->getValue('extlink_popup'))
      ->set('extlink_popup_title', $form_state->getValue('extlink_popup_title'))
      ->set('extlink_popup_body', $form_state->getValue('extlink_popup_body'))
      ->set('extlink_popup_button_text', $form_state->getValue('extlink_popup_button_text'))
      ->save();
  }

  /**
   * {@inheritdoc}
   */
  public function providePageAttachments(array &$attachments) {
    $attachments['#attached']['library'][] = 'extlink_popup/main';

    $attachments['#attached']['drupalSettings']['data']['extlinkPopup'] = [
      'extPopupTitle' => $this->extlinkSettings->get('extlink_popup_title'),
      'extPopupBody' => $this->extlinkSettings->get('extlink_popup_body'),
      'extPopupButtonTitle' => $this->extlinkSettings->get('extlink_popup_button_text'),
      'extPopup' => $this->extlinkSettings->get('extlink_popup'),
    ];
  }

}
