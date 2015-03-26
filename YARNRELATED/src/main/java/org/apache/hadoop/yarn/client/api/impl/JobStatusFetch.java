package org.apache.hadoop.yarn.client.api.impl;

import com.yang.commoncode.core.DynamicClassLoader;
import com.yang.commoncode.core.HttpRequest;
import com.yang.commoncode.core.PojoMapper;
import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.yarn.api.records.ApplicationReport;
import org.apache.hadoop.yarn.exceptions.YarnException;

import java.io.*;
import java.util.List;

/**
 * Created by yang on 2015/3/24.
 */
public class JobStatusFetch {
  YarnClientImpl yarnClient = new YarnClientImpl();
  int numSecond = 500;
  String filleName = "D://status";

  public int getLiveApplicationList() {
    int result = 0;
    new File(filleName).delete();
    try ( BufferedWriter out = new BufferedWriter(new OutputStreamWriter(
        new FileOutputStream(filleName, true)))) {
      yarnClient.serviceInit(new Configuration());
      yarnClient.serviceStart();
      List<ApplicationReport> applications = yarnClient.getApplications();
      for (ApplicationReport applicationReport : applications) {
        if (applicationReport.getProgress() < 1) {
          String url = applicationReport.getTrackingUrl() + "ws/v1/mapreduce/jobs";
          for (int i = 0; i < numSecond; i++) {
            String content = HttpRequest.getURLContent(url, "UTF-8");
            AllJobs jobs = (AllJobs) new PojoMapper().fromJson(content, AllJobs.class);
            int numMapRunning = jobs.getJobs().getJob().get(0).getMapsRunning();
            int numReduceRunning = jobs.getJobs().getJob().get(0).getReducesRunning();
            String line = System.currentTimeMillis() + "\t" + numMapRunning + "\t" + numReduceRunning + "\r\n";
            out.write(line);
            out.flush();
            System.out.println(line);
            Thread.sleep(1000);
          }
        }
      }
    } catch (YarnException e) {
      e.printStackTrace();
    } catch (IOException e) {
      e.printStackTrace();
    } catch (Exception e) {
      e.printStackTrace();
    }
    return result;
  }

  public static void main(String[] args) throws InterruptedException {
    new DynamicClassLoader().loadResourceDir("C:\\Users\\yang\\Desktop\\hadoop2-conf");
    new JobStatusFetch().getLiveApplicationList();
  }

}
