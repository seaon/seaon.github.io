[^_^]: name=install-PHP-extensions
[^_^]: title=PHP安装扩展
[^_^]: date=2017-06-27
# PHP安装扩展
  最近在腾讯云上买了一个1G1M的VPS，在上面各种折腾，顺手安装了PHP、Nginx。在学习Socket的时候，报错说未安装扩展，然后查询资料成功加载了扩展。

## 安装步骤

- 切到源码目录下`ext`文件夹下，找到要安装的扩展，如sockets，执行以下命令

```sh
cd sockets/
phpize
./configure --with-php-config=/usr/local/php/bin/php-config
make && make install
```

- 生成so文件后，在配置文件中添加
```
extension=/usr/local/php/lib/php/extensions/no-debug-non-zts-20160303/sockets.so
```

- 执行 php -m 查看是否加载成功

PHP部分安装参数
```sh
./configure 
--prefix=/usr/local/php 
--enable-fpm 
--enable-mbstring 
--with-curl 
--enable-sockets 
--with-openssl 
--with-libxml-dir 
--with-mcrypt
--with-mysql=mysqlnd 
--with-mysqli=mysqlnd 
--with-pdo-mysql=mysqlnd 
--enable-pcntl 
--enable-maintainer-zts // 线程安全
--with-zlib 
--with-mhash 
--enable-inline-optimization // 线程优化
```