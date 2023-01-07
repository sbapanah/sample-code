<?php

namespace Drupal\sbstory\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\sbstory\Service\CurrentTimeService;

/**
 * Provides an 'Automated Logout info' block.
 *
 * @Block(
 *   id = "site_location_display",
 *   admin_label = @Translation("Site Location Display"),
 *   category = @Translation("Custom"),
 * )
 */
class SiteLocationDisplayBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The configuration factory.
   *
   * @var \Drupal\sbstory\Service\CurrentTimeService
   */
  protected $currentTimeService;

  /**
   * Constructs an AutologoutWarningBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\sbstory\Service\CurrentTimeService $current_time_service
   *   Get the configured timezone.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    ConfigFactoryInterface $config_factory,
    CurrentTimeService $current_time_service
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
    $this->currentTimeService = $current_time_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(
    ContainerInterface $container,
    array $configuration,
    $plugin_id,
    $plugin_definition
  ) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('sbstory.current_time')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->configFactory->get('sbstory.settings');
    $data['sbstory_country'] = $config->get('sbstory_country') ?? '';
    $data['sbstory_city'] = $config->get('sbstory_city') ?? '';
    $data['current_date_time'] = $this->currentTimeService->getCurrentTime();
    return [
      '#theme' => 'site_location',
      '#data' => $data,
    ];
  }

}
