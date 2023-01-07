<?php

/**
 * @file
 * Contains Drupal\sbstory\Form\SiteLocationSettings.
 */

namespace Drupal\sbstory\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SiteLocationSettings.
 *
 * @package Drupal\xai\Form
 */
class SiteLocationSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'sbstory.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'site_location_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('sbstory.settings');

    $timezones = [
      'America/Chicago' => 'America/Chicago',
      'America/New_York' => 'America/New_York',
      'Asia/Tokyo' => 'Asia/Tokyo',
      'Asia/Dubai' => 'Asia/Dubai',
      'Asia/Kolkata' => 'Asia/Kolkata',
      'Europe/Amsterdam' => 'Europe/Amsterdam',
      'Europe/Oslo' => 'Europe/Oslo',
      'Europe/London' => 'Europe/London'
    ];

    $form['sbstory_country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => $config->get('sbstory_country'),
      '#description' => $this->t('Enter the name of the country'),
    ];

    $form['sbstory_city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => $config->get('sbstory_city'),
      '#description' => $this->t('Enter the name of the city'),
    ];

    $form['sbstory_timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Timezone'),
      '#options' => $timezones,
      '#description' => $this->t('Please select your timezone'),
      '#default_value' => $config->get('sbstory_timezone'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('sbstory.settings')
      ->set('sbstory_country', $form_state->getValue('sbstory_country'))
      ->set('sbstory_city', $form_state->getValue('sbstory_city'))
      ->set('sbstory_timezone', $form_state->getValue('sbstory_timezone'))
      ->save();
  }

}