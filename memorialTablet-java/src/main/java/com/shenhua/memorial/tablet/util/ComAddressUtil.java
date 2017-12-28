package com.shenhua.memorial.tablet.util;

/**
 * Created by chenhuibin on 2017/10/17 0017.
 * 主机发送《Y0闭合》：01 05 00 00 FF 00 8C 3A 《Modbus RTU》
 * 主机发送《Y0断开》：01 05 00 00 00 00 CD CA 《Modbus RTU》
 */
public class ComAddressUtil {
    public static void main(String[] args) {
        String hex = genHexAddress(1,0,1);
        System.out.println(hex);
    }

    // 01 05 00 00 FF 00 8C 3A
    public static String genHexAddress(int moduleId, int moduleAddress, int flag) {
        // 模块地址 MODULE_ID
        String moduleIdStr = Integer.toHexString(moduleId);
        String hex1 = moduleIdStr.length() > 1 ? moduleIdStr : "0" + moduleIdStr;

        // 功能码 写寄存器<WRITE_1_COIL>
        String hex2 = "05";

        // 寄存器地址 MODULE_AD
        String moduleAddressStr = Integer.toHexString(moduleAddress);
        String hex3 = "00" + (moduleAddressStr.length() > 1 ? moduleAddressStr : "0" + moduleAddressStr);

        // 写入数据 FF00H：表示YO闭合 0000H：表示YO断开
        String hex4 = flag == 1 ? "ff00" : "0000";

        // CRC校验
        String hex5 = Make_CRC(HexString2Bytes(hex1 + hex2 + hex3 + hex4));
        return (hex1 + hex2 + hex3 + hex4 + hex5).toUpperCase();
    }

    // 01 05 00 00 FF 00 8C 3A
    public static String genMultiHexAddress(int moduleId, int flag) {
        // 从机地址
        String moduleIdStr = Integer.toHexString(moduleId);
        String hex1 = moduleIdStr.length() > 1 ? moduleIdStr : "0" + moduleIdStr;

        // 写寄存器 10H 固定
        String hex2 = "10";

        // 起始寄存器地址 8050H固定
        String hex3 = "8050";

        // 控制继电器数量 0002H固定
        String hex4 = "0002";

        // 写入字节个数 04H固定
        String hex5 = "04";

        // 写入数据1~4
        String hex6 = flag == 1 ? "02010804" : "02010804";

        // CRC校验
        String hex7 = Make_CRC(HexString2Bytes(hex1 + hex2 + hex3 + hex4 + hex5 + hex6));
        return (hex1 + hex2 + hex3 + hex4 + hex5 + hex6 + hex7).toUpperCase();
    }

    public static byte[] HexString2Bytes(String hexstr) {
        byte[] b = new byte[hexstr.length() / 2];
        int j = 0;

        for (int i = 0; i < b.length; i++) {
            char c0 = hexstr.charAt(j++);
            char c1 = hexstr.charAt(j++);

            b[i] = (byte) ((parse(c0) << 4) | parse(c1));
        }

        return b;
    }

    public static String Make_CRC(byte[] data) {
        byte[] buf = new byte[data.length];// 存储需要产生校验码的数据
        for (int i = 0; i < data.length; i++) {
            buf[i] = data[i];
        }
        int len = buf.length;
        int crc = 0xFFFF;//16位
        for (int pos = 0; pos < len; pos++) {
            if (buf[pos] < 0) {
                crc ^= (int) buf[pos] + 256; // XOR byte into least sig. byte of
                // crc
            } else {
                crc ^= (int) buf[pos]; // XOR byte into least sig. byte of crc
            }
            for (int i = 8; i != 0; i--) { // Loop over each bit
                if ((crc & 0x0001) != 0) { // If the LSB is set
                    crc >>= 1; // Shift right and XOR 0xA001
                    crc ^= 0xA001;
                } else
                    // Else LSB is not set
                    crc >>= 1; // Just shift right
            }
        }
        String c = Integer.toHexString(crc);
        if (c.length() == 4) {
            c = c.substring(2, 4) + c.substring(0, 2);
        } else if (c.length() == 3) {
            c = "0" + c;
            c = c.substring(2, 4) + c.substring(0, 2);
        } else if (c.length() == 2) {
            c = "0" + c.substring(1, 2) + "0" + c.substring(0, 1);
        }
        return c;
    }

    private static int parse(char c) {
        if (c >= 'a'){
            return (c - 'a' + 10) & 0x0f;
        }

        if (c >= 'A'){
            return (c - 'A' + 10) & 0x0f;
        }

        return (c - '0') & 0x0f;
    }
}
