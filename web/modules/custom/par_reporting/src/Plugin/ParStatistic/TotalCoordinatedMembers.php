<?php

namespace Drupal\par_reporting\Plugin\ParStatistic;

use Drupal\par_reporting\ParStatisticBase;

/**
 * Cease a member.
 *
 * @ParStatistic(
 *   id = "total_coordinated_members",
 *   title = @Translation("Businesses in coordinated partnerships."),
 *   description = @Translation("The total number of legal entities covered by a coordinated partnerships. If a legal entity is covered by two partnerships it will be counted twice."),
 *   status = TRUE,
 * )
 */
class TotalCoordinatedMembers extends ParStatisticBase {

  public function getStat() {
    $query = $this->getParDataManager()->getEntityQuery('par_data_partnership')
      ->condition('partnership_status', 'confirmed_rd');

    $query->condition('partnership_type', 'coordinated', 'CONTAINS');

    $revoked = $query
      ->orConditionGroup()
      ->condition('revoked', 0)
      ->condition('revoked', NULL, 'IS NULL');
    $deleted = $query
      ->orConditionGroup()
      ->condition('deleted', 0)
      ->condition('deleted', NULL, 'IS NULL');

    $query->condition($revoked);
    $query->condition($deleted);

    $entities = $query->execute();
    $partnerships = $this->getEntityTypeManager()->getStorage('par_data_partnership')->loadMultiple(array_unique($entities));

    $total = 0;
    foreach ($partnerships as $partnership) {
      $count = 0;
      $members = $partnership->getCoordinatedMember();

      // Count how many members are covered by this partnership.
      if ($members && count($members) >= 1) {
        foreach ($partnership->getCoordinatedMember() as $member) {
          $legal_entities = $member->getLegalEntity();

          // Count how many legal entities are covered under this direct partnership.
          if ($legal_entities && count($legal_entities) >= 1) {
            $count += count($legal_entities);
          }
          else {
            $count += 1;
          }

        }
      }
      else {
        $count = 1;
      }

      $total += $count;
    }

    return $total;
  }

}
