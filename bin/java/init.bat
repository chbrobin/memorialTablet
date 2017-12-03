rem copy ext to java home
xcopy "%cd%\jreext\rxtxParallel.dll" "%JAVA_HOME%\jre\bin\"
xcopy "%cd%\jreext\rxtxSerial.dll" "%JAVA_HOME%\jre\bin\"
xcopy "%cd%\jreext\RXTXcomm.jar" "%JAVA_HOME%\jre\lib\ext\"