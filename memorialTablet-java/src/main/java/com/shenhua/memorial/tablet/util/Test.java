package com.shenhua.memorial.tablet.util;

/**
 * Created by Administrator on 2017/11/25 0025.
 */
/**
 * 重载了info方法的Test类
 * @ClassName: Test
 * @author 小学徒
 * @date 2013-3-27
 */
public class Test{

    //info方法一
    public void info(Object o, double count) {
        System.out.println("object o");
    }

    //info方法二
    public void info(Object[] o, double count) {
        System.out.println("object[] o");
    }
    public static void main(String[] args) {
        //我们看看，如果第一个形参为null，他到底会匹配哪一个方法呢？
        new Test().info(null, 0);
    }
}
