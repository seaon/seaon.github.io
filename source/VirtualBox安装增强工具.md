---
name: install-VirtualBox-Guest-Additions
title: VirtualBox安装增强工具
date: 2017-10-19
---
# VirtualBox设置共享文件夹

## 准备工作
    ```
    yum update
    yum install -y gcc
    yum install -y kernel-devel 
    yum -y install bzip2 bzip2-devel # 运行增强工具时需要
    
    reboot # 重启使安装生效。
    ```


## 配置共享文件夹

    在虚拟机的设置界面中添加要共享的文件夹。
    需要注意的是自动挂载和固定分配最好都点上，不然每次虚拟机关机后都要手动再mount，而只读分配最好不要选择，不然在虚拟机中无法写入。

## 挂载光盘
    在virtualbox虚拟机窗口的菜单条下选择 "设备"--"安装增强功能"，相当于在 CentOS 虚拟机中插入了 GuestAddition 的光盘。
    
    mount -t auto /dev/cdrom /mnt
    cd /mnt
    ./VBoxLinuxAdditions.run
    安装 GuestAddition。

再次重启，在/media目录下你会发现一个文件夹，这就是你的共享文件夹，文件夹名称为` sf_ `加上你在设置共享文件夹时填写的共享文件夹名称。