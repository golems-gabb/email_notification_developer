<?php

namespace Drupal\email_nd\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Trait DomainValidationTrait.
 *
 * @package Drupal\email_nd\Form
 */
trait DomainValidationTrait {

  /**
   * Domain validation function.
   *
   * @param array $element
   *   Validated form element.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state object.
   * @param array $form
   *   Form array.
   */
  public function validateDomain(array &$element, FormStateInterface &$form_state, array $form) {
    $arrays_domain = preg_split("/\,|\r\n|\n/", $element['#value']);
    if (!empty($arrays_domain) && count($arrays_domain) == count(array_unique($arrays_domain, SORT_STRING))) {
      $block_reg = '\.\/$%@#\*!:;?&,№\-=+\[\]\{\}\|"\'`\(\)\s';
      $reg = '/^(https*\:\/\/)*[^' . $block_reg . ']{2,20}\.([^' . $block_reg . ']{2,10}\.+)?([^' . $block_reg .
        ']{2,10})?([^' . $block_reg . ']{2,10}\.[^' . $block_reg . ']{2,10})?$/i';
      foreach ($arrays_domain as $domain) {
        $domain_isset = trim($domain);
        if (!empty($domain_isset)) {
          if ($domain_isset != $domain) {
            $form_state->setError($element, $this->t('Remove spaces.'));
          }
          elseif (!preg_match($reg, $domain)) {
            $form_state->setError($element, $this->t('Please enter a valid domain.'));
          }
        }
        else {
          $form_state->setError($element, $this->t('Remove the empty string.'));
        }
      }
    }
    else {
      $form_state->setError($element, $this->t('Remove duplicates.'));
    }
  }

}
