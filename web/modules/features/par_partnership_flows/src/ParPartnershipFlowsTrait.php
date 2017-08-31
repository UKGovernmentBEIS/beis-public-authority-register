<?php

namespace Drupal\par_partnership_flows;

use Drupal\par_flows\ParFlowException;
use Drupal\user\Entity\User;

/**
 * The base form controller for all PAR forms.
 *
 * This trait MUST be used only on forms on controllers that
 * extend the par_flows base form and controller.
 */

trait ParPartnershipFlowsTrait {

  /**
   * Get the current flow name.
   *
   * @return string
   *   The string representing the name of the current flow.
   */
  public function getFlowName() {
    // To proceed we need the current User account
    // and the partnership from the url.
    $account = User::Load($this->currentUser()->id());
    $par_data_partnership = $this->getRouteParam('par_data_partnership');

    // IF the route is in only one flow then *perhaps* we can just return that flow...
    // @TODO Is this a wanted feature?? Let's discuss.
    $flows = \Drupal::entityTypeManager()->getStorage('par_flow')->loadByRoute($this->getCurrentRoute());
    if (count($flows) === 1) {
      return key($flows);
    }

    // IF User has helpdesk permissions && the Route is in the helpdesk flow...
    if (isset($flows['helpdesk']) && $this->currentUser()->hasPermission('bypass par_data access')) {
      return 'helpdesk';
    }

    // IF Route is in authority flow && User is an authority member...
    if (isset($flows['partnership_authority']) && $par_data_partnership && $par_data_partnership->isAuthorityMember($account)) {
      return 'partnership_authority';
    }

    // IF Route is in direct flow && User is an organisation member && Partnership is in URL && Partnership is direct...
    if (isset($flows['partnership_direct']) && $par_data_partnership && $par_data_partnership->isDirect()) {
      return 'partnership_direct';
    }

    // IF Route is in coordinated flow && User is an organisation member && Partnership is in URL && Partnership is coordinated...
    if (isset($flows['partnership_coordinated']) && $par_data_partnership && $par_data_partnership->isCoordinated()) {
      return 'partnership_coordinated';
    }

    // Throw an error if the flow is still ambiguous.
    if (empty($this->flow) && count($flows) >= 1) {
      throw new ParFlowException('The flow name is ambiguous.');
    }

    return parent::getFlowName();
  }
}
