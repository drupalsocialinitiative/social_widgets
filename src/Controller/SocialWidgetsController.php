<?php

namespace Drupal\social_widgets\Controller;

use Drupal\Core\Menu\LocalTaskManager;
use Drupal\social_api\Controller\SocialApiController;
use Drupal\social_api\Plugin\NetworkManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Renders the integration list.
 */
class SocialWidgetsController extends SocialApiController {

  /**
   * The network manager.
   * 
   * @var NetworkManager
   */
  private $networkManager;

  /**
   * @var LocalTaskManager
   */
  private $localTaskManager;

  /**
   * Constructs a SocialWidgetsController object.
   *
   * @param NetworkManager $networkManager
   * @param LocalTaskManager $localTaskManager
   */
  public function __construct(NetworkManager $networkManager, LocalTaskManager $localTaskManager) {
    parent::__construct($networkManager);

    $this->networkManager = $networkManager;
    $this->localTaskManager = $localTaskManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.network.manager'),
      $container->get('plugin.manager.menu.local_task')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function integrations($type = 'social_widgets') {
    return parent::integrations($type);
  }

  /**
   * List widgets per social network.
   *
   * @var string $parent_id
   *
   * @return array
   *
   * @TODO this method should be removed after finding a better way of listing widgets for a social network
   */
  public function listWidgets($social_network) {
    $networks = $this->networkManager->getDefinitions();
    $header = [
      $this->t('Module'),
      $this->t('Social Network'),
    ];
    $data = [];
    foreach ($networks as $network) {
      if ($network['type'] == 'social_widgets' && $network['social_network'] == $social_network) {
        $data[] = [
          $network['id'],
          $network['social_network'],
        ];
      }
    }
    return [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $data,
      '#empty' => $this->t('There are no social integrations enabled.'),
    ];
  }

}
