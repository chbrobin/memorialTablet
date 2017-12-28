package com.shenhua.memorial.tablet.util;

import gnu.io.SerialPort;
import gnu.io.SerialPortEvent;
import gnu.io.SerialPortEventListener;
import org.apache.log4j.Logger;

/**
 * Created by chenhuibin on 2017/12/28 0028.
 */
public class SerialListener implements SerialPortEventListener {
    private static final Logger logger = Logger.getLogger(SerialListener.class);

    private SerialPort serialport;

    public SerialListener(SerialPort serialport) {
        this.serialport = serialport;
    }
    /**
     * 处理监控到的串口事件
     */
    public void serialEvent(SerialPortEvent serialPortEvent) {

        switch (serialPortEvent.getEventType()) {

            case SerialPortEvent.BI: // 10 通讯中断
//                    ShowUtils.errorMessage("与串口设备通讯中断");
                break;

            case SerialPortEvent.OE: // 7 溢位（溢出）错误

            case SerialPortEvent.FE: // 9 帧错误

            case SerialPortEvent.PE: // 8 奇偶校验错误

            case SerialPortEvent.CD: // 6 载波检测

            case SerialPortEvent.CTS: // 3 清除待发送数据

            case SerialPortEvent.DSR: // 4 待发送数据准备好了

            case SerialPortEvent.RI: // 5 振铃指示

            case SerialPortEvent.OUTPUT_BUFFER_EMPTY: // 2 输出缓冲区已清空
                break;

            case SerialPortEvent.DATA_AVAILABLE: // 1 串口存在可用数据
                byte[] data = null;
                try {
                    if (serialport == null) {
                    } else {
                        // 读取串口数据
                        data = SerialTool.readFromPort(serialport);
                        String hex = SerialTool.byte2Hex(data);
                        logger.info("serialport " + serialport.getName() + " return hex " + hex);
                    }
                } catch (Exception e) {
                    logger.error("serialport error ", e);
                }
                break;
        }
    }
}
