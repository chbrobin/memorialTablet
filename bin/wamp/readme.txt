1、常用运行库合集(360安全卫士搜索快速安装)

2、安装 Wampserver64
(1) 设置php.ini file_uploads = On //默认开启
upload_max_filesize = 512M
post_max_size = 512M
memory_limit = 512M

(2) 打开80端口
控制面板 ==> Windows 防火墙 ==> 高级设置 ==> 入站规则(右键) ==> 新建规则 ==> 规则类型 & 端口 ==> TCP & 特定本地端口 & 80 ==> 允许链接 ==> 域 & 专用 & 公用 ==> open 80 port & desc

2、初始化数据库
use mysql;
update mysql.user set authentication_string=password('XX01FghikkDFf') where user='root';
flush privileges;
quit

运行memorial_tablet_init.bat

3、设置服务访问路径
wamp ==> Apache ==> Alias directories ==> Add on alias
/memorialTablet/ => %MEMORIAL_TABLET_BIN_DIR%/wwwroot/
/memorialTabletAttachment/ => %MEMORIAL_TABLET_BIN_DIR%/data/attachement/

alias配置修改
Require local 后增加 Require all granted
Deny from all 后增加 Allow from all

4、数据库备份
创建定期任务 任务的名称起为“MySQL backup” ，点击“下一步”
选择“每天”，点击“下一天”
设置开始备份的时间，按实际的需要选择一个服务器负荷最小的时间，点击“下一步”
选择要启动的程序，选择 %MEMORIAL_TABLET_BIN_DIR%/bin/wamp/memorial_tablet_backup_tool.bat 文件
点击“完成”后，就能在计划任务列表中看到“Memorial tablet db backup”。

5、文件数据备份
安装FreeFileSync 同步 %MEMORIAL_TABLET_BIN_DIR%/data 目录

6、忘记mysql root密码
net start
net stop wampmysqld64

mysqld.exe -nt --skip-grant-tables

mysql -u root
UPDATE mysql.user SET authentication_string=PASSWORD('XX01FghikkDF') WHERE USER='root';
flush privileges;
quit