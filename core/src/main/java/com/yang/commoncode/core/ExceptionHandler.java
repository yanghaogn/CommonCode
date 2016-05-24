package com.yang.commoncode.core;

import java.io.PrintWriter;
import java.io.StringWriter;
import java.io.Writer;

/**
 * Created by yanghao3 on 16-5-24.
 */
public class ExceptionHandler {
    public static void throwException () {
        int a = 1 / 0;
    }
    public static String getExceptionStack(Throwable throwable) {
        Writer result = new StringWriter();
        PrintWriter printWriter = new PrintWriter(result);
        throwable.printStackTrace(printWriter);
        return result.toString();
    }
    public static void main(String []args) {
        try {
            throwException();
        } catch (Throwable throwable) {
            String s = getExceptionStack(throwable);
            System.out.println(s);
        }
    }
}
