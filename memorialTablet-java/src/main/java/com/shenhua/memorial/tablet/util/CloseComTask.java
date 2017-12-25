package com.shenhua.memorial.tablet.util;

import com.shenhua.memorial.tablet.model.ComModel;
import org.apache.log4j.Logger;

import java.util.TimerTask;

/**
 * Created by chenhuibin on 2017/12/25 0025.
 */
public class CloseComTask extends TimerTask {
    private static final Logger logger = Logger.getLogger(CloseComTask.class);

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
