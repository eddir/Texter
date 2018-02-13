<?php

/**
 * // English
 *
 * Texter, the display FloatingTextPerticle plugin for PocketMine-MP
 * Copyright (c) 2018 yuko fuyutsuki < https://github.com/fuyutsuki >
 *
 * This software is distributed under "MIT license".
 * You should have received a copy of the MIT license
 * along with this program.  If not, see
 * < https://opensource.org/licenses/mit-license >.
 *
 * ---------------------------------------------------------------------
 * // 日本語
 *
 * TexterはPocketMine-MP向けのFloatingTextPerticleを表示するプラグインです。
 * Copyright (c) 2018 yuko fuyutsuki < https://github.com/fuyutsuki >
 *
 * このソフトウェアは"MITライセンス"下で配布されています。
 * あなたはこのプログラムと共にMITライセンスのコピーを受け取ったはずです。
 * 受け取っていない場合、下記のURLからご覧ください。
 * < https://opensource.org/licenses/mit-license >
 */

namespace tokyo\pmmp\Texter\manager;

// pocketmine
use pocketmine\{
  utils\Config
};

// texter
use tokyo\pmmp\Texter\{
  Core
};

/**
 * AbstractManagerClass
 */
abstract class Manager {

  private const JSON_OPTIONS = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

  /** @var ?self */
  protected static $instance = null;
  /** @var ?Core */
  protected $core = null;
  /** @var string */
  protected $dir = "";
  /** @var string */
  protected $configName = "config.yml";
  /** @var int */
  protected $configType = Config::YAML;
  /** @var ?Config */
  protected $config = null;

  public function __construct(Core $core) {
    $this->core = $core;
    $this->init();
    $this->registerInstance();
  }

  /**
   * @return void
   */
  private function init(): void {
    $this->core->saveResource($this->configName);
    $this->config = new Config($this->core->dir.$this->configName, $this->configType);
    if ($this->configType === Config::JSON) {
      $this->config->enableJsonOption(self::JSON_OPTIONS);
    }
  }

  /**
   * @param  string $key
   * @return string
   */
  public function getString(string $key): string {
    return (string)$this->config->get($key);
  }

  /**
   * @param  string $key
   * @return int
   */
  public function getInt(string $key): int {
    return (int)$this->config->get($key);
  }

  /**
   * @param  string $key
   * @return array
   */
  public function getArray(string $key): array {
    return (array)$this->config->get($key);
  }

  /**
   * @param  string $key
   * @return bool
   */
  public function getBool(string $key): bool {
    return (bool)$this->config->get($key);
  }

  /**
   * @internal
   * @return void
   */
  abstract protected function registerInstance(): void;

  /**
   * @return self Manager
   */
  abstract public static function get();
}