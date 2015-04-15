package v3;

import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Mapper;

import java.io.IOException;

/**
 * Created by yang on 2015/4/3.
 */
public class MaxTemperatureMapper extends Mapper<Object, Text, Text, IntWritable> {
  private NcdcRecordParser parser = new NcdcRecordParser();
  @Override
  public void map(Object key, Text value, Context context) throws IOException, InterruptedException {
    parser.parse(value);
    if(parser.isValidTemperature()){
      context.write(new Text(parser.getYear()),
          new IntWritable(parser.getAirTemperature()));
    }
  }
}
