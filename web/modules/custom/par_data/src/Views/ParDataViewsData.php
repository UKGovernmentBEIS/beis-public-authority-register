<?php

namespace Drupal\par_data\Views;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for trance entities.
 */
class ParDataViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $entity_type_label = $this->entityType->getLabel();

    if (isset($data[$this->entityType->getDataTable()]['table']['base']['title'])) {
      $data[$this->entityType->getDataTable()]['table']['base']['title'] = $entity_type_label;
    }
    if (isset($data[$this->entityType->getRevisionDataTable()]['table']['base']['title'])) {
      $data[$this->entityType->getRevisionDataTable()]['table']['base']['title'] = $this->t('@label revision', [
        '@label' => $entity_type_label,
      ]);
    }

    // Document Completion as a %.
    $data['par_partnerships_revision']['document_completion'] = array(
      'title' => t('Documents Completion Percentage'),
      'field' => [
        'title' => t('Documents Completion Percentage'),
        'help' => t('Completion percentage for partnership required documents'),
        'id' => 'par_partnership_revision_documents_completion_percentage',
      ],
    );

    // PAR Partnership Status Filter.
    $data[$this->entityType->getDataTable()]['partnership_status'] = [
      'filter' => [
        'title' => t('PAR Partnership Status'),
        'help' => t('Provides a partnership status field filter with options.'),
        'id' => 'par_data_field_allowed_options_filter',
      ],
    ];

    // PAR Enforcement Action Status Filter.
    $data[$this->entityType->getDataTable()]['enforcement_action_status'] = [
      'filter' => [
        'title' => t('PAR Enforcement Status'),
        'help' => t('Provides a enforcement status field filter with options.'),
        'id' => 'par_data_field_allowed_options_filter',
      ],
    ];

    // PAR Status Field and Filter.
    $data[$this->entityType->getDataTable()]['par_status'] = [
      'title' => t('PAR Status'),
      'field' => [
        'title' => t('PAR Status'),
        'help' => t('Provides the status field for PAR entities.'),
        'id' => 'par_data_status',
      ],
    ];

    // PAR Flow Link.
    $data[$this->entityType->getDataTable()]['par_flow_link'] = [
      'title' => t('PAR Flow Link'),
      'field' => [
        'title' => t('PAR Flow Link'),
        'help' => t('Provides a link with the entity title.'),
        'id' => 'par_flow_link',
      ],
    ];

    // Custom filter for Par Membership checks.
    $data[$this->entityType->getDataTable()]['id_filter'] = [
      'title' => t('Partnership: Can user update?'),
      'filter' => [
        'title' => t('Partnership: Can user update?'),
        'help' => t('Filter by partnerships this user can update.'),
        'id' => 'par_member',
      ],
    ];

    return $data;
  }

}
