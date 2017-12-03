rem auther:chenhuibin
rem date:20171014
rem ******MySQL backup start********
@echo off


set "Ymd=%date:~0,4%%date:~5,2%%date:~8,2%0%time:~1,1%%time:~3,2%%time:~6,2%"
C:\wamp64\bin\mysql\mysql5.7.19\bin\mysqldump --opt --single-transaction=TRUE --user=root --password=XX01FghikkDF --host=127.0.0.1 --protocol=tcp --port=3306 --default-character-set=utf8 --single-transaction=TRUE --routines --events "memorial_tablet" > ../../data/mysql-backup/memorial_tablet_backup_%Ymd%.sql

cd ../../data/mysql-backup
echo forfiles %cd%
forfiles /p "%cd%" /m memorial_tablet_backup_*.sql -d -30 /c "cmd /c del /f @path"

cd ../../bin/wamp
@echo on
rem ******MySQL backup end********