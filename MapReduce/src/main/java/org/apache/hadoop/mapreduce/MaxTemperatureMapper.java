package org.apache.hadoop.mapreduce;

import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;

import java.io.IOException;

/**
 * Created by yang on 2015/4/2.
 */
public class MaxTemperatureMapper
    extends Mapper<Object, Text, Text, IntWritable> {
  private static final int MISSING = 9999;

  @Override
  public void map(Object key, Text value, Context context) throws IOException, InterruptedException {
    String line = value.toString();
    String year = line.substring(15, 19);
    int airTemperature;
    if (line.charAt(87) == '+') {
      airTemperature = Integer.parseInt(line.substring(88, 92));
    } else {
      airTemperature = Integer.parseInt(line.substring(87, 92));
    }
    String quality = line.substring(92, 93);
    if (airTemperature != MISSING && quality.matches("[01459]")) {
      context.write(new Text((year)), new IntWritable(airTemperature));
    }
  }
}