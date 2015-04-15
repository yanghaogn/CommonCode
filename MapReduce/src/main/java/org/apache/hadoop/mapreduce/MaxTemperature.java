package org.apache.hadoop.mapreduce;

import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.io.compress.GzipCodec;
import org.apache.hadoop.mapred.JobConf;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;
import org.apache.hadoop.util.GenericOptionsParser;

import java.io.IOException;

/**
 * Created by yang on 2015/3/30.
 */
public class MaxTemperature {
  



  public static void main(String[] args) throws IOException, ClassNotFoundException, InterruptedException {
    JobConf jobConf = new JobConf();
    String[] otherArgs = new GenericOptionsParser(jobConf, args).getRemainingArgs();
    if (otherArgs.length != 2) {
      System.err.println("Usag : MaxTemperature <input path> <output path>");
      System.exit(-1);
    }
    Job job = new Job(jobConf);
    job.setJobName("MaxTemperature");

    job.setJarByClass(MaxTemperature.class);
    job.setOutputKeyClass(Text.class);
    job.setOutputValueClass(IntWritable.class);
    job.setMapperClass(MaxTemperatureMapper.class);
    job.setReducerClass(MaxTemperatureReducer.class);

    //将输出压缩，输出结果为output/part-r-00000.gz
    FileOutputFormat.setCompressOutput(job, true);
    FileOutputFormat.setOutputCompressorClass(job, GzipCodec.class);

    FileInputFormat.addInputPath(job, new Path(otherArgs[0]));
    FileOutputFormat.setOutputPath(job, new Path(otherArgs[1]));
    System.exit(job.waitForCompletion(true) ? 0 : 1);
  }
}
