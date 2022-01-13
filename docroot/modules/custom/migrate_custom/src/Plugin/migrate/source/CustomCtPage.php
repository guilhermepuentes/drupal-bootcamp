<?php

namespace Drupal\migrate_custom\Plugin\migrate\source;

use Drupal\Core\Database\Database;
use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for the custom_tags.
 *
 * @MigrateSource(
 *   id = "custom_ct_page"
 * )
 */
class customCtPage extends SqlBase {

  public function query() {
    return $this->select('content', 'c')
      ->fields('c', ['con_id', 'title', 'body', 'autor', 'status']);

  }

  public function fields() {
    return array(
      'con_id' => $this->t('Content ID'),
      'title' => $this->t('Title'),
      'body' => $this->t('Body'),
      'autor' => $this->t('Autor'),
      'tags' => $this->t('Autor'),
      'image_fid' => $this->t('Image ID'),
      'status' => $this->t('Published'),
    );
  }

  /**
   * {@inheritdoc}
  */
  public function prepareRow(Row $row) {

    /**
     * Recupera os termos atrelados ao node
     */

    $query = $this->select('content_cat', 'c')->fields('c', ['cid']);
    $query ->condition('c.con_id', $row->getSourceProperty('con_id'));
    $terms = $query ->execute()->fetchCol();

    //Atribui os termos ao campo tags
    $row->setSourceProperty('tags', $terms);

    /**
     * Recupera a imagem atrela ao node
     */

    $query = $this->select('content_files', 'f')->fields('f', ['fid']);
    $query ->condition('f.con_id', $row->getSourceProperty('con_id'));
    $fid = $query ->execute()->fetchCol();

    //Atribui ao campo de imagem o arquivo
    $row->setSourceProperty('image_fid', $fid );

    return parent::prepareRow($row);
  }

    /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'con_id' => [
        'type' => 'integer',
        'alias' => 'c',
      ],
    ];
  }
}
