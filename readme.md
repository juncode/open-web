## 1. 基于thinkphp 3.2 开发
## 2. 欢迎加入研发

### 使用说明
> 在使用之前 ， 请详细阅读使用说明

1. 配置hosts，添加域名指向，例如本地开发环境配置：
    127.0.0.1   www.test.com
    127.0.0.1   admin.test.com

2. 配置apache，添加虚拟主机，例如本地开发环境配置：
    `<VirtualHost *:80>
        DocumentRoot "/var/www/html/"
        ServerName www.test.com
        ServerAlias *.test.com
        ErrorLog "logs/www.test.com-error.log"
        CustomLog "logs/www.test.com-access.log" combined
    </VirtualHost>`

    `<VirtualHost *:80>
        DocumentRoot "/var/www/html/"
        ServerName admin.test.com
        ServerAlias *.test.com
        ErrorLog "logs/www.test.com-error.log"
        CustomLog "logs/www.test.com-access.log" combined
    </VirtualHost>`

3. 可自定义在 Apps/Common/Conf/config.php 中，添加子域名配置，默认Home模块。

4. 如有问题，欢迎讨论，E-mail j@wonhsi.com