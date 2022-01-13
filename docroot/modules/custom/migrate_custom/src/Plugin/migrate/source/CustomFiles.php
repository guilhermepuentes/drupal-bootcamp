<?php

namespace Drupal\migrate_custom\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Drupal 6 file source from database.
 *
 * @MigrateSource(
 *   id = "custom_files"
 * )
 */
class customFiles extends DrupalSqlBase {

  /**
   * The file directory path.
   *
   * @var string
   */
  protected $filePath;

  /**
   * The temporary file path.
   *
   * @var string
   */
  protected $tempFilePath;

  /**
   * Flag for private or public file storage.
   *
   * @var bool
   */
  protected $isPublic;

  /**
   * {@inheritdoc}
   */
  public function query() {
    return $this->select('files', 'f')
      ->fields('f', ['fid', 'file_name', 'file_filepath']);
      //->orderBy('timestamp')
      // If two or more files have the same timestamp, they'll end up in a
      // non-deterministic order. Ordering by fid (or any other unique field)
      // will prevent this.
  }

  /**
   * {@inheritdoc}
   */
  protected function initializeIterator() {
    $site_path = isset($this->configuration['site_path']) ? $this->configuration['site_path'] : 'sites/default';
    $this->filePath = $this->variableGet('file_directory_path', $site_path . '/files') . '/';
    $this->tempFilePath = $this->variableGet('file_directory_temp', '/tmp') . '/';

    // FILE_DOWNLOADS_PUBLIC == 1 and FILE_DOWNLOADS_PRIVATE == 2.
    $this->isPublic = $this->variableGet('file_downloads', 1) == 1;
    return parent::initializeIterator();
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $row->setSourceProperty('file_directory_path', $this->filePath);
    $row->setSourceProperty('temp_directory_path', $this->tempFilePath);
    $row->setSourceProperty('is_public', $this->isPublic);

    $row->setSourceProperty('status', 1);
    $row->setSourceProperty('uid', 1);

    drush_print_r($row);
    return parent::prepareRow($row);

  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return array(
      'fid' => $this->t('File ID'),
      'uid' => $this->t('The {users}.uid who added the file. If set to 0, this file was added by an anonymous user.'),
      'file_name' => $this->t('File name'),
      'file_filepath' => $this->t('File path'),
      'status' => $this->t('The published status of a file.'),
      'is_public' => $this->t('TRUE if the files directory is public otherwise FALSE.'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'fid' => [
        'type' => 'integer',
        'alias' => 'f',
      ],
    ];
  }

}