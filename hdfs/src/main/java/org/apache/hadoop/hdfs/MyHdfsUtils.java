package org.apache.hadoop.hdfs;


import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.*;
import org.apache.hadoop.io.IOUtils;
import org.apache.hadoop.util.Progressable;

import java.io.*;
import java.net.MalformedURLException;
import java.net.URI;
import java.net.URL;

/**
 * Created by yang on 2015/3/31.
 */
public class MyHdfsUtils {
  static {
    URL.setURLStreamHandlerFactory(new FsUrlStreamHandlerFactory());
  }

  public void catFile(String url) {
    InputStream in = null;
    try {
      in = new URL(url).openStream();
      IOUtils.copyBytes(in, System.out, 4096, false);
    } catch (MalformedURLException e) {
      e.printStackTrace();
    } catch (IOException e) {
      e.printStackTrace();
    } finally {
      IOUtils.closeStream(in);
    }
  }

  public void catFileByFileSystem(String url) {
    Configuration conf = new Configuration();
    FSDataInputStream in = null;
    try {
      FileSystem fs = FileSystem.get(URI.create(url), conf);
      in = fs.open(new Path(url));
      IOUtils.copyBytes(in, System.out, 4096, false);
      in.seek(0);
      IOUtils.copyBytes(in, System.out, 4096, false);
    } catch (IOException e) {
      e.printStackTrace();
    } finally {
      IOUtils.closeStream(in);
    }
  }

  public void copyWithProgress(String localSrc, String dst) {
    InputStream in = null;
    OutputStream out = null;
    try {
      in = new BufferedInputStream(new FileInputStream(localSrc));
      Configuration conf = new Configuration();
      FileSystem fs = null;

      fs = FileSystem.get(URI.create(dst), conf);
      out = fs.create(new Path(dst), new Progressable() {
        @Override
        public void progress() {
          System.out.print(".");
        }
      });
      IOUtils.copyBytes(in, out, 4096, false);
    } catch (IOException e) {
      e.printStackTrace();
    } finally {
      IOUtils.closeStream(in);
      IOUtils.closeStream(out);
    }
  }

  public void listStatus(String args[]) {
    try {
      Configuration conf = new Configuration();
      FileSystem fs = FileSystem.get(URI.create(args[0]), conf);
      Path[] paths = new Path[args.length];
      for (int i = 0; i < paths.length; i++) {
        paths[i] = new Path(args[i]);
      }
      FSDataOutputStream out;
      FileStatus[] status = fs.listStatus(paths);
      Path[] listedPaths = FileUtil.stat2Paths(status);
      for (Path path : listedPaths) {
        System.out.println(path);
      }
    } catch (FileNotFoundException e) {
      e.printStackTrace();
    } catch (IOException e) {
      e.printStackTrace();
    }
  }
}
