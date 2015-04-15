package org.apache.hadoop.io;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;

import java.io.IOException;
import java.net.URI;

/**
 * Created by yang on 2015/4/2.
 */
public class MapFileFixer {
  public static void main(String [] args) throws Exception {
    String mapUri = args[0];
    Configuration conf = new Configuration();
    FileSystem fs = FileSystem.get(URI.create(mapUri), conf);
    Path path = new Path(mapUri);
    SequenceFile.Reader reader = new SequenceFile.Reader(fs,path, conf);
    Class keyClass = reader.getKeyClass();
    Class valueClass = reader.getValueClass();
    reader.close();
    long entries = MapFile.fix(fs, path, keyClass, valueClass, false, conf);
    System.out.printf("Created MapFile %s with %d entries\n", path, entries);
  }
}
