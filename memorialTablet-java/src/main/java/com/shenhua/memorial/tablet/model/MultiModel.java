package com.shenhua.memorial.tablet.model;

/**
 * Created by chenhuibin on 2017/10/17 0017.
 */
public class MultiModel {
    private String comPort;

    private Integer comModuleId;

    private Integer baudRate;

    private String flag;

    public String getComPort() {
        return comPort;
    }

    public void setComPort(String comPort) {
        this.comPort = comPort;
    }

    public Integer getBaudRate() {
        return baudRate;
    }

    public void setBaudRate(Integer baudRate) {
        this.baudRate = baudRate;
    }

    public String getFlag() {
        return flag;
    }

    public void setFlag(String flag) {
        this.flag = flag;
    }

    public Integer getComModuleId() {
        return comModuleId;
    }

    public void setComModuleId(Integer comModuleId) {
        this.comModuleId = comModuleId;
    }

    @Override
    public String toString() {
        return "ComModel => comPort: " + comPort + " comModuleId " + comModuleId + " baudRate:" + baudRate + " flag:" + flag;
    }
}
