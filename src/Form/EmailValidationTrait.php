<?php

namespace Drupal\email_nd\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Trait EmailValidationTrait.
 *
 * @package Drupal\email_nd\Form
 */
trait EmailValidationTrait {

  /**
   * Email validation function.
   *
   * @param array $element
   *   Validated form element.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state object.
   * @param array $form
   *   Form array.
   */
  public function validateEmail(array &$element, FormStateInterface $form_state, array $form) {
    /** @var \Egulias\EmailValidator\EmailValidator $validator */
    $validator = \Drupal::service('email.validator');
    $arrays_email = preg_split("/\,|\r\n|\n/", $element['#value']);
    if (!empty($arrays_email) && count($arrays_email) == count(array_unique($arrays_email, SORT_STRING))) {
      if (count($arrays_email) < 10) {
        foreach ($arrays_email as $email) {
          $email_isset = trim($email);
          if (!empty($email_isset)) {
            if ($email_isset != $email) {
              $form_state->setError($element, $this->t('Remove spaces.'));
            }
            elseif (!$validator->isValid($email)) {
              $form_state->setError($element, $this->t('Please enter a valid email address.'));
            }
          }
          else {
            $form_state->setError($element, $this->t('Remove the empty string.'));
          }
        }
      }
      else {
        $form_state->setError($element, $this->t('Maximum 10 email addresses to send.'));
      }
    }
    else {
      $form_state->setError($element, $this->t('Remove duplicates.'));
    }
  }

}
