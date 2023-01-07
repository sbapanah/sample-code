<?php

namespace Drupal\sbstory\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Datetime\DateFormatterInterface;

/**
 * Provides current time based on the configuration.
 */
class CurrentTimeService {

  /**
   * Config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * A date time instance.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Constructs an EntityDecorator object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   Configuration factory.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   A date time instance.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, TimeInterface $time, DateFormatterInterface $date_formatter) {
    $this->configFactory = $config_factory;
    $this->time = $time;
    $this->dateFormatter = $date_formatter;
  }

  /**
   * {@inheritdoc}
   */
  public function getCurrentTime() {
    $config = $this->configFactory->get('sbstory.settings');
    $sbstory_timezone = $config->get('sbstory_timezone') ?? 'America/Chicago';
    $now = $this->time->getCurrentTime();
    $current_date_time['current_date'] = $this->dateFormatter->format($now, 'custom', 'l, d F Y', $sbstory_timezone);
    $current_date_time['current_time'] = $this->dateFormatter->format($now, 'custom', 'h : i a', $sbstory_timezone);

    return $current_date_time;
  }

}
