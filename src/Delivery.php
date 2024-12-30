<?php

namespace Wsmallnews\Delivery;

use Wsmallnews\Delivery\Exceptions\DeliveryException;
use Wsmallnews\Delivery\Adapters\ExpressAdapter;

class Delivery 
{


    /**
     * delivery 配送列表
     *
     * @var array
     */
    protected $drivers = [];

    /**
     * 注册的自定义 驱动列表
     *
     * @var array
     */
    protected $customCreators = [];


    protected $content;

    public function __construct($a) {
        $this->content = $a;
        print_r(111111);
    }


    // 测试代码，随时可删
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }


    public function getContent()
    {
        return $this->content;
    }


    /**
     * 获取一个 driver 实例
     *
     * @param  string|null  $name
     * @return Sender
     */
    public function driver($name = null)
    {
        return $this->deliveryer($name);
    }

    /**
     * 获取一个 driver 实例
     *
     * @param  string|null  $name
     * @return Sender
     */
    public function deliveryer($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();

        return $this->drivers[$name] = $this->get($name);
    }



    /**
     * 尝试从缓存中获取 driver 实例
     *
     * @param  string  $name
     * @return Sender
     */
    protected function get($name)
    {
        return $this->drivers[$name] ?? $this->resolve($name);
    }

    /**
     * Resolve driver
     *
     * @param  string  $name
     * @param  array|null  $config
     * @return Sender
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name, $config = null)
    {
        $config ??= $this->getConfig($name);

        if (empty($config['driver'])) {
            throw new DeliveryException("配送驱动 [{$name}] 为空.");
        }

        $name = $config['driver'];

        if (isset($this->customCreators[$name])) {
            return $this->callCustomCreator($config);
        }

        $driverMethod = 'create' . ucfirst($name) . 'Driver';

        if (!method_exists($this, $driverMethod)) {
            throw new DeliveryException("配送驱动 [{$name}] 不支持.");
        }

        return $this->{$driverMethod}($config);
    }

    /**
     * Call a custom driver creator.
     *
     * @param  array  $config
     * @return Sender
     */
    protected function callCustomCreator(array $config)
    {
        return $this->customCreators[$config['driver']]($config);
    }


    /**
     * 创建一个 快递物流 发货实例
     *
     * @param  array  $config
     * @return Sender
     */
    public function createExpressDriver(array $config)
    {
        $adapter = new ExpressAdapter($config);

        return new Sender($adapter);
    }


    /**
     * 创建一个 wechat 发货实例
     *
     * @param  array  $config
     * @return Sender
     */
    // public function createKdniaoDriver(array $config)
    // {
    //     $adapter = new KdniaoAdapter($config);

    //     return new Sender($adapter);
    // }



    // /**
    //  * 创建一个 手动发货实例
    //  *
    //  * @param  array  $config
    //  * @return Sender
    //  */
    // public function createManualDriver(array $config)
    // {
    //     $adapter = new ManualAdapter($config);

    //     return new Sender($adapter);
    // }



    /**
     * Get the default driver name.
     *
     * @return string
     */
    // public function getDefaultDriver()
    // {
    //     return '';          // 没有默认配置，必须传入要使用的 driver
    // }


    /**
     * Get the filesystem connection configuration.
     *
     * @param  string  $name
     * @return array
     */
    // protected function getConfig($name)
    // {
    //     // @sn todo 打印机配置

    //     $config = [
    //         'wechat' => [
    //             'driver' => 'wechat',
    //         ],
    //         'manual' => [
    //             'driver' => 'manual'
    //         ],
    //         'thinkapi' => [
    //             'driver' => 'thinkapi',
    //             'app_code' => '123456789'
    //         ],
    //         'kdniao' => [
    //             'driver' => 'kdniao',
    //             'request_type' => 'vip',            // free: 免费版, vip: 付费版/增值版

    //             // 快递鸟 id & app_key
    //             'ebusiness_id' => '',
    //             'app_key' => '',

    //             // 电子面单账号；电子面单账号对照表，文档地址：https://www.yuque.com/kdnjishuzhichi/dfcrg1/hrfw43
    //             'customer_name' => '',
    //             'customer_pwd' => '',
    //             'month_code' => '',
    //             'send_site' => '',
    //             'send_staff' => '',

    //             // 签约快递公司信息
    //             'express_code' => '',
    //             'express_name' => '',

    //             'pay_type' => '',       // 结算方式  运费支付方式：1：现付；2：到付；3：月结；4：第三方付顺丰跨越；4：回单付京运达
    //             'exp_type' => '',       // 快递业务类型，文档地址：https://www.yuque.com/kdnjishuzhichi/dfcrg1/hgx758hom5p6wz0l
    //         ]
    //     ];

    //     return $config[$name];
    //     // return $this->app['config']["filesystems.disks.{$name}"] ?: [];
    // }


}
