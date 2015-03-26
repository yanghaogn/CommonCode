package com.yang.commoncode.core;

import java.io.File;
import java.lang.reflect.Method;
import java.net.URL;
import java.net.URLClassLoader;

public class DynamicClassLoader {
  private static URLClassLoader urlClassLoader = (URLClassLoader) ClassLoader.getSystemClassLoader();
  private static Method addURLMethod = initAddMethod();

  private static Method initAddMethod() {
    Method addURL = null;
    try {
      addURL = URLClassLoader.class.getDeclaredMethod("addURL", new Class[]{URL.class});
      addURL.setAccessible(true);
    } catch (Exception e) {
      e.printStackTrace();
    }
    return addURL;
  }

  public static void loadJarFiles(String filePath) {
    File file = new File(filePath);
    loopFiles(file);
  }

  private static void loopFiles(File file) {
    if (file.isDirectory()) {
      File[] childFileArray = file.listFiles();
      for (File tmp : childFileArray) {
        loopFiles(tmp);
      }
    } else {
      if (file.getAbsolutePath().endsWith(".jar")) {
        addURL(file);
      }
    }
  }

  public static void loadResourceDir(String filePath) {
    File file = new File(filePath);
    loopDirs(file);
  }

  private static void loopDirs(File file) {
    if (file.isDirectory()) {
      addURL(file);
      File[] childFileArray = file.listFiles();
      for (File tmp : childFileArray) {
        loopDirs(tmp);
      }
    }
  }

  private static void addURL(File file) {
    try {
      addURLMethod.invoke(urlClassLoader, new Object[]{file.toURI().toURL()});
    } catch (Exception e) {
      e.printStackTrace();
    }
  }
}