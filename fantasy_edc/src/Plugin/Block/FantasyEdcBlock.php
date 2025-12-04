<?php

namespace Drupal\fantasy_edc\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a "Fantasy EDC Generator" block.
 *
 * @Block(
 *   id = "fantasy_edc_block",
 *   admin_label = @Translation("Fantasy EDC Generator")
 * )
 */
class FantasyEdcBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Render the form inside the block.
    return \Drupal::formBuilder()->getForm('Drupal\fantasy_edc\Form\FantasyEdcForm');
  }

}
