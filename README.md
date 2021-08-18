# thinkphp6 腾讯云oss

基于 [freyo/flysystem-qcloud-cos-v5](https://github.com/freyo/flysystem-qcloud-cos-v5) 轻度封装tp

## 初始化
### 修改配置 *config/filesystem.php* 文件

---
```php
<?php

return [
    // 默认磁盘
    'default' => env('filesystem.driver', 'local'),
    // 磁盘列表
    'disks'   => [
        'local'  => [
            'type' => 'local',
            'root' => app()->getRuntimePath() . 'storage',
        ],
        'public' => [
            // 磁盘类型
            'type'       => 'local',
            // 磁盘路径
            'root'       => app()->getRootPath() . 'public/storage',
            // 磁盘路径对应的外部URL路径
            'url'        => '/storage',
            // 可见性
            'visibility' => 'public',
        ],
        //新增一个阿里云磁盘
        'tencent'=>[
            'type'            => 'Tencent',//设置驱动
            'region'          => 'ap-guangzhou',//设置一个默认的存储桶地域
            'credentials'     => [
                'appId'     => null,//appid
                'secretId'  => 'your-secret-id',//"云 API 密钥 SecretId";
                'secretKey' => 'your-secret-key', //"云 API 密钥 SecretKey";
                'token'     => null,//"临时密钥 token";
            ],
            'timeout'         => 60,//
            'connect_timeout' => 60,//
            'bucket'          => 'your-bucket-name', //设置一个默认的存储桶地域
            'cdn'             => '',//cdn地址
            'scheme'          => 'https', //协议头部，默认为http
            'read_from_cdn'   => false,//
            'cdn_key'         => '',//cdn key
            'encrypt'         => false,//
        ]
        // 更多的磁盘配置信息
    ],
];

```
---

## 使用方法
### 通过filesystem使用

---
```php 
//通过门面使用
think\facade\Filesystem::disk('tencent')
//在控制器中通过注入使用
class TestControl{

    public function Test(\think\Filesystem $filesystem)
    {
        $aliyun = $filesystem->disk('tencent');
    }
}
```
---

### 文件上传

```php 
<?php
namespace app\controller;

use app\BaseController;
use app\Request;
use think\facade\Filesystem;

class Index extends BaseController
{
    public function index(Request $request)
    {
        //获取上传文件
        $file = $request->file('image');
        //通过filesystem进行上传
        $url = Filesystem::disk('tencent')->putFile('images', $file);
        if (!$url) new \exception('上传失败');

        dd('上传成功,文件位置:' . $url);
    }
}
```