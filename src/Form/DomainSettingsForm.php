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
class DomainSettingsForm extends ConfigFormBase {

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
    $form['activate_domain'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Activate functionality'),
      '#return_value' => 1,
      '#default_value' => $config->get('activate_domain'),
      '#description' => $this->t('Activate functionality for Email notification of change of domain.'),
    ];
    $form['period_domain'] = [
      '#type' => 'number',
      '#min' => 1,
      '#max' => 24 * 30,
      '#title' => $this->t('The period of inspection'),
      '#required' => TRUE,
      '#default_value' => $config->get('period_domain'),
      '#element_validate' => [[$this, 'validatePeriod']],
      '#description' => $this->t('Period (given in hours) at which will trigger functionality. This period will be available <a target= "_blank" href="@url" >Cron</a> period shown in the format hours, days, weeks (ie 10 days - 1 week 3 days). Numerical maximum period of 30 days.', ['@url' => $url_cron]),
    ];
    $domains = (array) $config->get('list_domain');
    $domains = empty($domains) ? '' : implode("\n", $domains);
    $form['list_domain'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Domain list'),
      '#required' => TRUE,
      '#default_value' => $domains,
      '#element_validate' => [[$this, 'validateDomain']],
      '#description' => $this->t('Enter domain names through a separator comma or Enter, no spaces.'),
    ];
    $emails = (array) $config->get('emails_list_domain');
    $emails = empty($emails) ? '' : implode("\n", $emails);
    $form['emails_list_domain'] = [
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
      ->set('activate_domain', (bool) $form_state->getValue('activate_domain', FALSE))
      ->set('period_domain', $form_state->getValue('period_domain', 1))
      ->set(
        'list_domain',
        (array) preg_split("/\,|\r\n|\n/", $form_state->getValue('list_domain', ''))
      )
      ->set(
        'emails_list_domain',
        (array) preg_split("/\,|\r\n|\n/", $form_state->getValue('emails_list_domain', ''))
      )
      ->save();
    parent::submitForm($form, $form_state);
  }

}
