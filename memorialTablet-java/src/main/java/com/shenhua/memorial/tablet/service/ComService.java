package com.shenhua.memorial.tablet.service;

import com.shenhua.memorial.tablet.model.ComModel;
import com.shenhua.memorial.tablet.model.ComResult;
import com.shenhua.memorial.tablet.model.MultiModel;
import com.shenhua.memorial.tablet.util.CloseComTask;
import com.shenhua.memorial.tablet.util.ComDataUtil;
import org.apache.log4j.Logger;

import java.util.HashMap;
import java.util.Map;
import java.util.Timer;
import java.util.concurrent.Executors;
import java.util.concurrent.ScheduledExecutorService;
import java.util.concurrent.TimeUnit;

/**
 * Created by chenhuibin on 2017/12/25 0025.
 */
public class ComService {
    private static final Logger logger = Logger.getLogger(ComService.class);

    private static ComService comService = null;

    private static ScheduledExecutorService scheduledExecutorService;

    static {
        //在该类被ClassLoader加载时就初始化一个ComService对象
        if (comService == null) {
            comService = new ComService();
        }
        if(scheduledExecutorService == null) {
            scheduledExecutorService = Executors.newScheduledThreadPool(1024);
        }
    }

    //私有化SerialTool类的构造方法，不允许其他类生成ComService对象
    private ComService() {}
    /**
     * 获取提供服务的SerialTool对象
     * @return serialTool
     */
    public static ComService getInstance() {
        if (comService == null) {
            comService = new ComService();
        }
        return comService;
    }

    public static ScheduledExecutorService getScheduledExecutorService() {
        if (scheduledExecutorService == null) {
            scheduledExecutorService = Executors.newScheduledThreadPool(1024);
        }
        return scheduledExecutorService;
    }

    private static Map<String, ComModel> closeComModelMap = new HashMap<String, ComModel>();

    public ComResult comControl(ComModel model) {
        ComResult comResult = new ComResult();
        try {
            logger.info("comControl run param " + model.toString());
            // 开关灯处理
            String msg = ComDataUtil.sendComData(model);
            if(msg != null && !"".equals(msg)) {
                comResult.setCode(-1);
                comResult.setMessage(msg);
                return comResult;
            }

            // 如果开类，一段时间后自动关灯
            // 对所有关灯任务进行缓存
            if ("on".equals(model.getFlag()) && model.getCloseDelayTime() != null && model.getCloseDelayTime() > 0) {
                String key = model.getComPort() + "_" + model.getComModuleId() + "_" + model.getComModuleAddress();
                ComModel closeComModel = closeComModelMap.get(key);
                if(closeComModel == null) {
                    closeComModel = new ComModel();
                }

                closeComModel.setBaudRate(model.getBaudRate());
                closeComModel.setCloseDelayTime(model.getCloseDelayTime());
                closeComModel.setComModuleAddress(model.getComModuleAddress());
                closeComModel.setComModuleId(model.getComModuleId());
                closeComModel.setComPort(model.getComPort());
                closeComModel.setFlag("off");

                ScheduledExecutorService scheduledExecutorService = getScheduledExecutorService();
                scheduledExecutorService.schedule(new CloseComTask(closeComModel),model.getCloseDelayTime(), TimeUnit.MILLISECONDS);

                logger.warn("comControl deplayTime param " + model.toString());
                closeComModelMap.put(key, closeComModel);
            }
            return comResult;
        } catch (Exception e){
            logger.error("index run error", e);
            comResult.setCode(-1);
            comResult.setMessage("串口通信异常！");
            return comResult;
        }
    }

    public ComResult multiControl(MultiModel model) {
        ComResult comResult = new ComResult();
        try {
            logger.info("multiControl run param " + model.toString());
            // 开关灯处理
            String msg = ComDataUtil.sendMultiData(model);
            if(msg != null && !"".equals(msg)) {
                comResult.setCode(-1);
                comResult.setMessage(msg);
                return comResult;
            }
            return comResult;
        } catch (Exception e){
            logger.error("index run error", e);
            comResult.setCode(-1);
            comResult.setMessage("串口通信异常！");
            return comResult;
        }
    }
}