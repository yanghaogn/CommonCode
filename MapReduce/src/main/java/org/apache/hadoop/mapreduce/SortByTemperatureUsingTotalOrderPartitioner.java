package org.apache.hadoop.mapreduce;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.conf.Configured;
import org.apache.hadoop.filecache.DistributedCache;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapred.JobConf;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;
import org.apache.hadoop.mapreduce.lib.partition.InputSampler;
import org.apache.hadoop.mapreduce.lib.partition.TotalOrderPartitioner;
import org.apache.hadoop.util.Tool;
import org.apache.hadoop.util.ToolRunner;

import java.net.URI;

/**
 * Created by yang on 2015/4/20.
 */
public class SortByTemperatureUsingTotalOrderPartitioner extends Configured implements Tool {
  public static void main(String[] args) {
    try {
      int exitCode = ToolRunner.run(new SortByTemperatureUsingTotalOrderPartitioner(), args);
      System.exit(exitCode);
    } catch (Exception e) {
      e.printStackTrace();
    }
  }

  @Override
  public int run(String[] args) throws Exception {
    if (args.length != 2) {
      System.err.printf("Usage: %s [generic options] <input> <output>\n",
          getClass().getSimpleName());
      ToolRunner.printGenericCommandUsage(System.err);
      return -1;
    }
    Job job = new Job(new JobConf(getConf()));
    job.setJarByClass(SortByTemperatureUsingTotalOrderPartitioner.class);
    job.setOutputKeyClass(IntWritable.class);
    job.setOutputValueClass(Text.class);
    
    job.setMapperClass(MaxTemperatureMapper.class);
    job.setReducerClass(MaxTemperatureReducer.class);

    //TotalOrderPartioner
    job.setPartitionerClass(TotalOrderPartitioner.class);
    InputSampler.Sampler<IntWritable, Text> sampler =
        new InputSampler.RandomSampler<IntWritable, Text>(0.1, 10000, job.getNumReduceTasks());
    InputSampler.writePartitionFile(job, sampler);
    Configuration conf = job.getConfiguration();
    String partionFile = TotalOrderPartitioner.getPartitionFile(conf);
    URI partitionUri = new URI(partionFile + "#" + TotalOrderPartitioner.DEFAULT_PATH);
    DistributedCache.addCacheFile(partitionUri, conf);
    DistributedCache.createSymlink(conf);
    
    FileInputFormat.addInputPath(job, new Path(args[0]));
    FileOutputFormat.setOutputPath(job, new Path(args[1]));
    
    return job.waitForCompletion(true)? 0: -1;


    return 0;
  }
}
