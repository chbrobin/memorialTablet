package com.shenhua.memorial.tablet.util;

import org.apache.commons.lang.StringUtils;

/**
 * Created by chenhuibin on 2017/10/20 0020.
 */
public class SqlInit {
    public static void main(String[] args) {

    }

    public static void initTablet() {
        for (int i = 1; i < 2001; i++) {
            String sql = "INSERT INTO memorial_tablet(id,create_time,update_time) VALUES(" + i + ", '2017-11-01 00:00:00', '2017-11-01 00:00:00');";
            System.out.println(sql);
        }
    }

    public static int getNextTabletNumber(int currentNumber) {
        boolean flag = true;
        while (flag) {
            currentNumber ++;
            String currentNumberString = String.valueOf(currentNumber);
            if(currentNumberString.indexOf("4") == -1
                && currentNumberString.indexOf("4") == -1
                    ) {
                return currentNumber;
            }
        }
        return currentNumber;
    }
}

