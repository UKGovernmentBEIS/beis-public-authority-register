<?php

namespace Drupal\par_notification\Plugin\ParLinkAction;

use Drupal\Core\Url;
use Drupal\message\MessageInterface;
use Drupal\par_notification\ParLinkActionBase;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Send user to the enforcement page.
 *
 * @ParLinkAction(
 *   id = "enforcement_view",
 *   title = @Translation("View enforcement notice."),
 *   status = TRUE,
 *   weight = 2,
 *   notification = {
 *     "new_enforcement_notification",
 *     "reviewed_enforcement",
 *   }
 * )
 */
class ParEnforcementView extends ParLinkActionBase {

  public function receive(MessageInterface $message) {
    if ($message->hasField('field_enforcement_notice') && !$message->get('field_enforcement_notice')->isEmpty()) {
      $par_data_enforcement_notice = current($message->get('field_enforcement_notice')->referencedEntities());

      // The route for viewing enforcement notices.
      $destination = Url::fromRoute('par_enforcement_send_flows.send_enforcement', ['par_data_enforcement_notice' => $par_data_enforcement_notice->id()]);

      if (!$par_data_enforcement_notice->inProgress() && $destination->access($this->user)) {
        return new RedirectResponse($destination->toString());
      }
    }
  }
}
