<?php

namespace Drupal\par_data\Entity;

use Drupal\trance\TranceType;

/**
 * Defines the par_data_partnership_type entity.
 *
 * @ConfigEntityType(
 *   id = "par_data_partnership_type",
 *   label = @Translation("PAR Partnership Type"),
 *   handlers = {
 *     "list_builder" = "Drupal\trance\TranceTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\trance\Form\TranceTypeForm",
 *       "edit" = "Drupal\trance\Form\TranceTypeForm",
 *       "delete" = "Drupal\trance\Form\TranceTypeDeleteForm"
 *     }
 *   },
 *   config_prefix = "par_data_partnership_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "par_data_partnership",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/par_data/par_data_partnership/{par_data_partnership}",
 *     "edit-form" = "/admin/structure/par_data/par_data_partnership/{par_data_partnership}/edit",
 *     "delete-form" = "/admin/structure/par_data/par_data_partnership/{par_data_partnership}/delete",
 *     "collection" = "/admin/structure/par_data/par_data_partnership"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *     "help"
 *   }
 * )
 */
class ParDataPartnershipType extends TranceType {

}
