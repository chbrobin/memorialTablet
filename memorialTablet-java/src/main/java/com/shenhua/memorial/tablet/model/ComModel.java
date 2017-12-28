package com.shenhua.memorial.tablet.model;

/**
 * Created by chenhuibin on 2017/10/17 0017.
 */
public class ComModel {
    private String comPort;

    private Integer baudRate;

    private Integer comModuleId;

    private Integer comModuleAddress;

    private String flag;

    private Long closeDelayTime;

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

    public Integer getComModuleId() {
        return comModuleId;
    }

    public void setComModuleId(Integer comModuleId) {
        this.comModuleId = comModuleId;
    }

    public Integer getComModuleAddress() {
        return comModuleAddress;
    }

    public void setComModuleAddress(Integer comModuleAddress) {
        this.comModuleAddress = comModuleAddress;
    }

    public String getFlag() {
        return flag;
    }

    public void setFlag(String flag) {
        this.flag = flag;
    }

    public Long getCloseDelayTime() {
        return closeDelayTime;
    }

    public void setCloseDelayTime(Long closeDelayTime) {
        this.closeDelayTime = closeDelayTime;
    }

    @Override
    public String toString() {
        return "ComModel => comPort: " + comPort + " baudRate:" + baudRate + " comModuleId:" + comModuleId
                + " comModuleAddress:" + comModuleAddress + " flag:" + flag + " closeDelayTime:" + closeDelayTime;
    }
}
