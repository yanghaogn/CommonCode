package v2;

import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Mapper;

import java.io.IOException;

/**
 * Created by yang on 2015/4/2.
 */
public class MaxTemperatureMapper extends Mapper<Object, Text, Text, IntWritable> {
  @Override
  public void map(Object key, Text value, Context context) throws IOException, InterruptedException {
    String line = value.toString();
    String year = line.substring(15, 19);
    String temp = line.substring(87, 92);
    if(!missing(temp)){
      context.write(new Text(year), new IntWritable(Integer.parseInt(temp)));
    }
  }
  public boolean missing(String value){
    return "+9999".equals(value);
  }
}
