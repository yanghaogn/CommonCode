package v5;

import org.apache.hadoop.conf.Configured;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapred.JobConf;
import org.apache.hadoop.mapred.JobContext;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;
import org.apache.hadoop.util.Tool;
import org.apache.hadoop.util.ToolRunner;

/**
 * Created by yang on 2015/4/2.
 */
public class MaxTemperatureDriver extends Configured implements Tool {
  @Override
  public int run(String[] args) throws Exception {
    if (args.length != 2) {
      System.err.printf("Usage: %s [generic options] <input> <output>\n",
          getClass().getSimpleName());
      ToolRunner.printGenericCommandUsage(System.err);
      return -1;
    }
    Job job = new Job(new JobConf(getConf()));
    job.setJobName("Max temperature");
    job.setJarByClass(getClass());

    FileInputFormat.addInputPath(job, new Path(args[0]));
    FileOutputFormat.setOutputPath(job, new Path(args[1]));

    job.setMapperClass(MaxTemperatureMapper.class);
    job.setReducerClass(MaxTemperatureReducer.class);
    job.setCombinerClass(MaxTemperatureReducer.class);
    job.setOutputKeyClass(Text.class);
    job.setOutputValueClass(IntWritable.class);

    job.getConfiguration().setBoolean(JobContext.TASK_PROFILE, true);
    job.getConfiguration().set(JobContext.TASK_PROFILE_PARAMS, "-agentlib:hprof=cpu=samples," +
        "heap=sites,depth=6,force=n,thread=y,verbose=n,file=%s");
    job.getConfiguration().set(JobContext.NUM_MAP_PROFILES, "0-2");
    job.getConfiguration().set(JobContext.NUM_REDUCE_PROFILES, ""); // no reduces
    return job.waitForCompletion(true) ? 0 : -1;
  }

  public static void main(String[] args) throws Exception {
    int exitCode = ToolRunner.run(new MaxTemperatureDriver(), args);
    System.exit(exitCode);
  }
}
