package com.shenhua.memorial.tablet.test;

import com.fasterxml.jackson.annotation.JsonFormat;
import com.fasterxml.jackson.annotation.JsonValue;
import com.fasterxml.jackson.core.json.ReaderBasedJsonParser;
import com.shenhua.memorial.tablet.model.ComModel;
import net.sf.json.JSONObject;

import java.io.ByteArrayOutputStream;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Random;

/**
 * Created by chenhuibin on 2017/10/27 0027.
 */
public class BatchRequestTest {
    private final static String TABLET_URL = "http://127.0.0.1/memorialTablet/lighten.php";
    private final static String COM_URL = "http://127.0.0.1:8080/";
    public static void testPostComData() throws Exception {
        for(int j =9; j <= 9; j++) {
            for(int i = 0; i < 32; i ++) {
                ComModel comModel = new ComModel();
                comModel.setComPort("COM" + j);
                comModel.setBaudRate(19200);
                comModel.setComModuleId(j);
                comModel.setComModuleAddress(i);
                comModel.setFlag("on");
                comModel.setCloseDelayTime(5000000L);
                postComData(comModel);
                postComData(comModel);
                postComData(comModel);
                Thread.sleep(350l);
            }
        }
    }
    public static void main(String[] args) throws Exception {
        int flag = 1;
        if(flag == 1) {
            testPostComData();
        } else if(flag == 2) {
            testPostTabletData();
        }
    }

    public static void testPostTabletData() throws Exception {
        for(long i = 1; i < 2000; i ++) {
            postTabletData(i,"on");
            Thread.sleep(1000);
        }
    }

    public static void postTabletData(Long id, String flag) {
        Long t1 = System.currentTimeMillis();
        String param = "id=" + id + "&flag=" + flag;
        String result = getRequestByPost(TABLET_URL,param, "utf8");
        JSONObject resultJo = JSONObject.fromObject(result);
        System.out.println("postTabletData param" + param + " result " + resultJo + " spends " + (System.currentTimeMillis() - t1));
    }



    public static void postComData(ComModel comModel) {
        Long t1 = System.currentTimeMillis();
        String param = "comPort=" + comModel.getComPort() + "&baudRate=" + comModel.getBaudRate() + "&comModuleId=" + comModel.getComModuleId()
                +"&comModuleAddress=" + comModel.getComModuleAddress() + "&flag=" + comModel.getFlag() + "&closeDelayTime=" + comModel.getCloseDelayTime();
        String result = getRequestByPost(COM_URL,param, "utf8");
        System.out.println("postComData param" + param + " result " + result + " spends " + (System.currentTimeMillis() - t1));
    }

    public static String decodeUnicode(final String dataStr) {
        int start = 0;
        int end = 0;
        final StringBuffer buffer = new StringBuffer();
        while (start > -1) {
            end = dataStr.indexOf("\\u", start + 2);
            String charStr = "";
            if (end == -1) {
                charStr = dataStr.substring(start + 2, dataStr.length());
            } else {
                charStr = dataStr.substring(start + 2, end);
            }
            char letter = (char) Integer.parseInt(charStr, 16); // 16进制parse整形字符串。
            buffer.append(new Character(letter).toString());
            start = end;
        }
        return buffer.toString();
    }

    public static String getRequestByPost(String u, String postParam, String encoding) {
        if (u == null) {
            throw new RuntimeException("无效的路径");
        }
        try {
            URL url = new URL(u);
            HttpURLConnection httpURLConnection = (HttpURLConnection) url
                    .openConnection();
            httpURLConnection.setDoOutput(true);
            httpURLConnection.setRequestProperty("User-agent","Mozilla/4.0");
            httpURLConnection.setRequestMethod("POST");
            httpURLConnection.setReadTimeout(40000);

            if (postParam != null && !postParam.equals("")) {
                OutputStream os = httpURLConnection.getOutputStream();
                os.write(postParam.getBytes());
                os.close();
            }

            httpURLConnection.connect();

            InputStream inputStream = (InputStream) httpURLConnection
                    .getInputStream();

            ByteArrayOutputStream bops = new ByteArrayOutputStream();
            int count = 0;
            byte[] b = new byte[1024];
            while ((count = inputStream.read(b)) != -1) {
                bops.write(b, 0, count);
            }
            inputStream.close();

            httpURLConnection.disconnect();

            return new String(bops.toByteArray(), 0, bops.size(), encoding);
        } catch (Exception e) {
            throw new RuntimeException("获取给定的资源失败:" + e, e);
        }
    }
}