<?php

namespace Drupal\migrate_custom\Plugin\migrate\source;

use Drupal\Core\Database\Database;
use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for the custom_user.
 *
 * @MigrateSource(
 *   id = "custom_user"
 * )
 */
class customUser extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {

    $query = $this->select('users', 'u')
      ->fields('u', ['uid', 'name', 'login', 'pass', 'email']);

    return $query;
  }
  
  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'uid' => $this->t('User ID'),
      'name' => $this->t('User name'),
      'login' => $this->t('User login'),
      'email' => $this->t('User email'),
      'pass' => $this->t('User pass'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'uid' => [
        'type' => 'integer',
        'alias' => 'u',
      ],
    ];
  }
}
