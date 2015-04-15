package v1;

import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Mapper;

import java.io.IOException;

/**
 * Created by yang on 2015/4/2.
 */
public class MaxTemperatureMapper extends Mapper<Object, Text, Text, IntWritable> {
  @Override
  protected void map(Object key, Text value, Mapper.Context context) throws IOException, InterruptedException {
    String line = value.toString();
    String year = line.substring(15, 19);
    int airTemperature = Integer.parseInt(line.substring(87,92));
    context.write(new Text(year), new IntWritable(airTemperature));
  }
}
