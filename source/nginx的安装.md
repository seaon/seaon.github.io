---
name: install-nginx
title: nginx的安装
date: 2016-10-29
---
### 在一个最小化安装的CentOS上安装nginx服务器所遇到的问题：

1. 获取IP地址，发现 `ifconfig` 命令不存在，需要安装`net-tools`，执行`yum -y install net-tools`，便可安装成功。
2. 用获取到的IP地址连接服务器，个人推荐使用putty工具，使用`wget`命令下载nginx，该命令不存在，执行`yum -y install wget`安装。
3. 下载nginx安装包，执行`wget http://nginx.org/download/nginx-1.8.1.tar.gz`，下载完成后`tar zxvf nginx-1.8.1.tar.gz`解压文件。
4. 切换到解压好的文件目录下，可以通过`./configure --prefix=/usr/local/nginx` 来配置安装目录，或者不执行，直接默认安装。
5. 执行`make && make install`，编译安装nginx。

在执行`./configure --prefix=/usr/local/nginx`时，出现了以下错误：
*   `./configure: error: C compiler cc is not found`错误，是因为没有安装C的编译器，执行`yum -y install gcc`命令，安装gcc编译器。
*   `./configure: error: the HTTP rewrite module requires the PCRE library`错误，执行`yum -y install pcre-devel`命令解决错误。
*   `./configure: error: the HTTP gzip module requires the zlib library`错误，执行`yum -y install zlib-devel`命令解决错误。

### 查看是否安装成功

1. 启动，确保系统的 80，端口没被其他程序占用，`/usr/local/nginx/sbin/nginx`。检查是否启动成功：`ps -ef | grep nginx `，有结果输入说明启动成功。或打开浏览器访问服务器的 IP，如果浏览器出现 *Welcome to nginx!* 则表示 nginx已经安装并运行成功。
2. 重启，`/usr/local/nginx/sbin/nginx –s reload` 
其他操作：从容停止`Nginx：kill -QUIT` 
主进程号快速停止`Nginx：kill -TERM 主进程号`
强制停止`Nginx：pkill -9 nginx`

