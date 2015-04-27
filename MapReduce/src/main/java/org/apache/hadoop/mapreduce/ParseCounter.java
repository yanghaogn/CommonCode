package org.apache.hadoop.mapreduce;

import org.apache.hadoop.conf.Configuration;

import java.io.IOException;

/**
 * Created by yang on 2015/4/20.
 */
public class ParseCounter {
  public static void main(String []args){
    try {
      Cluster cluster = new Cluster(new Configuration());
      Job job = cluster.getJob(JobID.forName(args[0]));
      Counters counters = job.getCounters();
    } catch (IOException e) {
      e.printStackTrace();
    } catch (InterruptedException e) {
      e.printStackTrace();
    }
  }
}
