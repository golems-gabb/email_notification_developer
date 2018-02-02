<?php

namespace Drupal\email_nd\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Trait PeriodValidationTrait.
 *
 * @package Drupal\email_nd\Form
 */
trait PeriodValidationTrait {

  /**
   * Function validation period over which operated functional module.
   *
   * @param array $element
   *   Validated form element.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state object.
   * @param array $form
   *   Form array.
   */
  public function validatePeriod(array &$element, FormStateInterface $form_state, array $form) {
    if (empty($element['#value']) || !preg_match('/^\d+$/i', $element['#value']) || $element['#value'] * 60 > 2592000) {
      if (empty($element['#value'])) {
        $form_state->setError($element, $this->t('Empty value period.'));
      }
      elseif ($element['#value'] * 60 > 2592000) {
        $form_state->setError($element, $this->t('Introduced during 30 days.'));
      }
      else {
        $form_state->setError($element, $this->t('The value of the field can only be a positive numeric field.'));
      }
    }
  }

}
