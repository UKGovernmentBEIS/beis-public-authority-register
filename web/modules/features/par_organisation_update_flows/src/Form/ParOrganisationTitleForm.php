<?php

namespace Drupal\par_organisation_update_flows\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\par_flows\Form\ParBaseForm;
use Drupal\par_organisation_update_flows\ParFlowAccessTrait;

/**
 * The organisation title form.
 */
class ParOrganisationTitleForm extends ParBaseForm {

  use ParFlowAccessTrait;

  /**
   * Set the page title.
   */
  protected $pageTitle = 'Organisation Name';

}