<?php

namespace Drupal\par_partnership_contact_remove_flows;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\par_data\Entity\ParDataCoordinatedBusiness;
use Drupal\par_data\Entity\ParDataPartnership;
use Drupal\par_flows\ParFlowException;
use Drupal\user\Entity\User;
use Symfony\Component\Routing\Route;
use Drupal\Core\Routing\RouteMatchInterface;

trait ParFlowAccessTrait {

  /**
   * @param \Symfony\Component\Routing\Route $route
   *   The route.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match object to be checked.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account being checked.
   */
  public function accessCallback(Route $route, RouteMatchInterface $route_match, AccountInterface $account, ParDataPartnership $par_data_partnership = NULL, $type = NULL) {
    try {
      $this->getFlowNegotiator()->setRoute($route_match);
      $this->getFlowDataHandler()->reset();
      $this->getFlowDataHandler()->setParameter('par_data_partnership', $par_data_partnership);
      $this->getFlowDataHandler()->setParameter('type', $type);
      $this->loadData();
    } catch (ParFlowException $e) {

    }

    switch ($type) {
      case 'authority':
        if (!$account->hasPermission('remove partnership authority contact')) {
          $this->accessResult = AccessResult::forbidden('User does not have permissions to remove authority contacts.');
        }
        $people = $par_data_partnership->getAuthorityPeople();

        break;

      case 'organisation':
        if (!$account->hasPermission('remove partnership organisation contact')) {
          $this->accessResult = AccessResult::forbidden('User does not have permissions to remove organisation contacts.');
        }
        $people = $par_data_partnership->getOrganisationPeople();

        break;

      default:
        $this->accessResult = AccessResult::forbidden('A valid contact type must be choosen.');
    }

    // This can't be the last contact left on the partnership.
    if (count($people) <= 1) {
      $this->accessResult = AccessResult::forbidden('You cannot remove the last contact on this partnership.');
    }

    return parent::accessCallback($route, $route_match, $account);
  }
}
