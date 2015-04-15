package org.apache.hadoop.mapreduce;

import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.NullWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mrunit.mapreduce.MapDriver;
import org.apache.hadoop.mrunit.mapreduce.ReduceDriver;
import org.junit.Test;

import java.io.IOException;
import java.util.Arrays;

/**
 * Created by yang on 2015/4/2.
 */
public class TestMaxTemperature {
  @Test
  public void processesValidRecord() throws IOException {
    Text value = new Text("0043011990999991950051518004+68750+023550FM-12+0382" + 
    "99999V0203201N00261220001CN9999999N9-00111+99999999999");
    new MapDriver<Object, Text, Text, IntWritable>()
        .withMapper(new MaxTemperature.MaxTemperatureMapper())
        .withInput(NullWritable.get(), value)
        .withOutput(new Text("1950"), new IntWritable(-11))
        .runTest();
  }
  @Test
  public void testIgnoresMissingTemperatureRecord() throws IOException {
    Text value = new Text("0043011990999991950051518004+68750+023550FM-12+0382" +
        "99999V0203201N00261220001CN9999999N9+9999+99999999999");
    new MapDriver<Object, Text, Text, IntWritable>()
        .withMapper(new v2.MaxTemperatureMapper())
        .withInput(NullWritable.get(), value)
        .runTest();
  }
  @Test
  public void returnsMaximumIntegerInValues() throws IOException {
    new ReduceDriver<Text, IntWritable, Text, IntWritable>()
        .withReducer(new MaxTemperature.MaxTemperatureReducer())
        .withInput(new Text("1950"), Arrays.asList(new IntWritable(10), new IntWritable(5)))
        .withOutput(new Text("1950"), new IntWritable(10))
        .runTest();
  }
}
