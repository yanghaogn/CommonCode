package v5;

import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Mapper;
import v4.NcdcRecordParser;
import java.io.IOException;

/**
 * Created by yang on 2015/4/3.
 */
public class MaxTemperatureMapper extends Mapper<Object, Text, Text, IntWritable> {
  enum Temperature{
    OVER_100;
  }
  private NcdcRecordParser parser = new NcdcRecordParser();
  @Override
  public void map(Object key, Text value, Context context) throws IOException, InterruptedException {
    parser.parse(value);
    if(parser.isValidTemperature()){
      if(parser.getAirTemperature() > 1000){
        System.err.println("Temperature is over 100 for record: " + value.toString());
        context.setStatus("Detect possible broken record, see logs.");
        context.getCounter(Temperature.OVER_100).increment(1);
      }
      context.write(new Text(parser.getYear()),
          new IntWritable(parser.getAirTemperature()));
    }
  }
}
