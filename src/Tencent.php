<?php
/**
 * @author    : Death-Satan
 * @date      : 2021/8/18
 * @createTime: 23:58
 * @company   : Death撒旦
 * @link      https://www.cnblogs.com/death-satan
 */
namespace think\filesystem\driver;

use Freyo\Flysystem\QcloudCOSv5\Adapter;
use Qcloud\Cos\Client;

/**
 * 腾讯云 oss 驱动
 * Class Tencent
 * @package think\filesystem\driver
 */
class Tencent extends \think\filesystem\Driver
{
    protected function createAdapter (): \League\Flysystem\FilesystemAdapter
    {
        return new Adapter(new Client($this->config),$this->config);
    }
}