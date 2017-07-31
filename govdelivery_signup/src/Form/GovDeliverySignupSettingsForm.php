<?php

/**
 * @file
 * Contains \Drupal\saml_sp\Form\GovDeliverySignupSettingsForm.
 */

namespace Drupal\govdelivery_signup\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\Url;
use Drupal\Core\Link;

class GovDeliverySignupSettingsForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'govdelivery_signup_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('govdelivery_signup.settings');
    $values = $form_state->getValues()['govdelivery_signup'];
    foreach ($values AS $key => $value) {
      $config->set($key, $value);
    }
    dpm($values);

    $config->save();

    if (method_exists($this, '_submitForm')) {
      $this->_submitForm($form, $form_state);
    }

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    /*
    $values = $form_state->getValues();
    */
  }

  /**
   * recursively go through the set values to set the configuration
   */
  protected function configRecurse($config, $values, $base = '') {
    foreach ($values AS $var => $value) {
      if (!empty($base)) {
        $v = $base . '.' . $var;
      }
      else {
        $v = $var;
      }
      if (!is_array($value)) {
        $config->set($v, $value);
      }
      else {
        $this->configRecurse($config, $value, $v);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['govdelivery_signup.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form = [], FormStateInterface $form_state) {
    $config = $this->config('govdelivery_signup.settings');
    $form['govdelivery_signup'] = array(
      '#tree' => TRUE,
    );
    $form['govdelivery_signup']['fieldset_desc'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Signup Box Label'),
      '#default_value' => $config->get('fieldset_desc'),
      '#maxlength' => 25,
      '#required' => FALSE,
    );
    $form['govdelivery_signup']['button_label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Button Label'),
      '#default_value' => $config->get('button_label'),
      '#maxlength' => 25,
      '#required' => TRUE,
    );
    $form['govdelivery_signup']['description'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Enter a Description'),
      '#default_value' => $config->get('description'),
      '#maxlength' => 100,
      '#required' => FALSE,
    );
    $form['govdelivery_signup']['email_label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('E-mail Address Box Label'),
      '#default_value' => $config->get('email_label'),
      '#maxlength' => 100,
      '#required' => TRUE,
    );
    $form['govdelivery_signup']['email_desc'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('E-mail field description'),
      '#default_value' => $config->get('email_desc'),
      '#maxlength' => 100,
      '#required' => FALSE,
    );
    $form['govdelivery_signup']['email_placeholder'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('E-mail field placeholder'),
      '#description' => $this->t('Placeholder that is in the e-mail field until the user starts typing.'),
      '#default_value' => $config->get('email_placeholder'),
      '#maxlength' => 100,
      '#required' => FALSE,
    );
    $form['govdelivery_signup']['client_code'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('GovDelivery DCM Client Account Code'),
      '#default_value' => $config->get('client_code'),
      '#maxlength' => 20,
      '#required' => TRUE,
    );
    $form['govdelivery_signup']['server'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('GovDelivery DCM URL (Include HTTPS://)'),
      '#default_value' => $config->get('server'),
      '#maxlength' => 100,
      '#required' => TRUE,
    );

    return parent::buildForm($form, $form_state);
  }
}
