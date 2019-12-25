<?php

namespace Drupal\extlink_popup;

use Drupal\Core\Form\FormStateInterface;

/**
 * Provides interface for external links popup service.
 */
interface ExtlinkPopupServiceInterface {

  /**
   * Alter external links settings form.
   *
   * @param array $form
   *   Form array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state object.
   */
  public function extlinkSettingsFormAlter(array &$form, FormStateInterface $form_state);

  /**
   * Additional submit callback for external links settings form.
   *
   * @param array $form
   *   Form array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state object.
   */
  public function extlinkSettingsFormSubmit(array $form, FormStateInterface $form_state);

  /**
   * Provide additional page attachments for the page.
   *
   * @param array $attachments
   *   Attachments array.
   */
  public function providePageAttachments(array &$attachments);

}
