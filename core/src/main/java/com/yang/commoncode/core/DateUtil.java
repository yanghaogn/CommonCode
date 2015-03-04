package com.yang.commoncode.core;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.TimeZone;

/**
 * 日期处理工具类，主要根据时区、时间戳转时间或者根据时区、时间转时间戳以及字符串与时间之间的转换
 *
 * @author yanghao
 */
public class DateUtil {
  // 标准日期格式
  private static final String DATE_FORMAT = "yyyy-MM-dd HH:mm:ss";

  public static void main(String[] args) throws ParseException {
    // System.out.println(string2Date("2014-01-22 23:59:59").toString());

    System.out.println(System.currentTimeMillis());
  }

  /**
   * 根据预置的时区格式（例如：E08:00）返回标准时区格式（例如：GMT+08:00）
   *
   * @param origion
   * @return
   */
  private static String getTZStr(String origion) {
    StringBuilder s = new StringBuilder(32);
    s.append("GMT");//Jdk时区中没有空格
    if (origion.charAt(0) == 'E') {
      s.append("+");
    }
    if (origion.charAt(0) == 'W') {
      s.append("-");
    }
    s.append(origion.substring(1, origion.length()));
    return s.toString();
  }

  public static int getDateIntValue(String dateTime) throws ParseException {
    Date d = string2Date(dateTime);
    return Integer.parseInt(new SimpleDateFormat("yyyyMMdd").format(d));
  }

  /**
   * 根据时间戳和时区转换为时间对象
   */
  public static Date timestamp2Date(long timestamp, String timezone)
      throws ParseException {
    SimpleDateFormat dateFormatGmt = new SimpleDateFormat(DATE_FORMAT);
    dateFormatGmt.setTimeZone(TimeZone.getTimeZone(timezone));

    SimpleDateFormat dateFormatLocal = new SimpleDateFormat(DATE_FORMAT);

    return dateFormatLocal.parse(dateFormatGmt.format(new Date(timestamp)));
  }

  public static String getDelayStartTime(int hour, String timezone) {
    Calendar calendar = Calendar.getInstance();
    calendar.add(10, hour);
    SimpleDateFormat dateFormatGmt = new SimpleDateFormat(
        "yyyy-MM-dd HH:00:00");
    dateFormatGmt.setTimeZone(TimeZone.getTimeZone(timezone));
    return dateFormatGmt.format(calendar.getTime());
  }

  public static String getDelayTime(int hour, String date)
      throws ParseException {
    Calendar calendar = Calendar.getInstance();
    calendar.setTimeInMillis(string2Date(date).getTime());
    calendar.add(10, hour);
    SimpleDateFormat dateFormatGmt = new SimpleDateFormat(DATE_FORMAT);
    return dateFormatGmt.format(calendar.getTime());
  }

  public static String getDelayEndTime(int hour, String timezone) {
    Calendar calendar = Calendar.getInstance();
    calendar.add(10, hour);
    SimpleDateFormat dateFormatGmt = new SimpleDateFormat(
        "yyyy-MM-dd HH:59:59");
    dateFormatGmt.setTimeZone(TimeZone.getTimeZone(timezone));
    return dateFormatGmt.format(calendar.getTime());
  }

  public static String getDayStartTime(int off, String timezone) {
    Calendar calendar = Calendar.getInstance();
    calendar.add(5, off);
    SimpleDateFormat dateFormatGmt = new SimpleDateFormat(
        "yyyy-MM-dd 00:00:00");
    dateFormatGmt.setTimeZone(TimeZone.getTimeZone(timezone));
    return dateFormatGmt.format(calendar.getTime());
  }

  public static String getDayEndTime(int off, String timezone) {
    Calendar calendar = Calendar.getInstance();
    calendar.add(5, off);
    SimpleDateFormat dateFormatGmt = new SimpleDateFormat(
        "yyyy-MM-dd 23:59:59");
    dateFormatGmt.setTimeZone(TimeZone.getTimeZone(timezone));
    return dateFormatGmt.format(calendar.getTime());
  }

  /*
   * 根据时间戳和时区，转换为对应时区时间的字符串
   */
  public static String getTimeStrByTimestamp(long timestamp, String tz) {
    StringBuilder timezone = new StringBuilder(10);
    for (int i = 0; i < tz.length(); i++)
      if (tz.charAt(i) != ' ')
        timezone.append(tz.charAt(i));
    Calendar calendar = Calendar.getInstance();
    calendar.setTimeInMillis(timestamp);
    SimpleDateFormat dateFormatGmt = new SimpleDateFormat(DATE_FORMAT);
    dateFormatGmt.setTimeZone(TimeZone.getTimeZone(timezone.toString()));
    return dateFormatGmt.format(calendar.getTime());
  }

  public static String getDateTimeStrByTZ(String tzStr) {
    SimpleDateFormat dateFormatGmt = new SimpleDateFormat(DATE_FORMAT);
    dateFormatGmt.setTimeZone(TimeZone.getTimeZone(tzStr));
    return dateFormatGmt.format(new Date());
  }

  public static long getDefaultRawOffset() {
    return TimeZone.getDefault().getRawOffset();
  }

  public static long getRawOffset(String timeZoneStr) {
    return TimeZone.getTimeZone(timeZoneStr).getRawOffset();
  }

  public static String timestamp2DataTime(long timestamp) {
    SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
    return sdf.format(Long.valueOf(timestamp));
  }

  public static long string2Timestamp(String dateString, String timezone)
      throws ParseException {
    SimpleDateFormat df = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
    if ((timezone != null) && (!timezone.equals(""))) {
      df.setTimeZone(TimeZone.getTimeZone(timezone));
    }
    Date date1 = df.parse(dateString);
    long temp = date1.getTime();
    return temp;
  }

  public static Date string2Date(String dateString) throws ParseException {
    return new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").parse(dateString);
  }

  public static String date2String(Date date) {
    return new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(date);
  }

  public static String getDefaultTZStr() {
    SimpleDateFormat dateFormat = new SimpleDateFormat("Z");
    StringBuilder sb = new StringBuilder("GMT");
    sb.append(dateFormat.format(new Date()));
    return sb.toString();
  }

  public static String getToday() {
    return new SimpleDateFormat("yyyy-MM-dd").format(new Date());
  }

  /**
   * 获取指定开始时间和结束时间之间的相差时间（单位：天）
   *
   * @param startDate
   * @param endDate
   * @return
   */
  public static int getDayBetween(Date startDate, Date endDate) {
    Calendar start = Calendar.getInstance();
    start.setTimeInMillis(startDate.getTime());
    Calendar end = Calendar.getInstance();
    end.setTimeInMillis(endDate.getTime());
    if (start.after(end)) {
      Calendar swap = start;
      start = end;
      end = swap;
    }
    int days = end.get(Calendar.DAY_OF_YEAR)
        - start.get(Calendar.DAY_OF_YEAR);
    int y2 = end.get(Calendar.YEAR);
    if (start.get(Calendar.YEAR) != y2) {
      start = (Calendar) start.clone();
      do {
        days += start.getActualMaximum(Calendar.DAY_OF_YEAR);
        start.add(Calendar.YEAR, 1);
      } while (start.get(Calendar.YEAR) != y2);
    }
    return days;
  }

  /**
   * 格式化时区，将GMT +08:00格式转化为E0800
   *
   * @param timezone
   * @return
   */
  public static String formatTZ(String timezone) {
    String tz = timezone.split("\\ ")[1].replace(":", "");
    if ("+".equals(tz.substring(0, 1))) {
      return tz.replace("+", "E");
    } else if ("-".equals(tz.substring(0, 1))) {
      return tz.replace("-", "W");
    } else {
      return "";
    }
  }

}
