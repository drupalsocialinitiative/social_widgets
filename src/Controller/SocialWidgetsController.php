<?php

namespace Drupal\social_widgets\Controller;

use Drupal\social_api\Controller\SocialApiController;

/**
 * Renders the integration list.
 */
class SocialWidgetsController extends SocialApiController {

  /**
   * {@inheritdoc}
   */
  public function integrations($type = 'social_widgets') {
    return parent::integrations($type);
  }

}
