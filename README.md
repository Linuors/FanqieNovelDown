# FanqieNovelDown
番茄小说TXT下载PHP版本
====环境====
Nginx 1.22
PHP 8.0
MySQL 5.6
====安装====
1.上传文件到根目录，新建数据库并导入novel.sql文件
2.修改/api/config.php文件
3.修改/api/download.php第四行$path = "/www/wwwroot/211.101.233.5/api/";的$path中改为你的API目录
4.将PHP8.0最大运行时长调为2000s，否则下载小说时会跳502
自动化导入数据库自己写，我是fvv写不出来
