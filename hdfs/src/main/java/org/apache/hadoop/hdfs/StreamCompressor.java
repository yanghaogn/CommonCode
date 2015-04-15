package org.apache.hadoop.hdfs;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.io.IOUtils;
import org.apache.hadoop.io.compress.CompressionCodec;
import org.apache.hadoop.io.compress.CompressionOutputStream;
import org.apache.hadoop.util.ReflectionUtils;

import java.io.IOException;

/**
 * Created by yang on 2015/3/31.
 */
public class StreamCompressor {
  public static void main(String[] args) {
    try {
      args = new String[]{"org.apache.hadoop.io.compress.GzipCodec"};
      String codecClassname = args[0];
      Class<?> codecClass = Class.forName(codecClassname);
      Configuration conf = new Configuration();
      CompressionCodec codec = (CompressionCodec) ReflectionUtils.newInstance(codecClass, conf);
      CompressionOutputStream out = codec.createOutputStream(System.out);
      IOUtils.copyBytes(System.in, out, 10, false);
    } catch (ClassNotFoundException e) {
      e.printStackTrace();
    } catch (IOException e) {
      e.printStackTrace();
    }
  }
}
