package com.yang.commoncode.core;

import java.util.Collection;
import java.util.Properties;
import javax.mail.*;
import javax.mail.internet.*;

public class JMail {

  private static String selfEmail = "eagle_eye_ptthink@163.com";
  private static String password = "eagle_eye";
  private static String smtpHost = "smtp.163.com";

  public static class SMTPAuthenticator extends Authenticator {
    private static SMTPAuthenticator INSTANCE;
    private String name = JMail.selfEmail;
    private String password = JMail.password;

    private SMTPAuthenticator() {
    }

    public static SMTPAuthenticator getInstance() {
      if (INSTANCE == null) {
        synchronized (SMTPAuthenticator.class) {
          if (INSTANCE == null) {
            INSTANCE = new SMTPAuthenticator();
          }
        }
      }
      return INSTANCE;
    }
    @Override
    public PasswordAuthentication getPasswordAuthentication() {
      return new PasswordAuthentication(name, password);
    }
  }

  public static void sendMail(String title, String content, Collection<String> destEmails) throws AddressException, MessagingException {
    //sendMail(title,content,smtpHost,email,password,destEmail);
    Properties mailProps = new Properties();
    if (smtpHost.indexOf("smtp.gmail.com") >= 0) {
      mailProps.setProperty("mail.smtp.socketFactory.class",
          "javax.net.ssl.SSLSocketFactory");
      mailProps.setProperty("mail.smtp.socketFactory.fallback", "false");
      mailProps.setProperty("mail.smtp.port", "465");
      mailProps.setProperty("mail.smtp.socketFactory.port", "465");
    }
    String mail = content;
    mailProps.put("mail.smtp.host", smtpHost); //邮件服务器，需根据自己的邮箱地址来更改
    mailProps.put("mail.transport.protocol", "smtp");
    mailProps.put("mail.smtp.auth", "true");//需要验证
    SMTPAuthenticator smtpAuthenticator = SMTPAuthenticator.getInstance();
    Session mailSession = Session.getDefaultInstance(mailProps,
        smtpAuthenticator);
    // 创建message对象
    MimeMessage message = new MimeMessage(mailSession);
    // 设置发件人和收件人
    message.setFrom(new InternetAddress(selfEmail));
    for (String email : destEmails)
      message.addRecipient(Message.RecipientType.TO, new InternetAddress(
          email, false));
    message.setSubject(title);
    message.setText(mail);
    Transport.send(message);
  }

  public static void sendHtmlMail(String title, String content, Collection<String> destEmails)
      throws AddressException, MessagingException {
    // sendMail(title,content,smtpHost,email,password,destEmail);
    Properties mailProps = new Properties();
    if (smtpHost.indexOf("smtp.gmail.com") >= 0) {
      mailProps.setProperty("mail.smtp.socketFactory.class",
          "javax.net.ssl.SSLSocketFactory");
      mailProps.setProperty("mail.smtp.socketFactory.fallback", "false");
      mailProps.setProperty("mail.smtp.port", "465");
      mailProps.setProperty("mail.smtp.socketFactory.port", "465");
    }
    mailProps.put("mail.smtp.host", smtpHost); // 邮件服务器，需根据自己的邮箱地址来更改
    mailProps.put("mail.transport.protocol", "smtp");
    mailProps.put("mail.smtp.auth", "true");// 需要验证
    SMTPAuthenticator smtpAuthenticator = SMTPAuthenticator.getInstance();
    Session mailSession = Session.getDefaultInstance(mailProps, smtpAuthenticator);
    // 创建message对象
    MimeMessage message = new MimeMessage(mailSession);
    // 设置发件人和收件人
    message.setFrom(new InternetAddress(selfEmail));
    for (String email : destEmails)
      message.addRecipient(Message.RecipientType.TO, new InternetAddress(email, false));
    message.setSubject(title);
    //发送html
    Multipart mainPart = new MimeMultipart();
    BodyPart html = new MimeBodyPart();
    html.setContent(content, "text/html;charset=utf-8");
    mainPart.addBodyPart(html);
    message.setContent(mainPart);
    Transport.send(message);
  }
}
