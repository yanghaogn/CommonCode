package org.apache.hadoop.io;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.util.ReflectionUtils;

import java.io.IOException;

/**
 * Created by yang on 2015/4/2.
 */
public class SequenceFileReadDemo {
  public static void main(String[] args) throws IOException {
    String uri = args[0];
    Configuration conf = new Configuration();
    Path path = new Path(uri);
    SequenceFile.Reader reader = null;
    FileSystem fs = FileSystem.get(conf);
    try {
      reader = new SequenceFile.Reader(fs, path, conf);
      Writable key = (Writable) ReflectionUtils.newInstance(reader.getKeyClass(), conf);
      Writable value = (Writable) ReflectionUtils.newInstance(reader.getValueClass(), conf);
      long position = reader.getPosition();
      while (reader.next(key, value)) {
        String syncSeen = reader.syncSeen() ? "*" : "";
        System.out.printf("[%s%s]%t%s\n", position, syncSeen, key, value);
        position = reader.getPosition();
      }
    } finally {
      IOUtils.closeStream(reader);
    }
  }
}
