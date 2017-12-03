package com.shenhua.memorial.tablet.util;

import com.shenhua.memorial.tablet.model.ComModel;
import gnu.io.NoSuchPortException;
import gnu.io.PortInUseException;
import gnu.io.SerialPort;
import gnu.io.UnsupportedCommOperationException;
import org.apache.log4j.Logger;

import java.io.IOException;
import java.io.OutputStream;
import java.util.List;

/**
 * Created by Administrator on 2017/10/15 0015.
 */
public class ComDataUtil {
    private static final Logger logger = Logger.getLogger(ComDataUtil.class);

    public synchronized static String sendComData(ComModel model) throws Exception{
        logger.info("sendComData model " + model.toString());
        String message = "";
        if("on".equals(model.getFlag())) {
            message = ComAddressUtil.genHexAddress(model.getComModuleId(), model.getComModuleAddress(),1);
        } else if("off".equals(model.getFlag())) {
            message = ComAddressUtil.genHexAddress(model.getComModuleId(), model.getComModuleAddress(),0);
        }
        System.out.println("sendComData message " + message);
        try {
            SerialPort serialPort = SerialTool.openPort(model.getComPort(),model.getBaudRate());
            SerialTool.sendToPort(serialPort, SerialTool.hex2byte(message));
            SerialTool.closePort(serialPort);
            /**
            if(bytes == null) {
                logger.info("sendComData error bytes null");
//                return "串口("+model.getComPort() + "-" + model.getComModuleId() + "-" + model.getComModuleAddress() +")通讯异常";
            } else {
                String hexStr = SerialTool.byte2Hex(bytes);
                if(!message.equals(hexStr)) {
                    logger.info("sendComData error message " + message + " hexStr " + hexStr);
//                return "串口("+model.getComPort() + "-" + model.getComModuleId() + "-" + model.getComModuleAddress() +")通讯异常";
                }
            }
             */
        } catch (PortInUseException e1) {
            logger.error("sendComData PortInUseException", e1);
            return "COM端口("+model.getComPort()+")被占用";
        } catch (NoSuchPortException e2) {
            logger.error("sendComData NoSuchPortException", e2);
            return "COM端口("+model.getComPort()+")不存在";
        } catch (UnsupportedCommOperationException e3) {
            logger.error("sendComData UnsupportedCommOperationException", e3);
            return "COM端口("+model.getComPort()+")非法操作";
        } catch (Exception e4) {
            logger.error("sendComData Exception", e4);
            return "COM端口("+model.getComPort()+")未知异常";
        } catch (Error er) {
            logger.error("sendComData error", er);
            return "串口通讯连接错误：" + er.getMessage();
        }
        return "";
    }
}