<?php

namespace Drupal\par_rd_help_desk_flows\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\par_flows\Form\ParBaseForm;
use Drupal\par_data\Entity\ParDataPartnership;

/**
 * The confirming the user is authorised to approve partnerships.
 */
class ParRdHelpDeskConfirmForm extends ParBaseForm {

  /**
   * {@inheritdoc}
   */
  protected $flow = 'approve_partnership';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'par_rd_help_desk_confirm';
  }

  /**
   * Helper to get all the editable values when editing or
   * revisiting a previously edited page.
   */
  public function retrieveEditableValues() {

  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, ParDataPartnership $par_data_partnership = NULL) {
    $this->retrieveEditableValues();

    $par_data_organisation = current($par_data_partnership->getOrganisation());
    $par_data_authority = current($par_data_partnership->getAuthority());

    $form['partnership_title'] = [
      '#type' => 'markup',
      '#markup' => $this->t('Partnership between between'),
      '#prefix' => '<div><h2>',
      '#suffix' => '</h2></div>',
    ];

    $form['partnership_text'] = [
      '#type' => 'markup',
      '#markup' => $par_data_organisation->get('organisation_name')->getString() . ' '. $par_data_authority->get('authority_name')->getString(),
      '#prefix' => '<div><p>',
      '#suffix' => '</p></div>',
    ];

    $confirm_text_options[]  = $this->t('I am authorised to approve this partnership');

    $form['confirm_authorisation_select'] = [
      '#type' => 'radios',
      '#title' => $this->t('Check to confirm you are authorised to approve this partnership'),
      '#options' => $confirm_text_options,
      '#required' => TRUE,
      '#prefix' => '<div><p>',
      '#suffix' => '</p></div>',
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // No validation yet.
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $partnership = $this->getRouteParam('par_data_partnership');
    $partnership->setParStatus('confirmed_rd');

    if (!$partnership->save()) {

      $message = $this->t('This %partnership could not be approved for %form_id');
      $replacements = [
        '%partnership' => $partnership->id(),
        '%form_id' => $this->getFormId(),
      ];
      $this->getLogger($this->getLoggerChannel())
        ->error($message, $replacements);
    }
  }

}
