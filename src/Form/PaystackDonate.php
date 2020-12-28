<?php


namespace Drupal\paystack_donate\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\State;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PaystackDonate extends FormBase {

  /**
   * @var \Drupal\Core\State\State $state
   */
  protected $state;

  /**
   * Class constructor.
   *
   * @param \Drupal\Core\State\State $state
   */
  public function __construct(State $state) {
    $this->state = $state;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    return new static(
    // Load the service required to construct this class.
      $container->get('state')
    );
  }

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

    $config = $this->config('paystack_donate.settings');
    $form['#attached']['library'][] = 'paystack_donate/paystack_donate';

    // Provide a text field.
    $form['paystack_donate_email'] = [
      '#title' => $this->t('Email'),
      '#type' => 'textfield',
      '#required' => TRUE,
      '#attributes' => [
        'id' => 'paystack_donate_email',
      ],
    ];

    $form['paystack_donate_amount'] = [
      '#title' => $this->t('Amount'),
      '#type' => 'textfield',
      '#required' => TRUE,
      '#default_value' => $this->state->get('paystack_donate_default_amount') ?? $config->get('paystack_donate_default_amount'),
      '#attributes' => ['id' => 'paystack_donate_amount'],
    ];

    $form['paystack_donate_currency'] = [
      '#title' => $this->t('Currency'),
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
      '#value' => $config->get('paystack_donate_submit_button_value') ?? $this->t('Donate'),
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
