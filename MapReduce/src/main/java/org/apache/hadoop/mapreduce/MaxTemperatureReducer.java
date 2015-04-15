package org.apache.hadoop.mapreduce;

import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;

import java.io.IOException;

/**
 * Created by yang on 2015/4/2.
 */
public class MaxTemperatureReducer
    extends Reducer<Text, IntWritable, Text, IntWritable> {
  @Override
  public void reduce(Text key, Iterable<IntWritable> values, Context context) throws IOException, InterruptedException {
    int maxTemperature = Integer.MIN_VALUE;
    for (IntWritable value : values) {
      maxTemperature = Math.max(maxTemperature, value.get());
    }
    context.write(key, new IntWritable(maxTemperature));
  }
}