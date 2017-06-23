<?php

namespace Drupal\par_demo_forms\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\par_forms\Form\ParBaseForm;

/**
 * A demo multi-step form.
 */
class ParDemoThirdForm extends ParBaseForm {

  /**
   * @var string
   *   A machine safe value representing the current form journey.
   */
  protected $flow = 'pa';

  public function getFormId() {
    return 'par_demo_third';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $retrieved = $this->getTempData();

    $form['hobby'] = [
      '#type' => 'textfield',
      '#title' => t('Hobbies'),
      '#default_value' => $retrieved['hobby'] ?: '',
    ];

    $form['save'] = [
      '#type' => 'submit',
      '#value' => t('Save'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // We can perform other logic here to save the data.
    // The base class will store all the data to the
    // temporary store.
    // $name = $form_state->getValue('name');
    // $data = array(
    //   'type' => 'article',
    //   'title' => $name,
    //   'uid' => $this->currentUser->id(),
    // );
    // $node = \Drupal::entityManager()
    //   ->getStorage('node')
    //   ->create($data);
    // $node->save();

    $form_state->setRedirect('par_demo_forms.first');

    parent::submitForm($form, $form_state);
  }
}
