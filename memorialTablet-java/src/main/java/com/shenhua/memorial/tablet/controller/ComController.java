package com.shenhua.memorial.tablet.controller;

import com.shenhua.memorial.tablet.model.ComModel;
import com.shenhua.memorial.tablet.model.ComResult;
import com.shenhua.memorial.tablet.model.MultiModel;
import com.shenhua.memorial.tablet.service.ComService;
import org.apache.log4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
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
        ComService comService = ComService.getInstance();
        ComResult comResult = comService.comControl(model);
        return comResult;
    }


    @RequestMapping("/multi")
    @ResponseBody
    public ComResult multi(MultiModel model) throws Exception {
        ComService comService = ComService.getInstance();
        ComResult comResult = comService.multiControl(model);
        return comResult;
    }

    public static void main(String[] args) {
        SpringApplication.run(ComController.class, args);
    }
}