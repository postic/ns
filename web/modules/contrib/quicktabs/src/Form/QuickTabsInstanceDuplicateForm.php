<?php

namespace Drupal\quicktabs\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityForm;

/**
 * Creates QuickTabsInstanceDuplicateForm entity form.
 */
class QuickTabsInstanceDuplicateForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  protected function prepareEntity() {
    // Do not prepare the entity while it is being added.
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state): array {
    parent::form($form, $form_state);

    $form['#title'] = $this->t('Duplicate of @label', ['@label' => $this->entity->label()]);

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#required' => TRUE,
      '#size' => 32,
      '#maxlength' => 255,
      '#default_value' => $this->t('Duplicate of @label', ['@label' => $this->entity->label()]),
    ];
    $form['id'] = [
      '#type' => 'machine_name',
      '#maxlength' => 32,
      '#default_value' => '',
      '#machine_name' => [
        'exists' => 'quicktabs_machine_name_exists',
      ],
      '#description' => $this->t('A unique machine-readable name for this QuickTabs instance. It must only contain lowercase letters, numbers, and underscores. The machine name will be used internally by QuickTabs and will be used in the CSS ID of your QuickTabs block.'),
      '#weight' => -8,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  protected function actions(array $form, FormStateInterface $form_state): array {
    $actions['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Duplicate'),
    ];
    return $actions;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->entity = $this->entity->createDuplicate();
    $this->entity->set('label', $form_state->getValue('label'));
    $this->entity->set('id', $form_state->getValue('id'));
    $this->entity->save();

    // Redirect the user to the view admin form.
    $form_state->setRedirectUrl($this->entity->toUrl('edit-form'));
  }

}
