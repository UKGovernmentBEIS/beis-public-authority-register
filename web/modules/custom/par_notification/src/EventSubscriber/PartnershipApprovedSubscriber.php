<?php

namespace Drupal\par_notification\EventSubscriber;

use Drupal\par_data\Entity\ParDataEntityInterface;
use Drupal\par_data\Entity\ParDataPerson;
use Drupal\par_data\Event\ParDataEvent;
use Drupal\par_data\Event\ParDataEventInterface;
use Drupal\par_notification\ParNotificationSubscriberBase;

class PartnershipApprovedSubscriber extends ParNotificationSubscriberBase {

  /**
   * The message template ID created for this notification.
   *
   * @see /admin/structure/message/manage/partnership_approved_notificatio
   */
  const MESSAGE_ID = 'partnership_approved_notificatio';

  /**
   * The events to react to.
   *
   * @return mixed
   */
  static function getSubscribedEvents() {
    // Nomination event should fire after a partnership has been nominated.
    $events[ParDataEvent::statusChange('par_data_partnership', 'confirmed_rd')][] = ['onEvent', -101];

    return $events;
  }

  /**
   * Get all the recipients for this notification.
   *
   * @param $event
   *
   * @return ParDataPerson[]
   */
  public function getRecipients(ParDataEventInterface $event) {
    $contacts = [];

    /** @var ParDataEntityInterface $entity */
    $entity = $event->getEntity();

    // Always notify the primary authority contact.
    if ($primary_authority_contact = $entity->getAuthorityPeople(TRUE)) {
      $contacts[$primary_authority_contact->id()] = $primary_authority_contact;
    }
    // Always notify the primary organisation contact.
    if ($primary_organisation_contact = $entity->getOrganisationPeople(TRUE)) {
      $contacts[$primary_organisation_contact->id()] = $primary_organisation_contact;
    }

    // Notify secondary contacts at the authority if there are any.
    if ($authority = $entity->getAuthority(TRUE)) {
      foreach ($authority->getPerson() as $contact) {
        if (!isset($contacts[$contact->id()]) && $contact->hasNotificationPreference(self::MESSAGE_ID)) {
          $contacts[$contact->id()] = $contact;
        }
      }
    }
    // Notify secondary contacts at the organisation if there are any.
    if ($organisation = $entity->getOrganisation(TRUE)) {
      foreach ($organisation->getPerson() as $contact) {
        if (!isset($contacts[$contact->id()]) && $contact->hasNotificationPreference(self::MESSAGE_ID)) {
          $contacts[$contact->id()] = $contact;
        }
      }
    }

    return $contacts;
  }

  /**
   * @param ParDataEventInterface $event
   */
  public function onEvent(ParDataEventInterface $event) {
    /** @var ParDataEntityInterface $par_data_partnership */
    $par_data_partnership = $event->getEntity();

    $contacts = $this->getRecipients($event);
    foreach ($contacts as $contact) {
      if (!isset($this->recipients[$contact->getEmail()])) {
        // Record the recipient so that we don't send them the message twice.
        $this->recipients[$contact->getEmail] = $contact;
        // Try and get the user account associated with this contact.
        $account = $contact->getOrLookupUserAccount();

        $message = $this->createMessage();

        // Add contextual information to this message.
        if ($message->hasField('field_partnership')) {
          $message->set('field_partnership', $par_data_partnership);
        }

        // Add some custom arguments to this message.
        $message->setArguments([
          '@partnership_organisation' => $par_data_partnership->getOrganisation(TRUE)->label(),
        ]);

        // The owner is the user who this message belongs to.
        if ($account) {
          $message->setOwnerId($account->id());
        }

        // Send the message.
        $this->sendMessage($message, $contact->getEmail());
      }
    }
  }
}
