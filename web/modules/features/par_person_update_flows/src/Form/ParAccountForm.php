<?php

namespace Drupal\par_person_update_flows\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\par_data\Entity\ParDataPerson;
use Drupal\par_data\Entity\ParDataPremises;
use Drupal\par_flows\Form\ParBaseForm;
use Drupal\par_forms\Plugin\ParForm\ParChooseAccount;
use Drupal\par_person_update_flows\ParFlowAccessTrait;
use Drupal\user\Entity\Role;
use Drupal\user\Entity\User;

/**
 * The form for choosing whether to create an account for this user.
 */
class ParAccountForm extends ParBaseForm {

  use ParFlowAccessTrait;

  /**
   * Set the page title.
   */
  protected $pageTitle = 'Give this person a user account?';

  /**
   * {@inheritdoc}
   */
  public function loadData() {
    $this->getFlowDataHandler()->setFormPermValue("ignore_account_option_" . ParChooseAccount::DELETE, TRUE);

    parent::loadData();
  }

}
