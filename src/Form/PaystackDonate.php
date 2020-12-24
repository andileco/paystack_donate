<?php


namespace Drupal\paystack_donate\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class PaystackDonate extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'paystack_donate_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = \Drupal::config('paystack_donate.settings');
    $form['#attached']['library'][] = 'paystack_donate/paystack_donate';

    // Provide a text field.
    $form['paystack_donate_email'] = [
      '#title' => t('Email'),
      '#type' => 'textfield',
      '#required' => TRUE,
      '#attributes' => [
        'id' => 'paystack_donate_email',
      ],
    ];

    $form['paystack_donate_amount'] = [
      '#title' => t('Amount'),
      '#type' => 'textfield',
      '#required' => TRUE,
      '#default_value' => \Drupal::state()->get('paystack_donate_default_amount') ?? 1000,
      '#attributes' => ['id' => 'paystack_donate_amount'],
    ];

    $form['paystack_donate_currency'] = [
      '#title' => t('Currency'),
      '#type' => 'select',
      '#required' => TRUE,
      '#options' => [
        0 => t('NGN'),
      ],
      '#default_value' => 0,
      '#attributes' => [
        'id' => 'paystack_donate_currency',
      ],
    ];

    // Provide a submit button.
    $form['paystack_donate_buton'] = [
      '#type' => 'button',
      '#value' => \Drupal::state()->get('paystack_donate_submit_button_value') ?? 'Donate',
      '#attributes' => [
        'id' => 'paystack_donate_form_button',
      ],
    ];

    $form['#attached']['drupalSettings']['paystack_key'] = $config->get('paystack_donate_public_key');
    $form['#attached']['drupalSettings']['success_message'] = $config->get('paystack_donate_success_message') ?? 'Thank you for your donation.';

    $form['#attributes'] = [
      'onsubmit' => 'return false',
      'class' => 'donate-form',
    ];


    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
  }

}
