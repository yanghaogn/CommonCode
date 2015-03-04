package com.yang.commoncode.core;

import java.net.InetAddress;
import java.net.UnknownHostException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

import org.apache.log4j.Logger;

/**
 * DBOperator为单例，负责client与MySQL服务器间的交互
 */
public enum DBOperator {

  INSTANCE;
  static private final Logger log = Logger.getLogger(DBOperator.class);
  private final String DB_DRIVER = "com.mysql.jdbc.Driver";
  private final String DB_USER = "ptload";
  private final String DB_PASSWORD = "tTnhYrcwQI";
  private final String COMM_DB_NAME = "ptmind_common";
  private final String LOCAL_DB_NAME = "ptmind_common_v2";
  private final String DB_PORT = "3306";
  private static String localIP = "127.0.0.1";
  private static String COMMON_DB_HOST = "192.168.1.12";
  private final String COMMON_DB_PORT = "3306";

  static {
    try {
      // 获取本机IP
      localIP = InetAddress.getLocalHost().getHostAddress().toString();
    } catch (UnknownHostException e) {
      log.error(e.getMessage());
      e.printStackTrace();
    }
  }

  public Connection getConnection() {
    Connection conn = null;
    StringBuffer dbURL = new StringBuffer(64);
    dbURL.append("jdbc:mysql://");
    dbURL.append(localIP);
    dbURL.append(":");
    dbURL.append(DB_PORT);
    dbURL.append("/");
    dbURL.append(LOCAL_DB_NAME);
    dbURL.append("?autoReconnect=true&characterEncoding=utf8");
    log.info(dbURL.toString());
    try {
      Class.forName(DB_DRIVER);
      conn = DriverManager.getConnection(dbURL.toString(), DB_USER, DB_PASSWORD);
    } catch (ClassNotFoundException e) {
      log.error("class not found !", e);
    } catch (SQLException e) {
      log.error("create db connection failed !", e);
      throw new RuntimeException(
          "create db connection failed !", e);
    }
    return conn;
  }

  public void executeSQL(Connection conn, String sql) throws Exception {
    Statement statement = null;
    try {
      statement = conn.createStatement();
      statement.execute(sql);
    } catch (SQLException e) {
      log.error("execute sql failed!", e);
      throw new Exception(e);
    } finally {
      if (statement != null) {
        try {
          statement.close();
        } catch (SQLException e) {
          log.warn(e);
        }
      }
    }
  }

  public void releaseConnection(Connection conn) {
    if (conn != null) {
      try {
        conn.close();
      } catch (SQLException e) {
        log.warn(e);
      }
    }
  }

  /**
   * 查询每次录入的数据量
   *
   * @param sql
   * @return
   * @throws Exception
   */
  public int queryRecordsCount(Connection conn, String sql) throws Exception {
    int count = 0;
    ResultSet rs = null;
    Statement statement = null;
    try {
      statement = conn.createStatement();
      rs = statement.executeQuery(sql);
      if (rs != null && rs.next()) {
        count = rs.getInt(1);
      }
    } catch (SQLException e) {
      log.error("execute sql failed!", e);
      throw new Exception();
    } finally {
      if (statement != null) {
        try {
          statement.close();
        } catch (SQLException e) {
          log.error(e);
        }
      }
    }
    return count;
  }

  public String getClientName(String hostIP) throws Exception {
    StringBuffer dbURL = new StringBuffer(64);
    Connection conn = null;
    Statement statement = null;
    ResultSet rs = null;
    String clientName = null;
    dbURL.append("jdbc:mysql://");
    dbURL.append(COMMON_DB_HOST);
    dbURL.append(":");
    dbURL.append(ConfigKey.COMMON_DB_PORT);
    dbURL.append("/");
    dbURL.append(COMM_DB_NAME);
    dbURL.append("?characterEncoding=utf8");
    Class.forName(DB_DRIVER);

    conn = DriverManager.getConnection(dbURL.toString(), DB_USER,
        DB_PASSWORD);
    String sql = "select hostname from balancer_host_info where hostwip='"
        + hostIP + "'";
    statement = conn.createStatement();
    rs = statement.executeQuery(sql);
    if (rs.next()) {
      clientName = rs.getString("hostname");
    }
    if (rs != null) {
      try {
        rs.close();
      } catch (SQLException e) {
        log.warn(e);
      }
    }
    if (statement != null) {
      try {
        statement.close();
      } catch (SQLException e) {
        log.warn(e);
      }
    }
    if (conn != null) {
      try {
        conn.close();
      } catch (SQLException e) {
        log.warn(e);
      }
    }
    return clientName;
  }
}
