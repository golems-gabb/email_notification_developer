<?php

namespace Drupal\email_nd\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class SettingsForm.
 *
 * @package Drupal\email_nd\Form
 */
class ErrorSettingsForm extends ConfigFormBase {

  use EmailValidationTrait;
  use DomainValidationTrait;
  use PeriodValidationTrait;

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['email_nd.setting'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'email_nd.setting';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->configFactory()->getEditable('email_nd.setting');
    $form = parent::buildForm($form, $form_state);
    $url_cron = Url::fromRoute('system.cron_settings')->getInternalPath();
    $form['activate_error'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Activate functionality'),
      '#return_value' => 1,
      '#default_value' => $config->get('activate_error'),
      '#description' => $this->t('Activate message to Email functionality of PHP errors on the site.'),
    ];
    $form['period_emails'] = [
      '#type' => 'number',
      '#min' => 1,
      '#max' => 24 * 30,
      '#title' => $this->t('The period of inspection'),
      '#required' => TRUE,
      '#default_value' => $config->get('period_emails'),
      '#element_validate' => [[$this, 'validatePeriod']],
      '#description' => $this->t('Period (given in hours) at which will trigger functionality. This period will be available <a target= "_blank" href="@url" >Cron</a> period shown in the format hours, days, weeks (ie 10 days - 1 week 3 days). Numerical maximum period of 30 days.', ['@url' => $url_cron]),
    ];
    $emails = (array) $config->get('emails_list_error');
    $emails = empty($emails) ? '' : implode("\n", $emails);
    $form['emails_list_error'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Emails list'),
      '#required' => TRUE,
      '#default_value' => $emails,
      '#element_validate' => [[$this, 'validateEmail']],
      '#description' => $this->t('Enter up to ten email addresses Enter through the separator or comma, without blank lines.'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory()
      ->getEditable('email_nd.setting')
      ->set('activate_error', (bool) $form_state->getValue('activate_error', FALSE))
      ->set('period_emails', (int) $form_state->getValue('period_emails', 1))
      ->set(
        'emails_list_error',
        (array) preg_split("/\,|\r\n|\n/", $form_state->getValue('emails_list_error', ''))
      )
      ->save();
    parent::submitForm($form, $form_state);
  }

}
