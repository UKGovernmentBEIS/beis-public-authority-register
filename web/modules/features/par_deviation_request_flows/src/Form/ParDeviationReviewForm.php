<?php

namespace Drupal\par_deviation_request_flows\Form;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\file\FileInterface;
use Drupal\par_data\Entity\ParDataCoordinatedBusiness;
use Drupal\par_data\Entity\ParDataDeviationRequest;
use Drupal\par_deviation_request_flows\ParFormCancelTrait;
use Drupal\par_flows\Form\ParBaseForm;
use Drupal\par_data\Entity\ParDataPartnership;
use Drupal\par_flows\ParDisplayTrait;
use Drupal\par_deviation_request_flows\ParFlowAccessTrait;

/**
 * The confirming the user is authorised to revoke partnerships.
 */
class ParDeviationReviewForm extends ParBaseForm {

  use ParFlowAccessTrait;
  use ParFormCancelTrait;

  /**
   * Set the page title.
   */
  protected $pageTitle = "Review request";

  public function loadData() {
    // Set the data values on the entities
    $entities = $this->createEntities();
    extract($entities);
    /** @var ParDataPartnership $par_data_partnership */
    /** @var ParDataDeviationRequest $par_data_deviation_request */
    /** @var FileInterface $document */

    if ($par_data_deviation_request->hasField('request_date')) {
      $this->getFlowDataHandler()->setFormPermValue("request_date", $par_data_deviation_request->request_date->view('full'));
    }
    if ($par_data_deviation_request->hasField('notes')) {
      $this->getFlowDataHandler()->setFormPermValue("notes", $par_data_deviation_request->notes->view('full'));
    }
    if ($document) {
      $document_view_builder = $this->getParDataManager()->getViewBuilder('file');
      $this->getFlowDataHandler()->setFormPermValue("document", $document_view_builder->view($document, 'title'));
    }

    parent::loadData();
  }

  public function createEntities() {
    $par_data_partnership = $this->getFlowDataHandler()->getParameter('par_data_partnership');

    // Get the cache IDs for the various forms that needs needs to be extracted from.
    $inspection_plan_cid = $this->getFlowNegotiator()->getFormKey('par_inspection_plan_selection');
    $enforcement_officer_cid = $this->getFlowNegotiator()->getFormKey('par_enforcement_officer_details');
    $enforcing_authority_cid = $this->getFlowNegotiator()->getFormKey('par_authority_selection');
    $deviation_request_cid = $this->getFlowNegotiator()->getFormKey('par_deviation_request');

    $request_date = DrupalDateTime::createFromTimestamp(time(), NULL, ['validate_format' => FALSE]);

    // Create the enforcement notice.
    $par_data_deviation_request = ParDataDeviationRequest::create([
      'notes' => $this->getFlowDataHandler()->getTempDataValue('notes', $deviation_request_cid),
      'field_enforcing_authority' => $this->getFlowDataHandler()->getDefaultValues('par_data_authority_id', NULL, $enforcing_authority_cid),
      'field_person' =>  $this->getFlowDataHandler()->getDefaultValues('enforcement_officer_id', NULL, $enforcement_officer_cid),
      'field_inspection_plan' => $this->getFlowDataHandler()->getDefaultValues('inspection_plan_id', NULL, $inspection_plan_cid),
      'field_partnership' => $par_data_partnership->id(),
      'request_date' => $request_date->format('Y-m-d'),
    ]);

    return [
      'par_data_partnership' => $par_data_partnership,
      'par_data_deviation_request' => $par_data_deviation_request,
      'document' => current(File::loadMultiple((array) $this->getFlowDataHandler()->getTempDataValue('files', $deviation_request_cid))),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, ParDataPartnership $par_data_partnership = NULL, ParDataCoordinatedBusiness $par_data_coordinated_business = NULL) {

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

//    $par_data_coordinated_business = $this->getFlowDataHandler()->getParameter('par_data_coordinated_business');
//
//    // We only want to cease members that are currently active.
//    if (!$par_data_coordinated_business->isRevoked()) {
//      $cid = $this->getFlowNegotiator()->getFormKey('cease_date');
//      $ceased = $par_data_coordinated_business->cease($this->getFlowDataHandler()->getTempDataValue('date_membership_ceased', $cid));
//
//      if ($ceased) {
//        $this->getFlowDataHandler()->deleteStore();
//      }
//      else {
//        $message = $this->t('Cease date could not be saved for %form_id');
//        $replacements = [
//          '%form_id' => $this->getFormId(),
//        ];
//        $this->getLogger($this->getLoggerChannel())
//          ->error($message, $replacements);
//      }
//
//    }
  }


}
