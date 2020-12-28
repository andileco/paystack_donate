<?php


namespace Drupal\paystack_donate\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class PaystackDonateSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'paystack_donate.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'paystack_donate_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('paystack_donate.settings');

    $form['paystack_donate_public_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Paystack Public Key'),
      '#default_value' => $config->get('paystack_donate_public_key') ?? '',
      '#description' => $this->t('Your pubic Key from Paystack. Use test key for test mode and live key for live mode'),
      '#required' => TRUE,
    ];

    $form['paystack_donate_default_amount'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Default Amount'),
      '#default_value' => $config->get('paystack_donate_default_amount') ?? 1000,
      '#description' => $this->t('Default Amount in the Amount Field. Defaults to 1000 Naira'),
    ];

    $form['paystack_donate_success_message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Success Message'),
      '#default_value' => $config->get('paystack_donate_success_message') ?? $this->t('Thank you for your donation.'),
      '#description' => $this->t('Success Message to show in a popup. Leave empty to show the default "Thank you for your donation"'),
    ];

    $form['paystack_donate_submit_button_value'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Submit Button Text'),
      '#default_value' => $config->get('paystack_donate_submit_button_value') ?? $this->t('Donate'),
      '#description' => $this->t('Submit button text. Defaults to "donate".'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('paystack_donate.settings')
      ->set('paystack_donate_public_key', $form_state->getValue('paystack_donate_public_key'))
      ->set('paystack_donate_default_amount', $form_state->getValue('paystack_donate_default_amount'))
      ->set('paystack_donate_success_message', $form_state->getValue('paystack_donate_success_message'))
      ->set('paystack_donate_submit_button_value', $form_state->getValue('paystack_donate_submit_button_value'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
