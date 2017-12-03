package com.shenhua.memorial.tablet.util;

import org.apache.commons.lang.StringUtils;

/**
 * Created by chenhuibin on 2017/10/20 0020.
 */
public class SqlInit {
    public static void main(String[] args) {
        initTabletComData();
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

    public static void initTabletComData() {
        String[] ms = new String[]{
                "1|A|1|32",
                "1|B|2|32"
        };

        System.out.println("#########################");
        int id = 1;
        int currentTabletNum = 0;
        for(String m : ms) {
            String[] ss = StringUtils.split(m, "|");
            String comPort = ss[0];
            String abc = ss[1];
            int comModuleId = Integer.valueOf(ss[2]);
            int maxComModuleAddressId = Integer.valueOf(ss[3]);
            for(int comModuleAddressId = 0; comModuleAddressId < maxComModuleAddressId; comModuleAddressId ++){
                currentTabletNum = getNextTabletNumber(currentTabletNum);
                String tabletNumber = abc + currentTabletNum;
                System.out.println("UPDATE memorial_table " +
                        "set com_port = " + comPort + ", com_module_id = " + comModuleId + ", set com_module_address_id = " + comModuleAddressId + " tablet_number = " + tabletNumber +
                        " where id = " + id);
                id ++ ;
            }
        }
    }
}

