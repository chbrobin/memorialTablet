package com.shenhua.memorial.tablet.controller;

import com.shenhua.memorial.tablet.model.ComModel;
import com.shenhua.memorial.tablet.model.ComResult;
import com.shenhua.memorial.tablet.util.ComDataUtil;
import org.apache.log4j.Logger;
import org.apache.tomcat.util.codec.binary.StringUtils;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.bind.annotation.RestController;

import java.util.Timer;
import java.util.TimerTask;

/**
 * Created by Administrator on 2017/10/14 0014.
 */
@RestController
@SpringBootApplication
public class ComController {
    private static final Logger logger = Logger.getLogger(ComController.class);

    @RequestMapping("/")
    @ResponseBody
    public ComResult index(ComModel model) throws Exception {
        ComResult comResult = new ComResult();
        try {
            logger.info("index run param " + model.toString());
            // 开关灯处理
            String msg = ComDataUtil.sendComData(model);
            if(msg != null && !"".equals(msg)) {
                comResult.setCode(-1);
                comResult.setMessage(msg);
                return comResult;
            }

            // 如果开类，一段时间后自动关灯
            if ("on".equals(model.getFlag()) && model.getCloseDelayTime() != null && model.getCloseDelayTime() > 0) {
                Timer timer = new Timer();
                ComModel closeComModel = new ComModel();
                closeComModel.setBaudRate(model.getBaudRate());
                closeComModel.setCloseDelayTime(model.getCloseDelayTime());
                closeComModel.setComModuleAddress(model.getComModuleAddress());
                closeComModel.setComModuleId(model.getComModuleId());
                closeComModel.setComPort(model.getComPort());
                closeComModel.setFlag("off");
                logger.warn("index deplayTime empty param " + model.toString());
                timer.schedule(new CloseComTask(closeComModel), model.getCloseDelayTime());
            }
            return comResult;
        } catch (Exception e){
            logger.error("index run error", e);
            comResult.setCode(-1);
            comResult.setMessage("串口通信异常！");
            return comResult;
        }
    }

    public static void main(String[] args) {
        SpringApplication.run(ComController.class, args);
    }
}

class CloseComTask extends TimerTask {
    private static final Logger logger = Logger.getLogger(ComController.class);
    public CloseComTask(ComModel comModel) {
        this.closeComModel = comModel;
    }
    ComModel closeComModel;
    @Override
    public void run() {
        try {
            logger.info("CloseComTask run param " + closeComModel.toString());
            ComDataUtil.sendComData(closeComModel);
            ComDataUtil.sendComData(closeComModel);
            ComDataUtil.sendComData(closeComModel);
        } catch (Exception e) {
            logger.error("CloseComTask run error" ,e);
        }

    }
}