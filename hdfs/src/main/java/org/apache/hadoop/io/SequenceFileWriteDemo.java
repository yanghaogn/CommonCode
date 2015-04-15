package org.apache.hadoop.io;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;

import java.io.IOException;
import java.net.URI;

/**
 * Created by yang on 2015/4/2.
 */
public class SequenceFileWriteDemo {
  private static final String[] DATA={
      "One, two, buckle my shoe",
      "Three, four, shut the door",
      "Five, six, pick up sticks",
      "Sevven, eight, lay them straight",
      "Nine, ten, a big fat hen"
  };
  public static void main(String []args)throws IOException{
    String uri = args[0];
    Configuration conf = new Configuration();
    FileSystem fs = FileSystem.get(URI.create(uri), conf);
    Path path  = new Path(uri);
    IntWritable key = new IntWritable();
    Text value = new Text();
    SequenceFile.Writer writer = null;
    try{
      writer = SequenceFile.createWriter(fs, conf, path, key.getClass(), value.getClass());
      for(int i = 0; i < 100; i++){
        key.set(100 - i);
        System.out.printf("[%s]\t%s\t%s\n", writer.getLength(), key, value);
        value.set(DATA[i % DATA.length]);
      }
      writer.append(key, value);
    }finally {
      IOUtils.closeStream(writer);
    }
  }
}
